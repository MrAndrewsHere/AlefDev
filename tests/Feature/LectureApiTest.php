<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Domain\Classroom\Models\Classroom;
use App\Domain\Lecture\Models\Lecture;
use App\Domain\Student\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LectureApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_paginated_lectures(): void
    {
        Lecture::factory()->count(3)->create();

        $testResponse = $this->getJson(route('lectures.index'));

        $testResponse->assertOk()
            ->assertJsonStructure([
                'data' => [
                    ['id', 'topic', 'description', 'classrooms', 'students'],
                ],
                'links' => ['first', 'last', 'prev', 'next'],
                'meta' => ['current_page', 'from', 'last_page', 'links', 'path', 'per_page', 'to', 'total'],
            ])
            ->assertJsonPath('meta.total', 3);
    }

    public function test_show_returns_lecture_with_relations(): void
    {
        $lecture = Lecture::factory()->create();
        $classroom = Classroom::factory()->create();
        $student = Student::factory()->create();

        $classroom->lectures()->attach($lecture->id, ['position' => 1]);
        $lecture->students()->attach($student->id, ['attended_at' => now()]);

        $testResponse = $this->getJson(route('lectures.show', $lecture));

        $testResponse->assertOk()
            ->assertJsonStructure(['id', 'topic', 'description', 'classrooms', 'students'])
            ->assertJsonPath('id', $lecture->id)
            ->assertJson(fn ($json) => $json->has('classrooms.0.id')->etc())
            ->assertJson(fn ($json) => $json->has('students.0.id')->etc());
    }

    public function test_store_update_destroy_lecture(): void
    {
        $testResponse = $this->postJson(route('lectures.store'), ['topic' => 'Intro', 'description' => 'Basics']);
        $testResponse->assertCreated()->assertJsonPath('topic', 'Intro');

        $id = $testResponse->json('id');

        $update = $this->putJson(route('lectures.update', $id), ['topic' => 'Intro Updated']);
        $update->assertOk()->assertJsonPath('topic', 'Intro Updated');

        $delete = $this->deleteJson(route('lectures.destroy', $id));
        $delete->assertNoContent();

        $this->assertDatabaseMissing('lectures', ['id' => $id]);
    }
}

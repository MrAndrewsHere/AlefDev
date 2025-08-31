<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Domain\Classroom\Models\Classroom;
use App\Domain\Lecture\Models\Lecture;
use App\Domain\Student\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClassroomApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_paginated_classes(): void
    {
        Classroom::factory()->count(2)->create();

        $testResponse = $this->getJson(route('classes.index'));

        $testResponse->assertOk()
            ->assertJsonStructure([
                'data' => [
                    ['id', 'name', 'students'],
                ],
                'links' => ['prev', 'next'],
                'meta' => ['current_page', 'from', 'last_page', 'links', 'path', 'per_page', 'to', 'total'],
            ])
            ->assertJsonPath('meta.total', 2);
    }

    public function test_show_returns_class_with_students(): void
    {
        $classroom = Classroom::factory()->create();
        Student::factory()->count(2)->create(['classroom_id' => $classroom->id]);

        $testResponse = $this->getJson(route('classes.show', $classroom));

        $testResponse->assertOk()
            ->assertJsonStructure(['id', 'name', 'students'])
            ->assertJsonPath('id', $classroom->id)
            ->assertJson(fn ($json) => $json->has('students.0.id')->etc());
    }

    public function test_store_update_destroy_class(): void
    {
        $testResponse = $this->postJson(route('classes.store'), ['name' => 'Group A']);
        $testResponse->assertCreated()->assertJsonPath('name', 'Group A');

        $id = $testResponse->json('id');

        $update = $this->putJson(route('classes.update', $id), ['name' => 'Group A1']);
        $update->assertOk()->assertJsonPath('name', 'Group A1');

        $delete = $this->deleteJson(route('classes.destroy', $id));
        $delete->assertNoContent();

        $this->assertDatabaseMissing('classrooms', ['id' => $id]);
    }

    public function test_delete_class_detaches_students(): void
    {
        $classroom = Classroom::factory()->create();
        $student = Student::factory()->withClassroom($classroom)->create();

        $this->deleteJson(route('classes.destroy', $classroom))->assertNoContent();

        $this->assertDatabaseHas('students', ['id' => $student->id, 'classroom_id' => null]);
    }

    public function test_curriculum_get_and_upsert(): void
    {
        $classroom = Classroom::factory()->create();
        $lectures = Lecture::factory()->count(3)->create();

        $payload = [
            'lectures' => [
                ['lecture_id' => $lectures[1]->id, 'position' => 2],
                ['lecture_id' => $lectures[0]->id, 'position' => 1],
                ['lecture_id' => $lectures[2]->id, 'position' => 3],
            ],
        ];

        $testResponse = $this->putJson(route('classes.upsertCurriculum', $classroom), $payload);
        $testResponse->assertOk()
            ->assertJsonStructure(['data' => [['id', 'topic', 'description']]]);

        // Expect order by position 1,2,3
        $orderedIds = array_column($testResponse->json('data'), 'id');
        $this->assertSame([$lectures[0]->id, $lectures[1]->id, $lectures[2]->id], $orderedIds);

        $get = $this->getJson(route('classes.curriculum', $classroom));
        $get->assertOk()->assertJsonPath('data.0.id', $lectures[0]->id);
    }
}

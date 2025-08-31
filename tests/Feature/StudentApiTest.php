<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Domain\Classroom\Models\Classroom;
use App\Domain\Lecture\Models\Lecture;
use App\Domain\Student\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_paginated_students(): void
    {
        $classroom = Classroom::factory()->create();
        $lecture = Lecture::factory()->create();

        $students = Student::factory()->count(3)->create(['classroom_id' => $classroom->id]);
        $students->first()->lectures()->attach($lecture->id, ['attended_at' => now()]);

        $testResponse = $this->getJson(route('students.index'));

        $testResponse->assertOk()
            ->assertJsonStructure([
                'data' => [
                    ['id', 'name', 'email', 'classroom', 'lectures'],
                ],
                'links' => ['first', 'last', 'prev', 'next'],
                'meta' => ['current_page', 'from', 'last_page', 'links', 'path', 'per_page', 'to', 'total'],
            ])
            ->assertJsonPath('meta.total', 3);
    }

    public function test_show_returns_detailed_student_with_relations(): void
    {
        $classroom = Classroom::factory()->create();
        $lecture = Lecture::factory()->create();
        $student = Student::factory()->create(['classroom_id' => $classroom->id]);
        $student->lectures()->attach($lecture->id, ['attended_at' => now()]);

        $testResponse = $this->getJson(route('students.show', $student));

        $testResponse->assertOk()
            ->assertJsonStructure(['id', 'name', 'email', 'classroom', 'lectures'])
            ->assertJsonPath('id', $student->id)
            ->assertJsonPath('classroom.id', $classroom->id)
            ->assertJson(fn ($json) => $json->has('lectures.0.id')->etc());
    }

    public function test_store_creates_student(): void
    {
        $classroom = Classroom::factory()->create();
        $payload = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'classroom_id' => $classroom->id,
        ];

        $testResponse = $this->postJson(route('students.store'), $payload);

        $testResponse->assertCreated()
            ->assertJsonPath('name', 'John Doe')
            ->assertJsonPath('email', 'john.doe@example.com')
            ->assertJsonPath('classroom.id', $classroom->id);

        $this->assertDatabaseHas('students', ['email' => 'john.doe@example.com', 'classroom_id' => $classroom->id]);
    }

    public function test_store_validates_input(): void
    {
        $testResponse = $this->postJson(route('students.store'), [
            'name' => '',
            'email' => 'not-an-email',
        ]);

        $testResponse->assertStatus(422);
    }

    public function test_update_student(): void
    {
        $student = Student::factory()->create(['name' => 'Old Name', 'email' => 'old@example.com']);

        $testResponse = $this->putJson(route('students.update', $student), [
            'name' => 'New Name',
            'email' => 'old@example.com',
        ]);

        $testResponse->assertOk()->assertJsonPath('name', 'New Name');
        $this->assertDatabaseHas('students', ['id' => $student->id, 'name' => 'New Name']);
    }

    public function test_destroy_student(): void
    {
        $student = Student::factory()->create();

        $testResponse = $this->deleteJson(route('students.destroy', $student));

        $testResponse->assertNoContent();
        $this->assertDatabaseMissing('students', ['id' => $student->id]);
    }
}

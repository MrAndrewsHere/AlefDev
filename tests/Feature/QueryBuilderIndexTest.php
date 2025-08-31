<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Domain\Classroom\Models\Classroom;
use App\Domain\Lecture\Models\Lecture;
use App\Domain\Student\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QueryBuilderIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_students_index_allows_filter_and_sort(): void
    {
        $c1 = Classroom::factory()->create();
        $c2 = Classroom::factory()->create();

        Student::factory()->create(['name' => 'Alice', 'email' => 'alice@example.com', 'classroom_id' => $c1->id]);
        Student::factory()->create(['name' => 'Bob', 'email' => 'bob@example.com', 'classroom_id' => $c2->id]);
        Student::factory()->create(['name' => 'Bobby', 'email' => 'bobby@example.com', 'classroom_id' => $c2->id]);

        $testResponse = $this->getJson(route('students.index', ['filter[name]' => 'bob', 'filter[classroom_id]' => $c2->id, 'sort' => 'name']));

        $testResponse->assertOk()
            ->assertJsonPath('meta.total', 2)
            ->assertJsonPath('data.0.name', 'Bob')
            ->assertJsonPath('data.1.name', 'Bobby');
    }

    public function test_classes_index_allows_filter_and_sort(): void
    {
        Classroom::factory()->create(['name' => 'Physics']);
        Classroom::factory()->create(['name' => 'Philosophy']);
        Classroom::factory()->create(['name' => 'Biology']);

        $testResponse = $this->getJson(route('classes.index', ['filter[name]' => 'ph', 'sort' => 'name']));

        $testResponse->assertOk()
            ->assertJsonPath('meta.total', 2)
            ->assertJsonPath('data.0.name', 'Philosophy')
            ->assertJsonPath('data.1.name', 'Physics');
    }

    public function test_lectures_index_allows_filter_and_sort(): void
    {
        Lecture::factory()->create(['topic' => 'Arrays', 'description' => 'Data structures']);
        Lecture::factory()->create(['topic' => 'Algebra', 'description' => 'Math basics']);
        Lecture::factory()->create(['topic' => 'Physics', 'description' => 'Mechanics']);

        $testResponse = $this->getJson(route('lectures.index', ['filter[topic]' => 'a', 'sort' => 'topic']));

        $testResponse->assertOk()
            ->assertJsonPath('meta.total', 2)
            ->assertJsonPath('data.0.topic', 'Algebra')
            ->assertJsonPath('data.1.topic', 'Arrays');

        $resp2 = $this->getJson(route('lectures.index', ['filter[description]' => 'Mech']));
        $resp2->assertOk()->assertJsonPath('meta.total', 1)->assertJsonPath('data.0.topic', 'Physics');
    }
}

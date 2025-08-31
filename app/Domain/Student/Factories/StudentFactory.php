<?php

declare(strict_types=1);

namespace App\Domain\Student\Factories;

use App\Domain\Classroom\Models\Classroom;
use App\Domain\Student\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Student>
 */
class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'classroom_id' => null,
        ];
    }

    public function withClassroom(?Classroom $classroom = null): static
    {
        return $this->state(function () use ($classroom): array {

            return [
                'classroom_id' => $classroom instanceof Classroom ? $classroom->id : Classroom::factory(),
            ];
        });
    }
}

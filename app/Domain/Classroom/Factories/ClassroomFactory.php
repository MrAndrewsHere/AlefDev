<?php

declare(strict_types=1);

namespace App\Domain\Classroom\Factories;

use App\Domain\Classroom\Models\Classroom;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Classroom>
 */
class ClassroomFactory extends Factory
{
    protected $model = Classroom::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->company().' Class',
        ];
    }
}

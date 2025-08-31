<?php

declare(strict_types=1);

namespace App\Domain\Lecture\Factories;

use App\Domain\Lecture\Models\Lecture;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Lecture>
 */
class LectureFactory extends Factory
{
    protected $model = Lecture::class;

    public function definition(): array
    {
        return [
            'topic' => $this->faker->unique()->sentence(3),
            'description' => $this->faker->optional()->paragraph(),
        ];
    }
}

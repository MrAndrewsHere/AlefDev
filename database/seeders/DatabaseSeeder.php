<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Domain\Classroom\Models\Classroom;
use App\Domain\Lecture\Models\Lecture;
use App\Domain\Student\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Throwable;

class DatabaseSeeder extends Seeder
{
    /**
     * @throws Throwable
     */
    public function run(): void
    {

        DB::transaction(function (): void {
            $lectureCount = 30;
            $classroomCount = 10;
            $studentCount = 200;

            $lectures = Lecture::factory()->count($lectureCount)->create();
            $lectureIds = $lectures->pluck('id')->all();

            $classrooms = Classroom::factory()->count($classroomCount)->create();

            foreach ($classrooms as $classroom) {
                $pick = random_int(5, 10);
                $selected = Arr::random($lectureIds, min($pick, count($lectureIds)));

                $positioned = [];
                $pos = 1;
                foreach ((array) $selected as $lid) {
                    $positioned[$lid] = ['position' => $pos++];
                }
                $classroom->lectures()->sync($positioned);
            }

            $classroomIdPool = $classrooms->pluck('id')->all();

            $chunkSize = 100;
            $remaining = $studentCount;
            while ($remaining > 0) {
                $make = min($chunkSize, $remaining);
                $remaining -= $make;

                $batch = Student::factory()->count($make)->make()->each(function (Student $student) use ($classroomIdPool): void {
                    if (! empty($classroomIdPool)) {
                        $student->classroom_id = Arr::random($classroomIdPool);
                    }
                });

                Student::query()->insert($batch->map(fn (Student $student): array => [
                    'name' => $student->name,
                    'email' => $student->email,
                    'classroom_id' => $student->classroom_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ])->all());
            }

            Student::query()->orderBy('id')->chunkById(200, function ($students) use ($classrooms): void {
                foreach ($students as $student) {
                    /** @var Student $student */
                    $classroom = $classrooms->firstWhere('id', $student->classroom_id);
                    $availableLectureIds = $classroom?->lectures->pluck('id')->all() ?? [];
                    if (empty($availableLectureIds)) {
                        $availableLectureIds = Lecture::query()->pluck('id')->all();
                    }
                    if (empty($availableLectureIds)) {
                        continue;
                    }

                    $toAttend = random_int(3, min(12, count($availableLectureIds)));
                    $picked = Arr::random($availableLectureIds, $toAttend);
                    $attend = [];
                    $now = now();
                    foreach ((array) $picked as $lid) {
                        $attend[$lid] = [
                            'attended_at' => Carbon::instance($now)->subDays(random_int(0, 60)),
                            'created_at' => $now,
                            'updated_at' => $now,
                        ];
                    }
                    $student->lectures()->syncWithoutDetaching($attend);
                }
            });
        });

        if ($this->command !== null) {
            $this->command->info('Seeding complete:');
            $this->command->line(' - Lectures: '.Lecture::query()->count());
            $this->command->line(' - Classrooms: '.Classroom::query()->count());
            $this->command->line(' - Students: '.Student::query()->count());
        }
    }
}

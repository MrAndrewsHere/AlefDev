<?php

declare(strict_types=1);

namespace App\Domain\Lecture\DTOs;

use App\Domain\Classroom\DTOs\ClassroomData;
use App\Domain\Classroom\Models\Classroom;
use App\Domain\Lecture\Models\Lecture;
use App\Domain\Share\DTOs\BaseDTO;
use App\Domain\Student\DTOs\StudentData;
use App\Domain\Student\Models\Student;

final class LectureData extends BaseDTO
{
    public function __construct(
        public int $id,
        public string $topic,
        public ?string $description = null,
        /** @var list<ClassroomData> */
        public array $classrooms = [],
        /** @var list<StudentData> */
        public array $students = [],
    ) {}

    public static function fromModel(Lecture $lecture): self
    {
        return new self(
            id: $lecture->id,
            topic: $lecture->topic,
            description: $lecture->description,
            classrooms: $lecture->relationLoaded('classrooms')
                ? array_values(array_map(static fn (Classroom $classroom): ClassroomData => ClassroomData::fromModel($classroom), $lecture->classrooms->all()))
                : [],
            students: $lecture->relationLoaded('students')
                ? array_values(array_map(static fn (Student $student): StudentData => StudentData::fromModel($student), $lecture->students->all()))
                : [],
        );
    }
}

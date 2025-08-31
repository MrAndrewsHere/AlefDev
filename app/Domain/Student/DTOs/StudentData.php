<?php

declare(strict_types=1);

namespace App\Domain\Student\DTOs;

use App\Domain\Classroom\DTOs\ClassroomData;
use App\Domain\Classroom\Models\Classroom;
use App\Domain\Lecture\DTOs\LectureData;
use App\Domain\Lecture\Models\Lecture;
use App\Domain\Share\DTOs\BaseDTO;
use App\Domain\Student\Models\Student;

final class StudentData extends BaseDTO
{
    public function __construct(
        public ?int $id,
        public ?string $name,
        public ?string $email,
        public ?ClassroomData $classroom = null,
        /** @var list<LectureData> */
        public ?array $lectures = [],
    ) {}

    public static function fromModel(Student $student): self
    {
        return new self(
            id: $student->id,
            name: $student->name,
            email: $student->email,
            classroom: $student->relationLoaded('classroom') && $student->classroom instanceof Classroom
                ? ClassroomData::fromModel($student->classroom)
                : null,
            lectures: $student->relationLoaded('lectures')
                ? array_values(array_map(static fn (Lecture $lecture): LectureData => LectureData::fromModel($lecture), $student->lectures->all()))
                : [],
        );
    }
}

<?php

declare(strict_types=1);

namespace App\Domain\Classroom\DTOs;

use App\Domain\Classroom\Models\Classroom as ClassroomModel;
use App\Domain\Share\DTOs\BaseDTO;
use App\Domain\Student\DTOs\StudentData;
use App\Domain\Student\Models\Student;

final class ClassroomData extends BaseDTO
{
    public function __construct(
        public int $id,
        public string $name,
        /** @var list<StudentData> */
        public ?array $students = null,
    ) {}

    public static function fromModel(ClassroomModel $classroomModel): self
    {
        return new self(
            id: $classroomModel->id,
            name: $classroomModel->name,
            students: $classroomModel->relationLoaded('students')
                ? array_values(array_map(static fn (Student $student): StudentData => StudentData::fromModel($student), $classroomModel->students->all()))
                : null,
        );
    }
}

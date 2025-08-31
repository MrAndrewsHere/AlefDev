<?php

declare(strict_types=1);

namespace App\Domain\Student\DTOs;

use App\Domain\Classroom\DTOs\ClassroomData;
use App\Domain\Classroom\Models\Classroom;
use App\Domain\Share\DTOs\BaseDTO;
use App\Domain\Student\Models\Student;
use App\Domain\Student\Requests\StudentUpdateRequest;
use Spatie\LaravelData\Optional;

final class StudentUpdateData extends BaseDTO
{
    public function __construct(
        public string|Optional $name,
        public string|Optional $email,
        public ClassroomData|null|Optional $classroom = null
    ) {}

    public static function fromModel(Student $student): self
    {
        return StudentUpdateData::fromModel($student);
    }

    public static function fromRequest(StudentUpdateRequest $studentUpdateRequest): StudentUpdateData
    {
        return new self(
            name: $studentUpdateRequest->validated('name') ?? new Optional,
            email: $studentUpdateRequest->validated('email') ?? new Optional,
            classroom: $studentUpdateRequest->has('classroom_id') ? ClassroomData::fromModel(Classroom::query()->find($studentUpdateRequest->validated('classroom_id'))) : new Optional
        );
    }
}

<?php

declare(strict_types=1);

namespace App\Domain\Student\DTOs;

use App\Domain\Classroom\DTOs\ClassroomData;
use App\Domain\Classroom\Models\Classroom;
use App\Domain\Share\DTOs\BaseDTO;
use App\Domain\Student\Models\Student;
use App\Domain\Student\Requests\StudentStoreRequest;
use Spatie\LaravelData\Optional;

final class StudentStoreData extends BaseDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public ClassroomData|null|Optional $classroom = null
    ) {}

    public static function fromModel(Student $student): self
    {
        return new self(
            name: $student->name,
            email: $student->email,
            classroom: $student->relationLoaded('classroom') && $student->classroom instanceof Classroom
                ? ClassroomData::fromModel($student->classroom)
                : null
        );
    }

    public static function fromRequest(StudentStoreRequest $studentStoreRequest): StudentStoreData
    {
        return new self(
            name: $studentStoreRequest->validated('name'),
            email: $studentStoreRequest->validated('email'),
            classroom: $studentStoreRequest->has('classroom_id') ? ClassroomData::fromModel(Classroom::query()->find($studentStoreRequest->validated('classroom_id'))) : new Optional
        );
    }
}

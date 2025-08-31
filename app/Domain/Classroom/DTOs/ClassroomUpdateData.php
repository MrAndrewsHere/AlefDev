<?php

declare(strict_types=1);

namespace App\Domain\Classroom\DTOs;

use App\Domain\Classroom\Requests\ClassroomUpdateRequest;
use App\Domain\Share\DTOs\BaseDTO;
use Spatie\LaravelData\Optional;

final class ClassroomUpdateData extends BaseDTO
{
    public function __construct(
        public string|Optional $name
    ) {}

    public static function fromRequest(ClassroomUpdateRequest $classroomUpdateRequest): ClassroomUpdateData
    {
        return new self($classroomUpdateRequest->has('name') ? $classroomUpdateRequest->validated('name') : new Optional);
    }
}

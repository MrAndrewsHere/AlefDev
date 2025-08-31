<?php

declare(strict_types=1);

namespace App\Domain\Classroom\DTOs;

use App\Domain\Classroom\Requests\ClassroomStoreRequest;
use App\Domain\Share\DTOs\BaseDTO;

final class ClassroomStoreData extends BaseDTO
{
    public function __construct(
        public string $name
    ) {}

    public static function fromRequest(ClassroomStoreRequest $classroomStoreRequest): ClassroomStoreData
    {
        return new self($classroomStoreRequest->validated('name'));
    }
}

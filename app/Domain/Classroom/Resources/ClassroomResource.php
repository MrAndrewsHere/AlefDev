<?php

declare(strict_types=1);

namespace App\Domain\Classroom\Resources;

use App\Domain\Classroom\Models\Classroom;
use App\Domain\Share\Resources\BaseResource;
use App\Domain\Student\Resources\StudentResource;

/**
 * @mixin Classroom
 */
class ClassroomResource extends BaseResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        /** @var Classroom $classroom */
        $classroom = $this->resource;

        return [
            'id' => $classroom->id,
            'name' => $classroom->name,
            'students' => $classroom->relationLoaded('students')
                ? StudentResource::collection($classroom->students)
                : [],
        ];
    }
}

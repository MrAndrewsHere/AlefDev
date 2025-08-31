<?php

declare(strict_types=1);

namespace App\Domain\Student\Resources;

use App\Domain\Classroom\Models\Classroom;
use App\Domain\Classroom\Resources\ClassroomResource;
use App\Domain\Lecture\Resources\LectureResource;
use App\Domain\Share\Resources\BaseResource;
use App\Domain\Student\Models\Student;

/**
 * @mixin Student
 */
class StudentResource extends BaseResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        /** @var Student $student */
        $student = $this->resource;

        return [
            'id' => $student->id,
            'name' => $student->name,
            'email' => $student->email,
            'classroom' => $student->relationLoaded('classroom') && $student->classroom instanceof Classroom
                ? new ClassroomResource($student->classroom)
                : null,
            'lectures' => $student->relationLoaded('lectures')
                ? LectureResource::collection($student->lectures)
                : [],
        ];
    }
}

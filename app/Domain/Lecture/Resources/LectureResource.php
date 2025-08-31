<?php

declare(strict_types=1);

namespace App\Domain\Lecture\Resources;

use App\Domain\Classroom\Resources\ClassroomResource;
use App\Domain\Lecture\Models\Lecture;
use App\Domain\Share\Resources\BaseResource;
use App\Domain\Student\Resources\StudentResource;

/**
 * @mixin Lecture
 */
class LectureResource extends BaseResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        /** @var Lecture $lecture */
        $lecture = $this->resource;

        return [
            'id' => $lecture->id,
            'topic' => $lecture->topic,
            'description' => $lecture->description,
            'classrooms' => $lecture->relationLoaded('classrooms')
                ? ClassroomResource::collection($lecture->classrooms)
                : [],
            'students' => $lecture->relationLoaded('students')
                ? StudentResource::collection($lecture->students)
                : [],
        ];
    }
}

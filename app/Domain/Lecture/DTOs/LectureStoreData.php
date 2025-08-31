<?php

declare(strict_types=1);

namespace App\Domain\Lecture\DTOs;

use App\Domain\Lecture\Models\Lecture;
use App\Domain\Lecture\Requests\LectureStoreRequest;
use App\Domain\Share\DTOs\BaseDTO;
use Spatie\LaravelData\Optional;

final class LectureStoreData extends BaseDTO
{
    public function __construct(
        public string $topic,
        public string|null|Optional $description = null
    ) {}

    public static function fromModel(Lecture $lecture): self
    {
        return new self(
            topic: $lecture->topic,
            description: $lecture->description
        );
    }

    public static function fromRequest(LectureStoreRequest $lectureStoreRequest): LectureStoreData
    {
        return new self(
            $lectureStoreRequest->validated('topic'),
            $lectureStoreRequest->has('description') ? $lectureStoreRequest->validated('description') : new Optional,
        );
    }
}

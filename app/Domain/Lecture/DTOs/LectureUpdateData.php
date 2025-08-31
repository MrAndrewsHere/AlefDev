<?php

declare(strict_types=1);

namespace App\Domain\Lecture\DTOs;

use App\Domain\Lecture\Models\Lecture;
use App\Domain\Lecture\Requests\LectureUpdateRequest;
use App\Domain\Share\DTOs\BaseDTO;
use Spatie\LaravelData\Optional;

final class LectureUpdateData extends BaseDTO
{
    public function __construct(
        public string|Optional $topic,
        public string|null|Optional $description = null
    ) {}

    public static function fromModel(Lecture $lecture): self
    {
        return new self(
            topic: $lecture->topic,
            description: $lecture->description
        );
    }

    public static function fromRequest(LectureUpdateRequest $lectureUpdateRequest): LectureUpdateData
    {
        return new self(
            $lectureUpdateRequest->validated('topic') ?? new Optional,
            $lectureUpdateRequest->has('description') ? $lectureUpdateRequest->validated('description') : new Optional,
        );
    }
}

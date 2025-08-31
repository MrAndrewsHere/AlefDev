<?php

declare(strict_types=1);

namespace App\Domain\Lecture\Requests;

use App\Domain\Lecture\DTOs\LectureUpdateData;
use Illuminate\Foundation\Http\FormRequest;

class LectureUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'topic' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function dto(): LectureUpdateData
    {
        return LectureUpdateData::fromRequest($this);
    }
}

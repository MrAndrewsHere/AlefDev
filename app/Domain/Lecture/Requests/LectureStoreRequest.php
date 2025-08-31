<?php

declare(strict_types=1);

namespace App\Domain\Lecture\Requests;

use App\Domain\Lecture\DTOs\LectureStoreData;
use Illuminate\Foundation\Http\FormRequest;

class LectureStoreRequest extends FormRequest
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
            'topic' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function dto(): LectureStoreData
    {
        return LectureStoreData::fromRequest($this);
    }
}

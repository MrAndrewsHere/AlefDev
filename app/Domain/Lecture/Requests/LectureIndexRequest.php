<?php

declare(strict_types=1);

namespace App\Domain\Lecture\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LectureIndexRequest extends FormRequest
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
            'filter.topic' => ['string', 'max:255'],
            'filter.description' => ['string', 'max:255'],
        ];
    }
}

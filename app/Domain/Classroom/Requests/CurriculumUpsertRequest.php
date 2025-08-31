<?php

declare(strict_types=1);

namespace App\Domain\Classroom\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CurriculumUpsertRequest extends FormRequest
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
            'lectures' => ['required', 'array', 'min:1'],
            'lectures.*.lecture_id' => ['required', 'integer', 'exists:lectures,id', 'distinct'],
            'lectures.*.position' => ['required', 'integer', 'min:1'],
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Domain\Student\Requests;

use App\Domain\Student\DTOs\StudentUpdateData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudentUpdateRequest extends FormRequest
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
        $studentId = $this->route('student')->id ?? null;

        return [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'email' => [
                'sometimes', 'required', 'string', 'email', 'max:255',
                Rule::unique('students', 'email')->ignore($studentId),
            ],
            'classroom_id' => ['sometimes', 'nullable', 'integer', 'exists:classrooms,id'],
        ];
    }

    public function dto(): StudentUpdateData
    {
        return StudentUpdateData::fromRequest($this);

    }
}

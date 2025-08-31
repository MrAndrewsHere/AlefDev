<?php

declare(strict_types=1);

namespace App\Domain\Student\Requests;

use App\Domain\Student\DTOs\StudentStoreData;
use Illuminate\Foundation\Http\FormRequest;

class StudentStoreRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:students,email'],
            'classroom_id' => ['sometimes', 'nullable', 'integer', 'exists:classrooms,id'],
        ];
    }

    public function dto(): StudentStoreData
    {
        return StudentStoreData::fromRequest($this);
    }
}

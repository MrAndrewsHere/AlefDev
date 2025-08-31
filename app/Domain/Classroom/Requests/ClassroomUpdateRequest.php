<?php

declare(strict_types=1);

namespace App\Domain\Classroom\Requests;

use App\Domain\Classroom\DTOs\ClassroomUpdateData;
use Illuminate\Foundation\Http\FormRequest;

class ClassroomUpdateRequest extends FormRequest
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
            'name' => ['sometimes', 'required', 'string', 'max:255'],
        ];
    }

    public function dto(): ClassroomUpdateData
    {
        return ClassroomUpdateData::fromRequest($this);
    }
}

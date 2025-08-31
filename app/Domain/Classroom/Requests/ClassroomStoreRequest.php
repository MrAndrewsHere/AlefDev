<?php

declare(strict_types=1);

namespace App\Domain\Classroom\Requests;

use App\Domain\Classroom\DTOs\ClassroomStoreData;
use Illuminate\Foundation\Http\FormRequest;

class ClassroomStoreRequest extends FormRequest
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
        ];
    }

    public function dto(): ClassroomStoreData
    {
        return ClassRoomStoreData::fromRequest($this);
    }
}

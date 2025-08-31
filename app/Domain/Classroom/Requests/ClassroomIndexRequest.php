<?php

declare(strict_types=1);

namespace App\Domain\Classroom\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClassroomIndexRequest extends FormRequest
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
            'filter.name' => ['string'],
        ];
    }
}

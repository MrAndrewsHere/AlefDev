<?php

declare(strict_types=1);

namespace App\Domain\Student\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentIndexRequest extends FormRequest
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
            'filter.name' => ['string', 'max:255'],
            'filter.email' => ['string', 'email', 'max:255'],
            'filter.classroom_id' => ['integer'],
        ];
    }
}

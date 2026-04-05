<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookCopyRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'copy_number' => 'sometimes|string|unique:book_copies,copy_number,' . $this->copy->id,
            'condition' => 'sometimes|in:excellent,good,fair,poor,damaged',
            'damage_notes' => 'nullable|string',
            'missing_pages' => 'nullable|integer|min:0',
            'is_available' => 'sometimes|boolean'
        ];
    }
}

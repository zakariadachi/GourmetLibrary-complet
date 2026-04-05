<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookCopyRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'copy_number' => 'required|string|unique:book_copies',
            'condition' => 'sometimes|in:excellent,good,fair,poor,damaged',
            'damage_notes' => 'nullable|string',
            'missing_pages' => 'nullable|integer|min:0',
            'is_available' => 'sometimes|boolean'
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NoteQueryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'lawsuit_id' => 'nullable|integer',
            'items_per_page' => 'nullable|integer',
        ];
    }
}

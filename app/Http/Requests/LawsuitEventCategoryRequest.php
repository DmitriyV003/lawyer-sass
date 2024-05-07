<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LawsuitEventCategoryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'color' => 'required|hex_color',
            'notify_before_hours' => 'nullable|integer',
            'mark_before_days' => 'nullable|integer',
        ];
    }
}

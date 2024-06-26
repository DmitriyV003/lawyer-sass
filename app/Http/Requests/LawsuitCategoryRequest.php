<?php

namespace App\Http\Requests;

class LawsuitCategoryRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'color' => 'required|hex_color',
            'notify_before_hours' => 'nullable|integer|max:24|min:1',
            'mark_before_days' => 'nullable|integer|min:1',
        ];
    }
}

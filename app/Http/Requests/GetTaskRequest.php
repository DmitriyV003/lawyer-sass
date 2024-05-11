<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetTaskRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'items_per_page' => 'nullable|integer|min:1',
            'to_do_date' => 'nullable|date',
        ];
    }
}

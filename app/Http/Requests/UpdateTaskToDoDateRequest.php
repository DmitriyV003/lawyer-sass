<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskToDoDateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'to_do_date' => 'required|date',
        ];
    }
}

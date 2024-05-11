<?php

namespace App\Http\Requests;

use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StatusRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'status' => [
                'required',
                Rule::in(array_keys(Task::STATUSES)),
            ],
        ];
    }
}

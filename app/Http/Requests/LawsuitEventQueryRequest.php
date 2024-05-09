<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LawsuitEventQueryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'since_start' => [
                'required',
                'date',
            ],
            'since_end' => [
                'required',
                'date',
            ],
        ];
    }
}

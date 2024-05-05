<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthorityRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'lawsuit_number' => 'required|max:255',
            'lawsuit_number_link' => 'nullable',
            'authority' => 'required',
            'judge' => 'required|max:255',
            'cabinet' => 'required|max:255',
            'comment' => 'nullable',
            'lawsuit_id' => 'required|exists:lawsuits',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}

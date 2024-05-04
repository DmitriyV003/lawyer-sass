<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CaseCategoryRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required',
            'label' => 'required',
            'color' => 'required',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}

<?php

namespace App\Http\Requests;

class LawsuitCategoryRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required',
            'color' => 'required',
        ];
    }
}

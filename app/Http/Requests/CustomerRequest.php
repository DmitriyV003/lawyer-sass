<?php

namespace App\Http\Requests;

class CustomerRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'telegram' => 'nullable|max:255',
            'whats_app' => 'nullable|digits:11',
            'phone' => 'required|digits:11',
            'email' => 'required|email|max:255',
        ];
    }
}

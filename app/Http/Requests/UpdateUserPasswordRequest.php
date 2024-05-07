<?php

namespace App\Http\Requests;

use App\Enums\UserType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserPasswordRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'new_password' => 'required|min:8|max:255',
            'repeat_password' => 'required|same:new_password',
            'password' => 'required',
        ];
    }
}

<?php

namespace App\Http\Requests;

use App\Enums\UserType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegistrationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:users,email|max:255',
            'name' => 'required|max:255',
            'phone' => 'required|digits:11',
            'type' => [
                'required',
                Rule::enum(UserType::class),
            ],
            'lastname' => 'required|max:255',
            'surname' => 'max:255',
            'password' => 'required|min:8|max:255',
            'repeat_password' => 'required|same:password',
        ];
    }
}

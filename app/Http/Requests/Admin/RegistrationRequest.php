<?php

namespace App\Http\Requests\Admin;

use App\Enums\UserType;
use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegistrationRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:users,email|max:255',
            'phone' => 'required|digits:11',
            'password' => 'required|min:8|max:255',
            'repeat_password' => 'required|same:password',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email обязателен',
            'email.email' => 'Email должен быть валидным адремом',
            'email.max' => 'Email максимальная длина 255 символов',
            'email.unique' => 'Email уже занят',
            'password.required' => 'Пароль обязателен',
            'password.min' => 'Минимальная длина пароля 8 символов',
            'password.max' => 'Максимальная длина пароля 255 символов',
            'repeat_password.required' => 'Пароль обязателен',
            'repeat_password.same' => 'Пароли не совпадают',
            'phone.required' => 'Телефон обязателен',
            'phone.digits' => 'Телефон должен состоять из 11 цифр',
        ];
    }
}

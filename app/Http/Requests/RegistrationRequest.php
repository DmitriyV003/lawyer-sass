<?php

namespace App\Http\Requests;

use App\Enums\UserType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegistrationRequest extends BaseRequest
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

    public function messages()
    {
        return [
            'email.required' => 'Email обязателен',
            'email.email' => 'Email должен быть валидным адремом',
            'email.max' => 'Email максимальная длина 255 символов',
            'email.unique' => 'Email уже занят',
            'name.required' => 'Имя обязательно',
            'name.max' => 'Максимальная длина имени 255 символов',
            'type.required' => 'Тип обязателен',
            'type.Illuminate\Validation\Rules\Enum' => 'Неверно выбран тип пользователя',
            'lastname.required' => 'Фамимлия обязательна',
            'lastname.max' => 'Максимальная длина фамилии 255 символов',
            'surname.max' => 'Максимальная длина отчества 255 символов',
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

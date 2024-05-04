<?php

namespace App\Http\Requests;

use App\Enums\UserType;
use Illuminate\Validation\Rule;

class ProfileRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'type' => [
                'required',
                Rule::enum(UserType::class),
            ],
            'lastname' => 'required|max:255',
            'surname' => 'max:255',
        ];
    }
}

<?php

namespace App\Http\Requests;

use App\Models\Tariff;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TariffStatusRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'status' => [
                'required',
                Rule::in(Tariff::STATUSES),
            ],
        ];
    }
}

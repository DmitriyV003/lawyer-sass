<?php

namespace App\Http\Requests;

use App\Models\Tariff;
use Illuminate\Foundation\Http\FormRequest;

class TariffRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'cost' => 'required|integer',
            'comment' => 'nullable|string',
            'status' => [
                'required',
                Tariff::STATUSES,
            ],
        ];
    }
}

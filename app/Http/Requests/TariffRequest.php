<?php

namespace App\Http\Requests;

use App\Models\Tariff;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TariffRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'cost' => 'required|integer',
            'comment' => 'nullable|string',
            'permission_ids' => 'required|array',
            'permission_ids.*' => [
                'required',
                'integer',
                Rule::exists('permissions', 'id')
            ],
            'status' => [
                'required',
                Rule::in(Tariff::STATUSES),
            ],
        ];
    }
}

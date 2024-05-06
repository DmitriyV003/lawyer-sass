<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class LawsuitRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'plot' => 'required',
            'opponent' => 'required',
            'rating' => 'required|integer',
            'contract_number' => 'nullable',
            'contract_signing_date' => 'nullable|date',
            'contract_validity' => 'nullable|date',
            'power_of_attorney' => 'nullable',
            'power_of_attorney_signing_date' => 'nullable|date',
            'power_of_attorney_validity' => 'nullable|date',
            'customer_id' => [
                'nullable',
                Rule::exists('customers', 'id')->where(function ($query) {
                   return $query->where('user_id', auth()->user()->id);
                }),
            ],
            'lawsuit_category_id' => [
                'required',
                Rule::exists('lawsuit_categories', 'id')->where(function ($query) {
                    return $query->where('user_id', auth()->user()->id);
                }),
            ],
        ];
    }
}

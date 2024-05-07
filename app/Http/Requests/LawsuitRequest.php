<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class LawsuitRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'plot' => 'required',
            'opponent' => 'required|max:255',
            'rating' => 'required|integer',
            'contract_number' => 'nullable|max:255',
            'contract_signing_date' => 'nullable|date',
            'contract_validity' => 'nullable|date',
            'power_of_attorney' => 'nullable|max:255',
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

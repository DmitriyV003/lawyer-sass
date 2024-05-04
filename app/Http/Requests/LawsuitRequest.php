<?php

namespace App\Http\Requests;

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
            'customer_id' => 'nullable|exists:customers',
            'case_category_id' => 'required|exists:case_categories',
        ];
    }
}

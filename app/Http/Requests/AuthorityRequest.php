<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class AuthorityRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'lawsuit_number' => 'required|string|max:255',
            'lawsuit_number_link' => 'nullable|string',
            'authority' => 'required|string',
            'judge' => 'required|string|max:255',
            'cabinet' => 'required|string|max:255',
            'comment' => 'nullable|string',
            'lawsuit_id' => [
                'integer',
                'required',
                Rule::exists('lawsuits', 'id')->where(function ($query) {
                    return $query->where('user_id', auth()->user()->id);
                }),
            ],
        ];
    }
}

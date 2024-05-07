<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class AuthorityRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'lawsuit_number' => 'required|max:255',
            'lawsuit_number_link' => 'nullable',
            'authority' => 'required',
            'judge' => 'required|max:255',
            'cabinet' => 'required|max:255',
            'comment' => 'nullable',
            'lawsuit_id' => [
                'required',
                Rule::exists('lawsuits')->where(function ($query) {
                    return $query->where('user_id', auth()->user()->id);
                }),
            ],
        ];
    }
}

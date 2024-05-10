<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NoteRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'text' => 'required|string',
            'lawsuit_id' => [
                'nullable',
                'integer',
                Rule::exists('lawsuits', 'id')->where(function ($query) {
                    return $query->where('user_id', auth()->user()->id);
                }),
            ],
            'customer_id' => [
                'nullable',
                'integer',
                Rule::exists('customers', 'id')->where(function ($query) {
                    return $query->where('user_id', auth()->user()->id);
                }),
            ],
        ];
    }
}

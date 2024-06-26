<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LawsuitQueryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'upcoming_event_sort' => [
                'nullable',
                Rule::in(['asc', 'desc']),
            ],
            'rating_sort' => [
                'nullable',
                Rule::in(['asc', 'desc']),
            ],
            'opponent_sort' => [
                'nullable',
                Rule::in(['asc', 'desc']),
            ],
            'items_per_page' => [
                'nullable',
                'integer',
                'min:1',
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

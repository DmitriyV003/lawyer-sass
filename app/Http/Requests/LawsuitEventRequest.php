<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LawsuitEventRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'theme' => 'required|string|max:255',
            'is_important' => 'nullable|boolean',
            'since_date' => 'required|date_format:Y-d-m',
            'till_date' => 'nullable|date_format:Y-d-m',
            'since_time' => [
                'nullable',
                Rule::requiredIf(!$this->request->get('is_all_day', false)),
                'date_format:H:i:s',
            ],
            'till_time' => [
                'nullable',
                Rule::requiredIf(!$this->request->get('is_all_day', false)),
                'date_format:H:i:s',
            ],
            'cost' => 'nullable|integer',
            'place' => 'required|string',
            'comment' => 'nullable|string',
            'lawsuit_event_category_id' => [
                'required',
                'integer',
                Rule::exists('lawsuit_event_categories', 'id')->where(function ($query) {
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
            'lawsuit_id' => [
                'nullable',
                'integer',
                Rule::exists('lawsuits', 'id')->where(function ($query) {
                    return $query->where('user_id', auth()->user()->id);
                }),
            ],
            'task_id' => [
                'nullable',
                'integer',
                Rule::exists('tasks', 'id')->where(function ($query) {
                    return $query->where('user_id', auth()->user()->id);
                }),
            ],
            'is_all_day' => 'nullable|boolean',
        ];
    }
}

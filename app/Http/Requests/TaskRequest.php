<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'theme' => 'required|string',
            'is_important' => 'nullable|boolean',
            'deadline' => 'required|date',
            'cost' => 'nullable|integer',
            'comment' => 'nullable|string',
            'customer_id' => [
                'nullable',
                'integer',
                Rule::exists('customers', 'id')->where(function ($query) {
                    return $query->where('user_id', auth()->user()->id);
                }),
            ],
            'lawsuit_category_id' => [
                'required',
                'integer',
                Rule::exists('lawsuit_categories', 'id')->where(function ($query) {
                    return $query->where('user_id', auth()->user()->id);
                }),
            ],
            'task_tag_id' => [
                'required',
                'integer',
                Rule::exists('task_tags', 'id')->where(function ($query) {
                    return $query->where('user_id', auth()->user()->id);
                }),
            ],
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetLawsuitEventRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'since' => 'required|date',
            'till' => 'required|date',
        ];
    }
}

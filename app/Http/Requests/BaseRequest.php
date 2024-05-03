<?php

namespace App\Http\Requests;

use Exception;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        $exception = $validator->getException();

        throw (new $exception(
            $validator,
            api_error(
                [
                    'errors' => $validator->errors(),
                    'message' => 'Ошибка валидации данных',
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY,
            ),
        ));
    }
}

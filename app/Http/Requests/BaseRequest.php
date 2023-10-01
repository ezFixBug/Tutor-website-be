<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class BaseRequest extends FormRequest
{
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
            'errors' => $validator->errors()->toArray(),
        ], Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}

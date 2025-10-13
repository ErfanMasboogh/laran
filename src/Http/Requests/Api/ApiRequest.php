<?php

namespace ErfanMasboogh\Laran\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest as BaseRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class ApiRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function failedValidation(Validator $validator)
    {
        $response = [];

        foreach ($validator->errors()->toArray() as $field => $errors) {
            $response[] = [
              'field' => lt($field, [], 'validation.attributes'),
              'message' => $errors,
            ];
        }

        $response = response()->json([
            'status' => 'error',
            'data' => null,
            'errors' => $response,
        ], Response::HTTP_UNPROCESSABLE_ENTITY);

        throw new ValidationException($validator, $response);
    }
}

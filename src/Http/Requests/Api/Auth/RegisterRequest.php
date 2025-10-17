<?php

namespace ErfanMasboogh\Laran\Http\Requests\Api\Auth;

use ErfanMasboogh\Laran\Http\Requests\Api\ApiRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'mobile' => ['required', 'string', 'validMobile', Rule::unique('users', 'mobile')],
            'password' => ['required', 'string', 'min:8', 'max:32', 'confirmed'],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'mobile' => normalizeMobile($this->mobile)
        ]);
    }

    public function messages(): array
    {
        return [
            'mobile.unique' => lt('mobile.unique', [], 'validation.customMessages.auth'),
        ];
    }
}

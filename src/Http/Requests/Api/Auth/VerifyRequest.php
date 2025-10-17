<?php

namespace ErfanMasboogh\Laran\Http\Requests\Api\Auth;

use ErfanMasboogh\Laran\Http\Requests\Api\ApiRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

class VerifyRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'mobile' => ['required', 'string', 'validMobile', Rule::unique('users', 'mobile')],
            'otpCode' => ['required', 'numeric'],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'mobile' => normalizeMobile($this->mobile)
        ]);
    }
}

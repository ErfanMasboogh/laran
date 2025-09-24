<?php

namespace ErfanMasboogh\Laran\Http\Requests\Web\Auth;

use ErfanMasboogh\Laran\Http\Requests\Web\WebRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class LoginRequest extends WebRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'mobile' => ['required', 'validMobile'],
            'password' => ['required', 'string'],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'mobile' => normalizeMobile($this->mobile),
        ]);
    }
}

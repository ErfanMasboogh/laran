<?php

namespace ErfanMasboogh\Laran\Http\Requests\Web\Manager;

use ErfanMasboogh\Laran\Http\Requests\Web\WebRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

class StoreRequest extends WebRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'family' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'validMobile', Rule::unique('managers', 'mobile')],
            'password' => ['required', 'string', 'min:8', 'max:32', 'confirmed'],
            'image' => array_merge(config('laran.storage.types.image.validation'), ['nullable'])
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'mobile' => normalizeMobile($this->mobile),
        ]);
    }
}

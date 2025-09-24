<?php

namespace ErfanMasboogh\Laran\Rules;

use Illuminate\Contracts\Validation\ValidationRule;
use Closure;

class ValidMobile implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $value
     * @param Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString $fail
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $this->__invoke($attribute, $value, $fail);
    }

    /**
     * Invokable validation rule
     *
     * @param string $attribute
     * @param mixed $value
     * @param callable $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        $value = is_numeric($value) ? (string)$value : $value;

        if (!is_string($value)) {
            $this->failValidation($fail, $attribute);
            return;
        }

        $mobile = normalizeMobile($value);

        if (strlen($mobile) != 10) {
            $this->failValidation($fail, $attribute);
        }

        if (!str_starts_with($mobile, '9')) {
            $this->failValidation($fail, $attribute);
        }
    }

    public function failValidation($fail, $attribute)
    {
        $translatedAttribute = lt($attribute, [], 'validation.attributes');

        if (str_starts_with($translatedAttribute, 'validation.attributes')) {
            $translatedAttribute = $attribute;
        }

        return $fail(lt('mobile', ['attribute' => $translatedAttribute], 'validation'));
    }
}

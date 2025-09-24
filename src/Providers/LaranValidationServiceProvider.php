<?php

namespace ErfanMasboogh\Laran\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use ErfanMasboogh\Laran\Rules\ValidMobile;

class LaranValidationServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->initCustomRules();
    }

    public function initCustomRules(): void
    {
        $this->validMobileRule();
    }

    public function validMobileRule(): void
    {
        Validator::extend('validMobile', function ($attribute, $value, $parameters, $validator) {
            $failed = false;

            (new ValidMobile())($attribute, $value, function ($msg) use (&$failed) {
                $failed = true;
            });

            return !$failed;
        });

        Validator::replacer('validMobile', function ($message, $attribute, $rule, $parameters, $validator) {
            $failMessage = null;

            (new ValidMobile())($attribute, $validator->getValue($attribute), function($msg) use (&$failMessage) {
                $failMessage = $msg;
            });

            return $failMessage ?? $message;
        });
    }
}

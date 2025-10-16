<?php

namespace ErfanMasboogh\Laran\Services\Sms\Providers;

use ErfanMasboogh\Laran\Services\Sms\SmsServiceInterface;

class MsgwaySmsService implements SmsServiceInterface
{
    public function sendOtp(string $mobile, string $otpCode, int $template = null)
    {
        //
    }
}

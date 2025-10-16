<?php

namespace ErfanMasboogh\Laran\Services\Sms;

interface SmsServiceInterface
{
    public function sendOtp(string $mobile, string $otpCode, int $template = null);
}

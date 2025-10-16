<?php

namespace ErfanMasboogh\Laran\Services\Sms;

class SmsService implements SmsServiceInterface
{
    protected $smsProvider;

    public function __construct()
    {
        $smsProviderName = config('app.smsService');
        $this->smsProvider = SmsServiceFactory::make($smsProviderName);
    }

    /**
     * Call the sms provider's send method
     *
     * @param string $mobile
     * @param string $message
     * @param int|null $template
     * @return mixed
     */
    public function sendOtp(string $mobile, string $otpCode, int $template = null)
    {
        return $this->smsProvider->sendOtp($mobile, $otpCode, $template);
    }
}

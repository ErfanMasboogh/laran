<?php

namespace ErfanMasboogh\Laran\Services\Sms;

use ErfanMasboogh\Laran\Services\Sms\Providers\MsgwaySmsService;
use InvalidArgumentException;

class SmsServiceFactory
{
    /**
     * Returns an instance of sms provider for SmsService
     *
     * @param string $provider
     * @return SmsServiceInterface
     */
    public static function make(string $provider): SmsServiceInterface
    {
        return match ($provider) {
            'msgway' => new MsgwaySmsService(),
            default => throw new InvalidArgumentException("Unknown provider: $provider"),
        };
    }
}

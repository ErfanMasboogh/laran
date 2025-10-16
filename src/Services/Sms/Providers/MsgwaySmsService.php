<?php

namespace ErfanMasboogh\Laran\Services\Sms\Providers;

use ErfanMasboogh\Laran\Services\Sms\SmsServiceInterface;

class MsgwaySmsService implements SmsServiceInterface
{
    public function sendOtp(string $mobile, string $otpCode, int $template = null)
    {
        $apiKey = config('laran.smsProvider.apiKey');
        $params = [
            "mobile" => $mobile,
            "method" => "sms",
            "templateID" => $template,
            "provider" => 3, // Asiatech 9000
            "code" => $otpCode,
        ];
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.msgway.com/send',
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => json_encode($params),
            CURLOPT_HTTPHEADER => array(
                'apiKey: ' . $apiKey,
            ),
        ));
        $response = json_decode(curl_exec($curl));
        curl_close($curl);

        if ($response->status) {
            return true;
        }
        return $response->error;
    }
}

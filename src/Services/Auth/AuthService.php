<?php

namespace ErfanMasboogh\Laran\Services\Auth;

use ErfanMasboogh\Laran\Http\Controllers\Api\Traits\HasApiResponse;
use ErfanMasboogh\Laran\Services\Sms\SmsService;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Random\RandomException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AuthService
{
    use HasApiResponse;

    /**
     * @param array $data
     * @return mixed
     * @throws RandomException
     */
    public function register(array $data)
    {
        $cachedData = Cache::get($data['mobile']) ?? [];
        $otpConfig = config('laran.otp');
        $now = time();
        $cacheTime = now()->addMinutes(config('laran.otp.userInfoCacheTime'));

        if ($cachedData && $cachedData['tryLimit'] >= $otpConfig['tryLimit']) {
            if (!isset($cachedData['limitReachedTime'])) {
                $cachedData['limitReachedTime'] = $now;
                Cache::put($data['mobile'], $cachedData, $cacheTime);
            }

            if ($cachedData['limitReachedTime'] + $otpConfig['restrictTime'] < $now) {
                $cachedData['tryLimit'] = 0;
                unset($cachedData['limitReachedTime']);
                Cache::put($data['mobile'], $cachedData, $cacheTime);
            } else {
                $remainedTime = $cachedData['limitReachedTime'] + $otpConfig['restrictTime'] - $now;
                $remainedTime = ceil($remainedTime / 60);

                throw new HttpResponseException(
                    $this->error(lt('Register try limit error', ['minutes' => $remainedTime]),
                        ResponseAlias::HTTP_TOO_MANY_REQUESTS
                    )
                );
            }
        } elseif ($cachedData && $now - $cachedData['lastSentTime'] <= $otpConfig['resendCoolDown']) {
            $remainedTime = $otpConfig['resendCoolDown'] - ($now - $cachedData['lastSentTime']);
            throw new HttpResponseException(
                $this->error(lt('Register cool down error', ['seconds' => $remainedTime]),
                    ResponseAlias::HTTP_TOO_MANY_REQUESTS)
            );
        }

        $cachedData['lastSentTime'] = $now;
        $cachedData['tryLimit'] = ($cachedData['tryLimit'] ?? 0) + 1;
        $cachedData['otpCode'] = random_int(10000, 99999);
        $cachedData['password'] = Hash::make($data['password']);

        Cache::put($data['mobile'], $cachedData, $cacheTime);

        $smsService = new SmsService();
        return $smsService->sendOtp(
            $data['mobile'],
            $cachedData['otpCode'],
            config('laran.otp.' . config('laran.smsProvider.smsProviderName') . '.templateID')
        );
    }
}

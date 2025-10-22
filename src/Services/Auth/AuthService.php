<?php

namespace ErfanMasboogh\Laran\Services\Auth;

use ErfanMasboogh\Laran\Http\Controllers\Api\Traits\HasApiResponse;
use ErfanMasboogh\Laran\Models\User;
use ErfanMasboogh\Laran\Services\Sms\SmsService;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
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

    /**
     * @param array $data
     * @return array
     */
    public function verify(array $data)
    {
        $cachedData = Cache::get($data['mobile']);
        $otpConfig = config('laran.otp');
        $now = time();

        if (empty($cachedData) || ($cachedData['lastSentTime'] + $otpConfig['expireTime']) < $now) {
            throw new HttpResponseException($this->error(lt('Otp expired error'), ResponseAlias::HTTP_GONE));
        }

        if ((int)$data['otpCode'] !== (int)$cachedData['otpCode']) {
            throw new HttpResponseException($this->error(lt('Wrong otp code'), ResponseAlias::HTTP_BAD_REQUEST));
        }

        $data['password'] = $cachedData['password'];

        Cache::forget($data['mobile']);

        return $data;
    }

    /**
     * @param User $user
     * @return string
     */
    public function createAuthToken(User $user)
    {
        return $user->createToken('auth_token')->plainTextToken;
    }

    /**
     * @param User $user
     * @param array $data
     * @return string
     */
    public function login(User $user, array $data)
    {
        $throttleKey = $this->makeThrottleKey($data);

        if (RateLimiter::tooManyAttempts($throttleKey, config('laran.auth.rateLimiter.maxAttempts'))) {
            $seconds = RateLimiter::availableIn($throttleKey);

            throw new HttpResponseException(
                $this->error(lt('Rate limit error', ['seconds' => $seconds]), ResponseAlias::HTTP_TOO_MANY_REQUESTS)
            );
        }

        $this->checkPassword($user, $data['password'], $throttleKey);

        RateLimiter::clear($throttleKey);

        return $this->createAuthToken($user);
    }

    /**
     * @param array $data
     * @return string
     */
    private function makeThrottleKey(array $data)
    {
        return strtolower($data['mobile'] . '|' . $data['ip']);
    }

    /**
     * @param User $user
     * @param string $password
     * @return void
     */
    private function checkPassword(User $user, string $password, string $throttleKey)
    {
        if (!Hash::check($password, $user->password)) {
            RateLimiter::hit($throttleKey, config('laran.auth.rateLimiter.decaySeconds'));

            throw new HttpResponseException(
                $this->error(lt('Wrong password error'), ResponseAlias::HTTP_UNPROCESSABLE_ENTITY)
            );
        }
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function logout(User $user)
    {
        return $user->currentAccessToken()->delete();
    }
}

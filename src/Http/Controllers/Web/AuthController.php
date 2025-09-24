<?php

namespace ErfanMasboogh\Laran\Http\Controllers\Web;

use ErfanMasboogh\Laran\Http\Requests\Web\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;


class AuthController extends Controller
{
    /**
     * Return login's view
     *
     * @return View
     */
    public function login()
    {
        return view('laran::admin.auth.login');
    }

    /**
     * Handle the login request
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws ValidationException
     */
    public function loginCheck(LoginRequest $request)
    {
        $this->authenticate($request);
        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }

    /**
     * Handle login process
     *
     * @param Request $request
     * @return void
     * @throws ValidationException
     */
    protected function authenticate(Request $request)
    {
        $this->checkRateLimit($request);

        $credentials = $request->validated();
        $throttleKey = $this->throttleKey($request);

        if (!Auth::guard('manager')->attempt($credentials)) {
            RateLimiter::hit($throttleKey, 60);

            throw ValidationException::withMessages([
                'mobile' => lt('Invalid credentials'),
            ]);
        }

        RateLimiter::clear($throttleKey);
    }

    /**
     * Ensure that rate limit does not reached
     *
     * @param Request $request
     * @return void
     * @throws ValidationException
     */
    protected function checkRateLimit(Request $request)
    {
        $throttleKey = $this->throttleKey($request);

        if (RateLimiter::tooManyAttempts($throttleKey, 6)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            throw ValidationException::withMessages([
                'mobile' => lt('Rate limit error', ['seconds' => $seconds]),
            ]);
        }
    }

    /**
     * Returns a throttle key
     *
     * @param Request $request
     * @return string
     */
    protected function throttleKey(Request $request)
    {
        return strtolower($request->input('mobile')) . '|' . $request->ip();;
    }

    /**
     * Handle logout process
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::guard('manager')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}

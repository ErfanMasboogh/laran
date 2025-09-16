<?php

namespace ErfanMasboogh\Laran\Http\Controllers\Web;

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

    public function loginCheck()
    {
        return 'success';
    }
}

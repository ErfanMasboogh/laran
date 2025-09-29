<?php

namespace ErfanMasboogh\Laran\Http\Controllers\Web;

use \Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    /**
     * @return View
     */
    public function index()
    {
        return view('laran::admin.dashboard');
    }
}

<?php

namespace ErfanMasboogh\Laran\Http\Controllers\Web;

use \Illuminate\Contracts\View\View;

class ManagerController extends Controller
{
    /**
     * @return View
     */
    public function create()
    {
        return view('laran::admin.manager.create');
    }
}

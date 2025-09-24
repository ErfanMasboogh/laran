<?php

namespace ErfanMasboogh\Laran\Http\Controllers\Web;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as baseController;

class Controller extends baseController
{
    use AuthorizesRequests;
    use ValidatesRequests;
}

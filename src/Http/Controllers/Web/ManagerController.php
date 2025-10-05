<?php

namespace ErfanMasboogh\Laran\Http\Controllers\Web;

use ErfanMasboogh\Laran\Http\Requests\Web\Manager\StoreRequest;
use ErfanMasboogh\Laran\Models\Manager;
use ErfanMasboogh\Laran\Models\Storage;
use ErfanMasboogh\Laran\Services\ManagerService;
use \Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;

class ManagerController extends Controller
{
    /**
     * @return View
     */
    public function create()
    {
        return view('laran::admin.manager.create');
    }

    /**
     * @param StoreRequest $request
     * @param ManagerService $managerService
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRequest $request, ManagerService $managerService)
    {
        $data = $request->validated();

        $managerService->createManager($data);

        return back()->with('success', lt('Operation done successfully'));
    }
}

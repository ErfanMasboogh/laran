<?php

namespace ErfanMasboogh\Laran\Http\Controllers\Web;

use ErfanMasboogh\Laran\DataTables\ManagerDatatable;
use ErfanMasboogh\Laran\Http\Requests\Web\Manager\StoreRequest;
use ErfanMasboogh\Laran\Http\Requests\Web\Manager\UpdateRequest;
use ErfanMasboogh\Laran\Models\Manager;
use ErfanMasboogh\Laran\Models\Storage;
use ErfanMasboogh\Laran\Services\ManagerService;
use \Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;

class ManagerController extends Controller
{
    protected $managerService;

    public function __construct(ManagerService $managerService)
    {
        $this->managerService = $managerService;
    }

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
    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        $this->managerService->createManager($data);

        return back()->with('success', lt('Operation done successfully'));
    }

    /**
     * @param ManagerDatatable $dataTable
     * @return mixed
     */
    public function list(ManagerDatatable $dataTable)
    {
        return $dataTable->render('laran::admin.manager.list');
    }

    /**
     * @param Manager $manager
     * @return View
     */
    public function edit(Manager $manager)
    {
        return view('laran::admin.manager.edit', compact('manager'));
    }

    /**
     * @param UpdateRequest $request
     * @param Manager $manager
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request, Manager $manager)
    {
        $data = $request->validated();

        $this->managerService->updateManager($manager, $data);

        return redirect()->route('admin.manager.list')->with('success', lt('Operation done successfully'));
    }

    /**
     * @param Manager $manager
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Manager $manager)
    {
        $this->managerService->deleteManager($manager);
        
        return back()->with('success', lt('Operation done successfully'));
    }
}

<?php

namespace Modules\Admin\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Permission;
use Illuminate\Contracts\Support\Renderable;
use Modules\Admin\Http\Controllers\Controller;

class PermissionController extends Controller
{
    /**
     * @var string $viewPath
     */
    protected string $viewPath = 'pages.user.permission.';

    /**
     * PermissionController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->middleware('permission:permission:manage');
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Renderable
     */
    public function index(Request $request): Renderable
    {
        $guardNames = DB::table((new Permission)->getTable())
            ->select('guard_name as name')
            ->groupBy('guard_name')->get()->toArray();

        $guard_name = $request->input('guard_name');

        $permissions = Permission::where(['guard_name' => $guard_name])->get();

        return $this->view($this->viewPath.'index', [
            'guardNames' => $guardNames,
            'permissions' => $permissions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(): Renderable
    {
        return $this->view($this->viewPath.'create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validation = validator($request->all(), [
            'guard_name' => 'required',
            'name' => 'required|unique:permissions'
        ]);

        if ($validation->fails()) {
            return redirect()->back()
                ->with('message', 'Məlumatı düzgün doldurun')
                ->with('type', 'success');
        }

        $permission = Permission::make([
            'guard_name' => $request->get('guard_name'),
            'name' => $request->get('name'),
            'description' => $request->get('description')
        ]);

        if ($permission->saveOrFail()) {
            return redirect()->back()
                ->with('message', 'Uğurla yaradılmışdır')
                ->with('type', 'success');
        }

        return redirect()->back()
            ->with('message', 'İcazə yaratmaq alınmadı')
            ->with('type', 'success');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(int $id): Renderable
    {
        return $this->view($this->viewPath.'show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(int $id): Renderable
    {
        return $this->view($this->viewPath.'edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return void
     */
    public function update(Request $request, int $id): void
    {
    }

    /**
     * Remove the specified resource from storage.
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(Request $request, int $id): RedirectResponse
    {
        $permission = Permission::find($id);

        abort_if(!$permission, '404');

        if ($permission->delete()) {

            return redirect()->route('user.permission.index', ['guard_name' => $request->input('guard_name')])
                ->with('message', 'Uğurla silindi')
                ->with('type', 'success');
        }

        return redirect()->route('user.permission.index', ['guard_name' => $request->input('guard_name')])
            ->with('message', 'Səhv oldu')
            ->with('type', 'danger');
    }
}

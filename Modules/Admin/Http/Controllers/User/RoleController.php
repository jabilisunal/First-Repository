<?php

namespace Modules\Admin\Http\Controllers\User;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Role;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Permission;
use Illuminate\Contracts\Support\Renderable;
use Modules\Admin\Http\Controllers\Controller;

class RoleController extends Controller
{
    /**
     * @var string $viewPath
     */
    protected string $viewPath = 'pages.user.role.';

    /**
     * RoleController construct
     */
    public function __construct()
    {
        parent::__construct();

        $this->middleware('permission:permission:manage');
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(): Renderable
    {
        $roles = Role::with('permissions')
            ->where('guard_name', 'admin')
            ->get()->map(function ($role){
                $role->permissionConvertForHuman = $role->permissions->pluck('name')->toArray();
                return $role;
            });

        return $this->view($this->viewPath.'index', [
            'roles' => $roles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(): Renderable
    {
        $permissions = Permission::where(['guard_name' => 'admin'])->get();

        $explode = [];

        foreach ($permissions as $permission) {

            $split = explode(':', $permission->name);

            if (isset($split[0])) {

                if (isset($split[1])) {
                    $splitModule = explode("-", $split[1]);

                    if (isset($splitModule[0])) {
                        $explode[$split[0]][$splitModule[0]][] = $permission->name;
                    }

                } else {
                    $explode[$split[0]][] = $permission->name;
                }
            }

        }

        return $this->view($this->viewPath.'create', [
            'explode' => $explode,
            'permissions' => $permissions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        /**
         * @var $role Role
         */

        $validator = validator($request->only(['name']),[
            'name' => 'required|unique:roles'
        ], [
            'name' => 'Ad bölməsi vacibdir'
        ]);

        $permissions = $request->input('permissions');

        if($validator->fails()) {
            return redirect()->back()
                ->with('message', 'Fill in the information correctly')
                ->with('type', 'danger');
        }

        $role = Role::create([
            'name' => $request->get('name'),
            'guard_name' => 'admin'
        ]);

        if($role) {
            $role->permissionConvertForHuman = $role->permissions->pluck('name')->toArray();

            $role->syncPermissions($permissions);
        }

        return redirect()->route('user.role.index')
            ->with('message', 'Was successfully created')
            ->with('type', 'success');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(int $id): Renderable
    {
        /**
         * @var $role Role
         */

        $role = Role::with('permissions')->find($id);

        abort_if(!$role, '404');

        return $this->view($this->viewPath.'show', [
            'role' => $role
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(int $id): Renderable
    {
        $role = Role::with('permissions')->find($id);

        $permissions = Permission::where(['guard_name' => 'admin'])->get();

        return $this->view($this->viewPath.'edit', [
            'role' => $role,
            'permissions' => $permissions
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        /**
         * @var $role Role
         */
        $role = Role::findById($id);

        abort_if(!$role, '404');

        $validator = validator($request->only(['name']),[
            'name' => 'required'.($role->name === $request->post('name') ? '' : '|unique:'.$role->getTable())
        ], [
            'name' => 'Ad bölməsi vacibdir'
        ]);

        $permissions = $request->input('permissions');

        if($validator->fails()) {
            return redirect()->back()
                ->with('message', 'Məlumatı düzgün doldurun')
                ->with('type', 'danger');
        }

        if ($role->update(['name' => $request->get('name')])) {

            $role->syncPermissions($permissions);

            return redirect()->route('user.role.index')
                ->with('message', 'Was successfully updated')
                ->with('type', 'success');
        }

        return redirect()->back()
            ->with('message', 'Məlumatı düzgün doldurun')
            ->with('type', 'danger');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function updateRolePermission(Request $request): JsonResponse
    {
        $validation = validator($request->all(),[
            'role_id'    => 'required|numeric',
            'permission' => 'required|string',
            'status'     => 'required'
        ], [
            'role_id' => 'Rol seçməyiniz vacibdir',
            'permission' => 'İcazə seçməyiniz vacibdir',
            'status' => 'Status seçməyiniz vacibdir',
        ]);

        if($validation->fails()) {
            return response()->json([
                'status'  => false,
                'message' => $validation->errors()
            ], 422);
        }

        /**
         * @var $role Role
         */

        $role = Role::findById($request->get('role_id'));

        if($request->get('status') === 1) {
            $update = $role->givePermissionTo($request->get('permission'));
        } else {
            $update = $role->revokePermissionTo($request->get('permission'));
        }

        return response()->json([
            'status' => (bool) $update
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(int $id): RedirectResponse
    {
        /**
         * @var $role Role
         */

        $role = Role::findById($id);

        abort_if(!$role, '404');

        if ($role->delete()) {
            return redirect()->back()
                ->with('message', 'Uğurla silindi')
                ->with('type', 'success');
        }

        return redirect()->back()
            ->with('message', 'Məlumatı düzgün doldurun')
            ->with('type', 'danger');
    }
}

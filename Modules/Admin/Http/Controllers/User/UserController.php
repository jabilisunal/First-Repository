<?php

namespace Modules\Admin\Http\Controllers\User;

use App\Models\Office;
use App\Models\WorkerPosition;
use Illuminate\Http\Request;
use Modules\Admin\Entities\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Permission;
use Illuminate\Contracts\Support\Renderable;
use Modules\Admin\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * @var string $viewPath
     */
    protected string $viewPath = 'pages.user.user.';

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(): Renderable
    {
        $users = User::paginate(10);

        return $this->view($this->viewPath.'index', [
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(): Renderable
    {
        $methods = Permission::where(['guard_name' => 'api'])->get();

        $permissions = Permission::where(['guard_name' => 'admin'])->get();

        $offices = Office::where(['status' => 1])->get();

        $positions = WorkerPosition::all();

        return $this->view($this->viewPath.'create', [
            'methods' => $methods,
            'roles' => Role::all(),
            'permissions' => $permissions,
            'offices' => $offices,
            'positions' => $positions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'           => 'required',
            'email'          => 'required',
            'password'       => 'required'
        ]);

        /**
         * @var $createWorker User
         */
        $createWorker = User::create([
            'name'           => $request->post('name'),
            'surname'        => $request->post('surname'),
            'email'          => $request->post('email'),
            'password'       => bcrypt($request->get('password')),
            'position_id'    => $request->get('position_id'),
            'office_id'      => $request->get('office_id')
        ]);

        if ($createWorker) {

            if (($role = $request->get('role')) &&  $role !== '0') {
                $createWorker->assignRole($role);
            }

            if ($permissions = $request->get('permissions')) {
                $createWorker->permissions()->sync((array) $permissions);
            } else {
                $createWorker->permissions()->sync([]);
            }

            return redirect()->route('user.user.index')
                ->with('message', 'Uğurla əlavə edildi')
                ->with('type', 'success');
        }

        return redirect()->back()
            ->with('message', 'Məlumatı düzgün doldurun')
            ->with('type', 'danger');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(int $id): Renderable
    {
        $user = User::find($id);

        abort_if(!$user, '404');

        return $this->view($this->viewPath.'show', [
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(int $id): Renderable
    {
        $user = User::with(['permissions'])->find($id);

        abort_if(!$user, '404');

        $methods = Permission::where(['guard_name' => 'api'])->get();

        $permissions = Permission::where(['guard_name' => 'admin'])->get();

        $offices = Office::where(['status' => 1])->get();

        $positions = WorkerPosition::all();

        return $this->view($this->viewPath.'edit', [
            'user'         => $user,
            'roles'        => Role::where('guard_name','admin')->get(['name']),
            'methods'      => $methods,
            'permissions'  => $permissions,
            'offices'      => $offices,
            'positions'    => $positions,
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
        $user = User::find($id);

        abort_if(!$user, '404');

        $request->validate([
            'name'           => 'required',
            'email'          => 'required',
        ], [
            'name' => 'Ad bölməsini doldurmağınız vacibdir',
            'surname' => 'Soyad bölməsini doldurmağınız vacibdir',
            'email' => 'Email bölməsini doldurmağınız vacibdir',
        ]);

        $data = [
            'name'           => $request->get('name'),
            'surname'        => $request->get('surname'),
            'email'          => $request->get('email'),
            'position_id'    => $request->get('position_id'),
            'office_id'      => $request->get('office_id')
        ];


        if ($request->has('password') && $request->input('password')) {
            $data['password'] = bcrypt($request->input('password'));
        }

        if ($user->update($data)) {

            $user->fresh();

            $roles = [];

            if ($request->has('role') && $request->get('role') !== '0') {
                $roles[] = $request->get('role');
            }

            //dd($roles);

            $user->syncRoles($roles);

            $permissions = [];

            if ($request->has('permissions')) {
                $permissions = (array) $request->get('permissions');
            }

            $user->permissions()->sync($permissions);

            return redirect()->route('user.user.index')
                ->with('message', 'Uğurla yeniləndi')
                ->with('type', 'success');
        }

        return redirect()->back()
            ->with('message', 'Məlumatı düzgün doldurun')
            ->with('type', 'danger');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $user = User::find($id);

        abort_if(!$user, '404');

        $user->roles()->sync([]);

        $user->permissions()->sync([]);

        if ($user->delete()) {

            return redirect()->route('user.user.index')
                ->with('message', 'Uğurla silindi')
                ->with('type', 'success');
        }

        return redirect()->route('user.user.index')
            ->with('message', 'Səhv oldu')
            ->with('type', 'danger');
    }
}

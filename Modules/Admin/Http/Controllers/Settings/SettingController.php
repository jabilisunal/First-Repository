<?php

namespace Modules\Admin\Http\Controllers\Settings;

use Illuminate\Http\Request;
use Modules\Admin\Entities\Settings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Support\Renderable;
use Modules\Admin\Http\Controllers\Controller;

class SettingController extends Controller
{

    /**
     * @var string $viewPath
     */
    protected string $viewPath = 'pages.settings.general.';

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(): Renderable
    {
        $settings = Settings::all();

        return $this->view($this->viewPath.'index', [
            'settings' => $settings
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
        $request->validate([
            'name' => 'required',
            'val' => 'required'
        ]);

        $type = Settings::create([
            'name' => $request->post('name'),
            'val' => $request->post('val'),
        ]);

        if ($type) {
            return redirect()->route('settings.general.index')
                ->with('message', 'Uğurla əlavə edildi')
                ->with('type', 'success');
        }

        return redirect()->back()
            ->with('message', 'Doldurulan məlumatlarda xəta var')
            ->with('type', 'danger');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(int $id): Renderable
    {
        $setting = Settings::find($id);

        return $this->view($this->viewPath.'show', [
            'setting' => $setting
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(int $id): Renderable
    {
        $setting = Settings::find($id);

        return $this->view($this->viewPath.'edit', [
            'setting' => $setting
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
        $setting = Settings::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'val' => 'required'
        ]);

        $update = $setting->update([
            'name' => $request->post('name'),
            'val' => $request->post('val'),
        ]);

        if ($update) {
            return redirect()->route('settings.general.index')
                ->with('message', 'Uğurla düzəliş edildi')
                ->with('type', 'success');
        }

        return redirect()->back()
            ->with('message', 'Doldurulan məlumatlarda xəta var')
            ->with('type', 'danger');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        Settings::findOrFail($id)->delete();

        return back()->with('message', 'Uğurla silindi')
            ->with('type', 'success');
    }
}

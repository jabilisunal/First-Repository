<?php

namespace Modules\Admin\Http\Controllers\Content;

use Illuminate\Http\Request;
use Modules\Admin\Entities\Partner;
use Modules\Admin\Entities\MenuType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Support\Renderable;
use Modules\Admin\Http\Controllers\Controller;

class MenuTypeController extends Controller
{

    /**
     * @var string $viewPath
     */
    protected string $viewPath = 'pages.content.menu-type.';

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(): Renderable
    {
        $types = MenuType::all();

        return $this->view($this->viewPath.'index', [
            'types' => $types
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
            'title' => 'required'
        ]);

        $type = Partner::create([
            'title' => $request->post('title')
        ]);

        if ($type) {
            return redirect()->route('content.banner-type.index')
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
        $type = MenuType::find($id);

        return $this->view($this->viewPath.'show', [
            'type' => $type
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(int $id): Renderable
    {
        $type = MenuType::find($id);

        return $this->view($this->viewPath.'edit', [
            'type' => $type
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
        $type = MenuType::findOrFail($id);

        $request->validate([
            'title' => 'required'
        ]);

        $update = $type->update([
            'title' => $request->post('title')
        ]);

        if ($update) {
            return redirect()->route('content.banner-type.index')
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
        MenuType::findOrFail($id)->delete();

        return back()->with('message', 'Uğurla silindi')
            ->with('type', 'success');
    }
}

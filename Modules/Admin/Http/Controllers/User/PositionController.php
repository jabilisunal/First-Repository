<?php

namespace Modules\Admin\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\WorkerPosition;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Support\Renderable;
use Modules\Admin\Http\Controllers\Controller;

class PositionController extends Controller
{
    /**
     * @var string $viewPath
     */
    protected string $viewPath = 'pages.user.position.';

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(): Renderable
    {
        $positions = WorkerPosition::with(['parent'])->get();

        return $this->view($this->viewPath.'index', [
            'positions' => $positions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(): Renderable
    {
        $positions = WorkerPosition::all();

        return $this->view($this->viewPath.'create', [
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
            'position_name' => 'required'
        ]);

        $data = [
            'parent_id' => $request->post('parent_id'),
            'position_name' => $request->post('position_name')
        ];

        if (WorkerPosition::create($data)) {
            return redirect()
                ->route('user.position.index')
                ->with('success', 'Uğurla əlavə edildi');
        }

        return redirect()
            ->back()
            ->with('danger', 'Bir xəta baş verdi. Yenidən cəhd edin');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(int $id): Renderable
    {
        $position = WorkerPosition::findOrFail($id);

        return $this->view($this->viewPath.'show', [
            'position' => $position
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(int $id): Renderable
    {
        $position = WorkerPosition::findOrFail($id);

        $positions = WorkerPosition::all();

        return $this->view($this->viewPath.'edit', [
            'position' => $position,
            'positions' => $positions
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
        $position = WorkerPosition::findOrFail($id);

        $request->validate([
            'position_name' => 'required'
        ]);

        $data = [
            'parent_id' => $request->post('parent_id'),
            'position_name' => $request->post('position_name')
        ];

        if ($position->update($data)) {

            return redirect()
                ->route('user.position.index')
                ->with('success', 'Uğurla düzəliş edildi');
        }

        return redirect()
            ->back()
            ->with('danger', 'Bir xəta baş verdi. Yenidən cəhd edin');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        WorkerPosition::findOrFail($id)->delete();

        return back()->with('message', 'Uğurla silindi')
            ->with('type', 'success');
    }
}

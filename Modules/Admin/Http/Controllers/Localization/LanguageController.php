<?php

namespace Modules\Admin\Http\Controllers\Localization;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Admin\Entities\Language;
use Modules\Admin\Http\Controllers\Controller;

class LanguageController extends Controller
{
    /**
     * @var string $viewPath
     */
    protected string $viewPath = 'pages.localization.language.';

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(): Renderable
    {
        $languages = Language::all();

        return $this->view($this->viewPath.'index', [
            'languages' => $languages
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(): Renderable
    {
        $styles = ['ltr', 'rtl'];

        return $this->view($this->viewPath.'create', [
            'styles' => $styles
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
            'name' => 'required',
            'short_name' => 'required',
            'code' => 'required'
        ]);

        $language = Language::create([
            'name' => $request->post('name'),
            'short_name' => $request->post('short_name'),
            'code' => $request->post('code'),
            'status' => $request->post('status') === null ? 0 : 1
        ]);

        if ($language) {
            return redirect()->route('localization.language.index')
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
        $language = Language::with(['user'])->find($id);

        return $this->view($this->viewPath.'show', [
            'language' => $language
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(int $id): Renderable
    {
        $language = Language::find($id);

        $styles = ['ltr', 'rtl'];

        return $this->view($this->viewPath.'edit', [
            'styles' => $styles,
            'language' => $language
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
        $request->validate([
            'name' => 'required',
            'short_name' => 'required',
            'code' => 'required'
        ]);

        $language = Language::find($id)->update([
            'name' => $request->post('name'),
            'short_name' => $request->post('short_name'),
            'code' => $request->post('code'),
            'status' => $request->post('status') === null ? 0 : 1
        ]);

        if ($language) {
            return redirect()->route('localization.language.index')
                ->with('message', 'Uğurla yeniləndi')
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
        Language::findOrFail($id)->delete();

        return back()->with('message', 'Uğurla silindi')
            ->with('type', 'success');
    }
}

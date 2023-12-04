<?php

namespace Modules\Admin\Http\Controllers\Content;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Modules\Admin\Entities\Menu;
use Modules\Admin\Entities\MenuType;
use Modules\Admin\Entities\Language;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Support\Renderable;
use Modules\Admin\Http\Controllers\Controller;

class MenuController extends Controller
{
    /**
     * @var string $viewPath
     */
    protected string $viewPath = 'pages.content.menu.';

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(): Renderable
    {
        $menus = Menu::with(['parent'])->get();

        return $this->view($this->viewPath.'index', [
            'menus' => $menus
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(): Renderable
    {
        $menus = Menu::all();
        $menuTypes = MenuType::all();
        $languages = Language::where(['status' => 1])->get();

        return $this->view($this->viewPath.'create', [
            'menus' => $menus,
            'menuTypes' => $menuTypes,
            'languages' => $languages
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request['slug'] = Str::slug($request->post('slug'));

        $request->validate([
            'menu_type_id' => 'required',
            'sort' => 'required',
            'slug' => 'required|unique:menus,slug|max:191',
            'title' => 'required',
            'url' => 'required'
        ]);

        $data = [
            'parent_id' => $request->post('parent_id', 0),
            'menu_type_id' => $request->post('menu_type_id', 0),
            'sort' => $request->post('sort', 0),
            'slug' => $request->post('slug', ''),
            'status' => $request->post('status') === null ? 0 : 1,
            'style' => $request->post('style'),
            'target_blank' => $request->post('target_blank') === null ? 0 : 1,
            'is_new' => $request->post('is_new') === null ? 0 : 1
        ];

        $urls = $request->post('url');
        $titles = $request->post('title');

        foreach ($titles as $key => $value) {

            $data[$key] = [
                'title' => $value,
                'url' => $urls[$key] ?? null,
            ];
        }

        if (Menu::create($data)) {
            return redirect()
                ->route('content.menu.index')
                ->with('success', 'Səhifə uğurla əlavə edildi');
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
        $menu = Menu::findOrFail($id);

        return $this->view($this->viewPath.'show', [
            'menu' => $menu
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(int $id): Renderable
    {
        $translations = [];
        $menu = Menu::findOrFail($id);
        $menus = Menu::where('id', '!=', $id)->get();
        $menuTypes = MenuType::all();
        $languages = Language::where(['status' => 1])->get();

        foreach ($menu->translations as $translation) {
            $translations[$translation->locale] = [
                'url' => $translation['url'],
                'title' => $translation['title']
            ];
        }

        return $this->view($this->viewPath.'edit', [
            'menu' => $menu,
            'menus' => $menus,
            'menuTypes' => $menuTypes,
            'languages' => $languages,
            'translations' => $translations
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
        $menu = Menu::findOrFail($id);

        $request['slug'] = Str::slug($request->post('slug'));

        $request->validate([
            'menu_type_id' => 'required',
            'sort' => 'required',
            'slug' => 'required|unique:menus,slug,'.$id.'|max:191',
            'title' => 'required',
            'url' => 'required'
        ]);

        $data = [
            'parent_id' => $request->post('parent_id', 0),
            'menu_type_id' => $request->post('menu_type_id', 0),
            'sort' => $request->post('sort', 0),
            'slug' => $request->post('slug', ''),
            'style' => $request->post('style'),
            'target_blank' => $request->post('target_blank') === null ? 0 : 1,
            'is_new' => $request->post('is_new') === null ? 0 : 1,
            'status' => $request->post('status') === null ? 0 : 1
        ];

        $urls = $request->post('url');
        $titles = $request->post('title');

        foreach ($titles as $key => $value) {

            $data[$key] = [
                'title' => $value,
                'url' => $urls[$key] ?? null,
            ];
        }

        if ($menu->update($data)) {
            return redirect()
                ->route('content.menu.index')
                ->with('success', 'Səhifə uğurla əlavə edildi');
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
        Menu::findOrFail($id)->delete();

        return back()->with('message', 'Uğurla silindi')
            ->with('type', 'success');
    }
}

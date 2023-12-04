<?php

namespace Modules\Admin\Http\Controllers\Content;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Modules\Admin\Entities\Page;
use Modules\Admin\Entities\Language;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Support\Renderable;
use Modules\Admin\Http\Controllers\Controller;

class PageController extends Controller
{
    /**
     * @var string $viewPath
     */
    protected string $viewPath = 'pages.content.pages.';

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(): Renderable
    {
        $pages = Page::all();

        return $this->view($this->viewPath.'index', [
            'pages' => $pages
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(): Renderable
    {
        $languages = Language::where(['status' => 1])->get();

        return $this->view($this->viewPath.'create', [
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
            'sort' => 'required',
            'slug' => 'required|unique:pages,slug|max:191',
            'title' => 'required',
            'description' => 'required'
        ]);

        $data = [
            'sort' => $request->post('sort') ?? "",
            'slug' => $request->post('slug') ?? "",
            'status' => $request->post('status') === null ? 0 : 1
        ];

        $titles = $request->post('title');

        $descriptions = $request->post('description');

        foreach ($titles as $key => $value) {

            $data[$key] = [
                'title' => $value,
                'description' => $descriptions[$key] ?? null,
            ];
        }

        if (Page::create($data)) {
            return redirect()
                ->route('content.pages.index')
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
        $page = Page::findOrFail($id);

        return $this->view($this->viewPath.'show', [
            'page' => $page
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(int $id): Renderable
    {
        $page = Page::findOrFail($id);

        $languages = Language::where(['status' => 1])->get();

        $translations = [];

        foreach ($page->translations as $translation) {
            $translations[$translation->locale] = [
                'title' => $translation['title'],
                'description' => $translation['description'],
            ];
        }

        return $this->view($this->viewPath.'edit', [
            'page' => $page,
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
        $page = Page::findOrFail($id);

        $request['slug'] = Str::slug($request->post('slug'));

        $request->validate([
            'sort' => 'required',
            'slug' => 'required|unique:pages,slug,'.$id.'|max:191',
            'title' => 'required',
            'description' => 'required'
        ]);

        $data = [
            'sort' => $request->post('sort') ?? "",
            'slug' => $request->post('slug') ?? "",
            'status' => $request->post('status') === null ? 0 : 1
        ];

        $titles = $request->post('title');

        $descriptions = $request->post('description');

        foreach ($titles as $key => $value) {

            $data[$key] = [
                'title' => $value,
                'description' => $descriptions[$key] ?? null,
            ];
        }

        if ($page->update($data)) {
            return redirect()
                ->route('content.pages.index')
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
        Page::findOrFail($id)->delete();

        return back()->with('message', 'Uğurla silindi')
            ->with('type', 'success');
    }
}

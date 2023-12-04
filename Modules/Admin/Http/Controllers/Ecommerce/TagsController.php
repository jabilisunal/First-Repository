<?php

namespace Modules\Admin\Http\Controllers\Ecommerce;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Str;
use Modules\Admin\Http\Controllers\Controller;

class TagsController extends Controller
{
    /**
     * @var string $viewPath
     */
    protected string $viewPath = 'pages.ecommerce.tags.';

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(): Renderable
    {
        $tags = Tag::all();

        return $this->view($this->viewPath . 'index', [
            'tags' => $tags
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(): Renderable
    {
        return $this->view($this->viewPath . 'create');
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
            'slug' => 'required',
            'name' => 'required'
        ]);

        $data = [
            'name' => $request->post('name'),
            'slug' => $request->post('slug') ?? "",
        ];

        if (Tag::create($data)) {
            return redirect()
                ->route('ecommerce.tags.index')
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
        $tags = Tag::findOrFail($id);

        return $this->view($this->viewPath . 'show', [
            'tags' => $tags
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(int $id): Renderable
    {
        $tags = Tag::findOrFail($id);

        return $this->view($this->viewPath . 'edit', [
            'tags' => $tags
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
        $tags = Tag::findOrFail($id);

        $request['slug'] = Str::slug($request->post('slug'));

        $request->validate([
            'slug' => 'required',
            'name' => 'required'
        ]);

        $data = [
            'name' => $request->post('name'),
            'slug' => $request->post('slug') ?? "",
        ];

        if ($tags->update($data)) {
            return redirect()
                ->route('ecommerce.tags.index')
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
        Tag::findOrFail($id)->delete();

        return back()->with('message', 'Uğurla silindi')
            ->with('type', 'success');
    }
}

<?php

namespace Modules\Admin\Http\Controllers\Ecommerce;

use App\Models\Category;
use App\Services\CropService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Modules\Admin\Entities\File;
use Modules\Admin\Entities\Language;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Support\Renderable;
use Modules\Admin\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * @var string $viewPath
     */
    protected string $viewPath = 'pages.ecommerce.category.';

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(): Renderable
    {
        $categories = Category::with(['parent'])->get();

        return $this->view($this->viewPath.'index', [
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(): Renderable
    {
        $categories = Category::all();

        $languages = Language::where(['status' => 1])->get();

        return $this->view($this->viewPath.'create', [
            'categories' => $categories,
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
            'slug' => 'required|unique:categories,slug|max:191',
            'title' => 'required'
        ]);

        $data = [
            'parent_id' => $request->post('parent_id'),
            'sort' => $request->post('sort', 0),
            'slug' => $request->post('slug', ''),
            'status' => $request->post('status') === null ? 0 : 1
        ];

        $titles = $request->post('title');

        foreach ($titles as $key => $value) {

            $data[$key] = [
                'title' => $value
            ];
        }

        if ($category = Category::create($data)) {

            if ($request->hasFile('image')) {

                $file = $request->file('image');
                $path = Storage::putFile('media', $file);

                $image =  File::create([
                    'user_id' => auth()->id(),
                    'disk' => config('filesystems.default'),
                    'filename' => $file->getClientOriginalName(),
                    'path' => $path,
                    'extension' => $file->guessClientExtension() ?? '',
                    'mime' => $file->getClientMimeType(),
                    'size' => $file->getSize(),
                ]);

                CropService::crop($file, $path);

                $category->syncFiles(['base_image' => [$image->id]]);
            }

            if ($request->hasFile('additional_image')) {

                $file = $request->file('additional_image');
                $path = Storage::putFile('media', $file);

                $additional_image =  File::create([
                    'user_id' => auth()->id(),
                    'disk' => config('filesystems.default'),
                    'filename' => $file->getClientOriginalName(),
                    'path' => $path,
                    'extension' => $file->guessClientExtension() ?? '',
                    'mime' => $file->getClientMimeType(),
                    'size' => $file->getSize(),
                ]);

                $category->syncFiles(['additional_images' => [$additional_image->id]]);
            }

            return redirect()
                ->route('ecommerce.category.index')
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
        $category = Category::findOrFail($id);

        return $this->view($this->viewPath.'show', [
            'category' => $category
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
        $category = Category::findOrFail($id);
        $categories = Category::where('id', '!=', $id)->get();
        $languages = Language::where(['status' => 1])->get();

        foreach ($category->translations as $translation) {
            $translations[$translation->locale] = [
                'title' => $translation['title']
            ];
        }

        return $this->view($this->viewPath.'edit', [
            'category' => $category,
            'categories' => $categories,
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
        $category = Category::findOrFail($id);

        $request['slug'] = Str::slug($request->post('slug'));

        $request->validate([
            'sort' => 'required',
            'slug' => 'required|unique:categories,slug,'.$id.'|max:191',
            'title' => 'required'
        ]);

        $data = [
            'parent_id' => $request->post('parent_id', null),
            'sort' => $request->post('sort', 0),
            'slug' => $request->post('slug', ''),
            'status' => $request->post('status') === null ? 0 : 1
        ];

        $titles = $request->post('title');

        foreach ($titles as $key => $value) {
            $data[$key] = [
                'title' => $value
            ];
        }

        if ($category->update($data)) {

            if ($request->hasFile('image')) {

                $file = $request->file('image');
                $path = Storage::putFile('media', $file);

                $image =  File::create([
                    'user_id' => auth()->id(),
                    'disk' => config('filesystems.default'),
                    'filename' => $file->getClientOriginalName(),
                    'path' => $path,
                    'extension' => $file->guessClientExtension() ?? '',
                    'mime' => $file->getClientMimeType(),
                    'size' => $file->getSize(),
                ]);

                CropService::crop($file, $path);

                $category->syncFiles(['base_image' => [$image->id]]);
            }


            if ($request->hasFile('additional_image')) {

                $additional_file = $request->file('additional_image');
                $additional_file_path = Storage::putFile('media', $additional_file);

                $additional_image =  File::create([
                    'user_id' => auth()->id(),
                    'disk' => config('filesystems.default'),
                    'filename' => $additional_file->getClientOriginalName(),
                    'path' => $additional_file_path,
                    'extension' => $additional_file->guessClientExtension() ?? '',
                    'mime' => $additional_file->getClientMimeType(),
                    'size' => $additional_file->getSize(),
                ]);

                $category->syncFiles(['additional_images' => [$additional_image->id]]);
            }

            return redirect()
                ->route('ecommerce.category.index')
                ->with('success', 'Uğurla əlavə edildi');
        }

        return redirect()
            ->back()
            ->with('danger', 'Bir xəta baş verdi. Yenidən cəhd edin');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $category = Category::findOrFail($id);

        if ($category->delete()) {
            return response()->json([
                'status' => true
            ]);
        }

        return response()->json([
            'status' => false
        ]);
    }
}

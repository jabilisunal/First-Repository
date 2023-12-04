<?php

namespace Modules\Admin\Http\Controllers\Ecommerce;

use App\Models\Brand;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\CropService;
use Modules\Admin\Entities\File;
use Modules\Admin\Entities\Language;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Support\Renderable;
use Modules\Admin\Http\Controllers\Controller;

class BrandController extends Controller
{
    /**
     * @var string $viewPath
     */
    protected string $viewPath = 'pages.ecommerce.brand.';

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(): Renderable
    {
        $brands = Brand::all();

        return $this->view($this->viewPath . 'index', [
            'brands' => $brands
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(): Renderable
    {
        $languages = Language::where(['status' => 1])->get();

        return $this->view($this->viewPath . 'create', [
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
            'image' => 'required|mimes:jpg,jpeg,png,bmp,gif,svg,webp',
            'slug' => 'required|unique:brands,slug|max:191',
            'title' => 'required'
        ]);

        $data = [
            'sort' => $request->post('sort') ?? "",
            'slug' => $request->post('slug') ?? "",
            'status' => $request->post('status') === null ? 0 : 1
        ];

        $titles = $request->post('title');

        foreach ($titles as $key => $value) {
            $data[$key] = [
                'title' => $value
            ];
        }

        if ($brand = Brand::create($data)) {

            if ($request->hasFile('image')) {

                $file = $request->file('image');
                $path = Storage::putFile('media', $file);

                $image = File::create([
                    'user_id' => auth()->id(),
                    'disk' => config('filesystems.default'),
                    'filename' => $file->getClientOriginalName(),
                    'path' => $path,
                    'extension' => $file->guessClientExtension() ?? '',
                    'mime' => $file->getClientMimeType(),
                    'size' => $file->getSize(),
                ]);

                CropService::crop($file, $path);

                $brand->syncFiles(['base_image' => [$image->id]]);
            }

            return redirect()
                ->route('ecommerce.brand.index')
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
        $brand = Brand::findOrFail($id);

        return $this->view($this->viewPath . 'show', [
            'brand' => $brand
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(int $id): Renderable
    {
        $brand = Brand::findOrFail($id);

        $languages = Language::where(['status' => 1])->get();

        $translations = [];

        foreach ($brand->translations as $translation) {
            $translations[$translation->locale] = [
                'title' => $translation['title']
            ];
        }

        return $this->view($this->viewPath . 'edit', [
            'brand' => $brand,
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
        $brand = Brand::findOrFail($id);

        $request['slug'] = Str::slug($request->post('slug'));

        $request->validate([
            'sort' => 'required',
            'image' => 'mimes:jpeg,png,jpg,gif',
            'slug' => 'required|unique:brands,slug,'.$id.'|max:191',
            'title' => 'required'
        ]);

        $data = [
            'sort' => $request->post('sort') ?? "",
            'slug' => $request->post('slug') ?? "",
            'status' => $request->post('status') === null ? 0 : 1
        ];

        $titles = $request->post('title');

        foreach ($titles as $key => $value) {
            $data[$key] = [
                'title' => $value
            ];
        }

        if ($brand->update($data)) {

            if ($request->hasFile('image')) {

                $file = $request->file('image');
                $path = Storage::putFile('media', $file);

                $image = File::create([
                    'user_id' => auth()->id(),
                    'disk' => config('filesystems.default'),
                    'filename' => $file->getClientOriginalName(),
                    'path' => $path,
                    'extension' => $file->guessClientExtension() ?? '',
                    'mime' => $file->getClientMimeType(),
                    'size' => $file->getSize(),
                ]);

                CropService::crop($file, $path);

                $brand->syncFiles(['base_image' => [$image->id]]);
            }

            return redirect()
                ->route('ecommerce.brand.index')
                ->with('success', 'Səhifə uğurla əlavə edildi');
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
        $brand = Brand::findOrFail($id);

        if ($brand->delete()) {
            return response()->json([
                'status' => true
            ]);
        }

        return response()->json([
            'status' => false
        ]);
    }
}

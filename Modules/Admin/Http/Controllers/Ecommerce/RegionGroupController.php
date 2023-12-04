<?php

namespace Modules\Admin\Http\Controllers\Ecommerce;

use App\Models\Destination;
use App\Models\RegionGroup;
use App\Services\CropService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Modules\Admin\Entities\File;
use Modules\Admin\Entities\Language;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Support\Renderable;
use Modules\Admin\Http\Controllers\Controller;

class RegionGroupController extends Controller
{
    /**
     * @var string $viewPath
     */
    protected string $viewPath = 'pages.ecommerce.region-group.';

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(): Renderable
    {
        $regionGroups = RegionGroup::all();

        return $this->view($this->viewPath . 'index', [
            'regionGroups' => $regionGroups
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(): Renderable
    {
        $languages = Language::where(['status' => 1])->get();

        $destinations = Destination::where(['status' => 1])->get();

        return $this->view($this->viewPath . 'create', [
            'languages' => $languages,
            'destinations' => $destinations
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
            'slug' => 'required|unique:region_groups,slug|max:191',
            'name' => 'required'
        ]);

        $data = [
            'sort' => $request->post('sort') ?? "",
            'slug' => $request->post('slug', ''),
            'status' => $request->post('status') === null ? 0 : 1
        ];

        $names = $request->post('name');

        foreach ($names as $key => $value) {
            $data[$key] = [
                'name' => $value
            ];
        }

        if ($regionGroup = RegionGroup::create($data)) {

            $regionGroup->destinations()->sync($request->post('destinations'));

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

                $regionGroup->syncFiles(['base_image' => [$image->id]]);
            }

            return redirect()
                ->route('ecommerce.region-groups.index')
                ->with('success', 'Region Qurupu uğurla əlavə edildi');
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
        $regionGroup = RegionGroup::findOrFail($id);

        return $this->view($this->viewPath . 'show', [
            'regionGroup' => $regionGroup
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

        $regionGroup = RegionGroup::findOrFail($id);

        $languages = Language::where(['status' => 1])->get();

        $destinations = Destination::where(['status' => 1])->get();

        foreach ($regionGroup->translations as $translation) {
            $translations[$translation->locale] = [
                'name' => $translation['name']
            ];
        }

        return $this->view($this->viewPath . 'edit', [
            'languages' => $languages,
            'regionGroup' => $regionGroup,
            'destinations' => $destinations,
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
        $regionGroup = RegionGroup::findOrFail($id);

        $request['slug'] = Str::slug($request->post('slug'));

        $request->validate([
            'sort' => 'required',
            'slug' => 'required|unique:region_groups,slug,'.$id.'|max:191',
            'name' => 'required'
        ]);

        $data = [
            'slug' => $request->post('slug', ''),
            'sort' => $request->post('sort') ?? "",
            'status' => $request->post('status') === null ? 0 : 1
        ];

        $names = $request->post('name');

        foreach ($names as $key => $value) {
            $data[$key] = [
                'name' => $value
            ];
        }

        if ($regionGroup->update($data)) {

            $regionGroup->destinations()->sync($request->post('destinations'));

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

                $regionGroup->syncFiles(['base_image' => [$image->id]]);
            }

            return redirect()
                ->route('ecommerce.region-groups.index')
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
        $regionGroup = RegionGroup::findOrFail($id);

        $regionGroup->destinations()->sync([]);

        if ($regionGroup->delete()) {
            return response()->json([
                'status' => true
            ]);
        }

        return response()->json([
            'status' => false
        ]);
    }
}

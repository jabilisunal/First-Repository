<?php


namespace Modules\Admin\Http\Controllers\Ecommerce;

use App\Models\Facility;
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

class FacilityController extends Controller
{
    /**
     * @var string $viewPath
     */
    protected string $viewPath = 'pages.ecommerce.facility.';

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(): Renderable
    {
        $facilities = Facility::all();

        return $this->view($this->viewPath . 'index', [
            'facilities' => $facilities
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
            'languages' => $languages,
            'facilityTypes' => Facility::TYPES
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
            'type' => 'required',
            'sort' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png,bmp,gif,svg,webp',
            'name' => 'required'
        ]);

        $data = [
            'type' => $request->post('type') ?? "",
            'sort' => $request->post('sort') ?? "",
            'status' => $request->post('status') === null ? 0 : 1
        ];

        $names = $request->post('name');

        foreach ($names as $key => $value) {
            $data[$key] = [
                'name' => $value
            ];
        }

        if ($facility = Facility::create($data)) {

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

                $facility->syncFiles(['base_image' => [$image->id]]);
            }

            return redirect()
                ->route('ecommerce.facilities.index')
                ->with('success', 'Facility uğurla əlavə edildi');
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
        $facility = Facility::findOrFail($id);

        return $this->view($this->viewPath . 'show', [
            'facility' => $facility
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(int $id): Renderable
    {
        $facility = Facility::findOrFail($id);

        $languages = Language::where(['status' => 1])->get();

        $translations = [];

        foreach ($facility->translations as $translation) {
            $translations[$translation->locale] = [
                'name' => $translation['name']
            ];
        }

        return $this->view($this->viewPath . 'edit', [
            'facility' => $facility,
            'languages' => $languages,
            'translations' => $translations,
            'facilityTypes' => Facility::TYPES
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
        $facility = Facility::findOrFail($id);

        $request['slug'] = Str::slug($request->post('slug'));

        $request->validate([
            'type' => 'required',
            'sort' => 'required',
            'image' => 'mimes:jpeg,png,jpg,gif',
            'name' => 'required'
        ]);

        $data = [
            'type' => $request->post('type') ?? "",
            'sort' => $request->post('sort') ?? "",
            'status' => $request->post('status') === null ? 0 : 1
        ];

        $names = $request->post('name');

        foreach ($names as $key => $value) {
            $data[$key] = [
                'name' => $value
            ];
        }

        if ($facility->update($data)) {

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

                $facility->syncFiles(['base_image' => [$image->id]]);
            }

            return redirect()
                ->route('ecommerce.facilities.index')
                ->with('success', 'Facility uğurla əlavə edildi');
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
        $facility = Facility::findOrFail($id);

        if ($facility->delete()) {
            return response()->json([
                'status' => true
            ]);
        }

        return response()->json([
            'status' => false
        ]);
    }
}

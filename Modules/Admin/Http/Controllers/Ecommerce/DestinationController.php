<?php


namespace Modules\Admin\Http\Controllers\Ecommerce;

use App\Models\Destination;
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

class DestinationController extends Controller
{
    /**
     * @var string $viewPath
     */
    protected string $viewPath = 'pages.ecommerce.destination.';

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(): Renderable
    {
        $destinations = Destination::all();

        return $this->view($this->viewPath . 'index', [
            'destinations' => $destinations
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
            'slug' => 'required|unique:destinations,slug|max:191',
            'name' => 'required'
        ]);

        $data = [
            'sort' => $request->post('sort') ?? "",
            'slug' => $request->post('slug') ?? "",
            'status' => $request->post('status') === null ? 0 : 1
        ];

        $names = $request->post('name');

        foreach ($names as $key => $value) {
            $data[$key] = [
                'name' => $value
            ];
        }

        if ($destination = Destination::create($data)) {

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

                $destination->syncFiles(['base_image' => [$image->id]]);
            }

            return redirect()
                ->route('ecommerce.destinations.index')
                ->with('success', 'Destination uğurla əlavə edildi');
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
        $destination = Destination::findOrFail($id);

        return $this->view($this->viewPath . 'show', [
            'destination' => $destination
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(int $id): Renderable
    {
        $destination = Destination::findOrFail($id);

        $languages = Language::where(['status' => 1])->get();

        $translations = [];

        foreach ($destination->translations as $translation) {
            $translations[$translation->locale] = [
                'name' => $translation['name']
            ];
        }

        return $this->view($this->viewPath . 'edit', [
            'destination' => $destination,
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
        $destination = Destination::findOrFail($id);

        $request['slug'] = Str::slug($request->post('slug'));

        $request->validate([
            'sort' => 'required',
            'image' => 'mimes:jpeg,png,jpg,gif',
            'slug' => 'required|unique:destinations,slug,'.$id.'|max:191',
            'name' => 'required'
        ]);

        $data = [
            'sort' => $request->post('sort') ?? "",
            'slug' => $request->post('slug') ?? "",
            'status' => $request->post('status') === null ? 0 : 1
        ];

        $names = $request->post('name');

        foreach ($names as $key => $value) {
            $data[$key] = [
                'name' => $value
            ];
        }

        if ($destination->update($data)) {

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

                $destination->syncFiles(['base_image' => [$image->id]]);
            }

            return redirect()
                ->route('ecommerce.destinations.index')
                ->with('success', 'Destination uğurla əlavə edildi');
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
        $destination = Destination::findOrFail($id);

        if ($destination->delete()) {
            return response()->json([
                'status' => true
            ]);
        }

        return response()->json([
            'status' => false
        ]);
    }
}

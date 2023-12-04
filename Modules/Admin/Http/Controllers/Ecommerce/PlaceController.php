<?php

namespace Modules\Admin\Http\Controllers\Ecommerce;

use JsonException;
use App\Models\Tag;
use App\Models\Place;
use App\Models\Address;
use App\Models\Category;
use App\Models\Facility;
use Illuminate\Support\Str;
use App\Models\Destination;
use App\Models\RegionGroup;
use Illuminate\Http\Request;
use App\Models\PlaceTranslation;
use Modules\Admin\Entities\File;
use Illuminate\Http\JsonResponse;
use Modules\Admin\Entities\Language;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Support\Renderable;
use Modules\Admin\Http\Controllers\Controller;

class PlaceController extends Controller
{
    /**
     * @var string $viewPath
     */
    protected string $viewPath = 'pages.ecommerce.place.';

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(): Renderable
    {
        $places = Place::all();

        return $this->view($this->viewPath . 'index', [
            'places' => $places
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(): Renderable
    {
        $tags = Tag::all();

        $languages = Language::where(['status' => 1])->get();

        $regionGroups = RegionGroup::where(['status' => 1])->get();

        $destinations = Destination::where(['status' => 1])->get();

        $categories = Category::where(['status' => 1 ])->whereIn('id', Category::PLACE_TYPES)->get();

        $facilities = Facility::where(['status' => 1])
            ->whereIn('type', [
                Facility::HOTEl,
                Facility::APARTMENT,
                Facility::RESTAURANT,
            ])->get();

        return $this->view($this->viewPath . 'create', [
            'tags' => $tags,
            'languages' => $languages,
            'categories' => $categories,
            'facilities' => $facilities,
            'destinations' => $destinations,
            'regionGroups' => $regionGroups
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Slug Generator
        $request['slug'] = Str::slug($request->post('slug'));

        // Validation
        $request->validate([
            'category_id' => 'required',
            'destination_id' => 'required',
            'region_group_id' => 'required',
            'price' => 'required',
            'booking_url' => 'nullable',
            'sort' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png,bmp,gif,svg,webp',
            'slug' => 'required|unique:places,slug|max:191',
            'title' => 'required'
        ]);

        // Place Data
        $data = [
            'price' => $request->post('price'),
            'booking_url' => $request->post('booking_url'),
            'category_id' => $request->post('category_id'),
            'region_group_id' => $request->post('region_group_id'),
            'destination_id' => $request->post('destination_id'),
            'sort' => $request->post('sort') ?? "",
            'slug' => $request->post('slug') ?? "",
            'status' => $request->post('status') === null ? 0 : 1,
            'is_popular' => $request->post('is_popular') === null ? 0 : 1,
        ];

        // Translation
        $titles = $request->post('title');
        $whyChooseUs = $request->post('why_choose_us');
        $description = $request->post('description');

        foreach ($titles as $key => $value) {
            $data[$key] = [
                'title' => $value,
                'why_choose_us' => $whyChooseUs[$key],
                'description' => $description[$key],
            ];
        }

        // Create Place
        if ($place = Place::create($data)) {

            // Place Tags
            $place->tags()->sync($request->post('tags'));

            // Place Facilities
            $place->facilities()->sync($request->post('facilities'));

            // Address
            $addressData = [
                'name' => $request->input('address_name'),
                'latitude' => $request->input('address_latitude'),
                'longitude' => $request->input('address_longitude'),
                'zoom' => $request->input('address_zoom'),
                'sort' => $request->input('address_sort', 1),
                'status' => $request->input('address_status') === null ? 0 : 1,
            ];

            Address::updateOrCreate([
                'model_id' => $place->id,
                'model_type' => Place::class
            ], $addressData);

            // All Images
            $imageSync = [];

            // Place Base Image
            if ($request->hasFile('image')) {

                $file = $request->file('image');

                $filePath = filePathGenerator(
                    'places/base/',
                    'place_base_',
                    '.'.$file->getClientOriginalExtension()
                );

                $file->storeAs('media', $filePath, 'public');

                $image = File::create([
                    'user_id' => auth()->id(),
                    'disk' => config('filesystems.default'),
                    'filename' => $file->getClientOriginalName(),
                    'path' => $filePath,
                    'extension' => $file->guessClientExtension() ?? '',
                    'mime' => $file->getClientMimeType(),
                    'size' => $file->getSize(),
                ]);

                $imageSync['base_image'] = [$image->id];
            }

            // Place Cover Image
            if ($request->hasFile('cover')) {

                $file = $request->file('cover');

                $filePath = filePathGenerator(
                    'places/cover/',
                    'place_cover_',
                    '.'.$file->getClientOriginalExtension()
                );

                $file->storeAs('media', $filePath, 'public');

                $image = File::create([
                    'user_id' => auth()->id(),
                    'disk' => config('filesystems.default'),
                    'filename' => $file->getClientOriginalName(),
                    'path' => $filePath,
                    'extension' => $file->guessClientExtension() ?? '',
                    'mime' => $file->getClientMimeType(),
                    'size' => $file->getSize(),
                ]);

                $imageSync['cover_image'] = [$image->id];
            }

            // Place Additional Images
            if ($request->hasFile('images')) {

                $files = [];

                $images = $request->file('images');

                foreach ($images as $image) {

                    $filePath = filePathGenerator(
                        'places/additional/',
                        'place_additional_',
                        '.' . $image->getClientOriginalExtension()
                    );

                    $image->storeAs('media', $filePath, 'public');

                    $saveImage = File::create([
                        'user_id' => auth()->id(),
                        'disk' => config('filesystems.default'),
                        'filename' => $image->getClientOriginalName(),
                        'path' => $filePath,
                        'extension' => $image->guessClientExtension() ?? '',
                        'mime' => $image->getClientMimeType(),
                        'size' => $image->getSize(),
                    ]);

                    $files[] = $saveImage->id;
                }

                $imageSync['additional_images'] = $files;
            }

            // Sync Images
            $place->syncFiles($imageSync);

            return redirect()
                ->route('ecommerce.places.index')
                ->with('success', 'Place uğurla əlavə edildi');
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
        $place = Place::findOrFail($id);

        return $this->view($this->viewPath . 'show', [
            'place' => $place
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     * @throws JsonException
     */
    public function edit(int $id): Renderable
    {
        /**
         * @var Place $place
         */
        $place = Place::with(['address'])->findOrFail($id);

        $tags = Tag::all();

        $languages = Language::where(['status' => 1])->get();

        $categories = Category::where(['status' => 1])->get();

        $destinations = Destination::where(['status' => 1])->get();

        $regionGroups = RegionGroup::where(['status' => 1])->get();

        $facilities = Facility::where(['status' => 1])
            ->whereIn('type', [
                Facility::HOTEl,
                Facility::APARTMENT,
                Facility::RESTAURANT,
            ])->get();

        $translations = [];

        foreach ($place->translations as $translation) {
            $translations[$translation->locale] = [
                'title' => $translation['title'],
                'why_choose_us' => $translation['why_choose_us'],
                'description' => $translation['description']
            ];
        }

        $initialPreview = [];
        $initialPreviewConfig = [];

        foreach ($place->additional_images as $key => $image) {
            $initialPreview[] = "/storage/public/media/".$image->path;
            $initialPreviewConfig[] = [
                'key' => $key + 1,
                'caption' => $image->filename,
                'size' => $image->size,
                'url' => "/storage/public/media/".$image->path,
            ];
        }

        return $this->view($this->viewPath . 'edit', [
            'place' => $place,
            'tags' => $tags,
            'languages' => $languages,
            'categories' => $categories,
            'destinations' => $destinations,
            'facilities' => $facilities,
            'translations' => $translations,
            'regionGroups' => $regionGroups,
            'initialPreview' => json_encode($initialPreview, JSON_THROW_ON_ERROR),
            'initialPreviewConfig' => json_encode($initialPreviewConfig, JSON_THROW_ON_ERROR),
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
        /**
         * @var Place $place
         */
        $place = Place::findOrFail($id);

        // Slug Generator
        $request['slug'] = Str::slug($request->post('slug'));

        // Validation
        $request->validate([
            'category_id' => 'required',
            'region_group_id' => 'required',
            'destination_id' => 'required',
            'price' => 'required',
            'booking_url' => 'nullable',
            'sort' => 'required',
            'slug' => 'required|unique:places,slug,'.$id.'|max:191',
            'title' => 'required'
        ]);

        // Place Data
        $data = [
            'price' => $request->post('price'),
            'sort' => $request->post('sort') ?? "",
            'slug' => $request->post('slug') ?? "",
            'booking_url' => $request->post('booking_url'),
            'category_id' => $request->post('category_id'),
            'status' => $request->post('status') === null ? 0 : 1,
            'region_group_id' => $request->post('region_group_id'),
            'destination_id' => $request->post('destination_id'),
            'is_popular' => $request->post('is_popular') === null ? 0 : 1
        ];

        // Translation
        $titles = $request->post('title');
        $whyChooseUs = $request->post('why_choose_us');
        $description = $request->post('description');

        foreach ($titles as $key => $value) {
            $data[$key] = [
                'title' => $value,
                'why_choose_us' => $whyChooseUs[$key],
                'description' => $description[$key],
            ];
        }

        if ($place->update($data)) {

            // Place Tags
            $place->tags()->sync($request->post('tags'));

            // Place Facilities
            $place->facilities()->sync($request->post('facilities'));

            // Address
            $addressData = [
                'name' => $request->input('address_name'),
                'latitude' => $request->input('address_latitude'),
                'longitude' => $request->input('address_longitude'),
                'zoom' => $request->input('address_zoom'),
                'sort' => $request->input('address_sort', 1),
                'status' => $request->input('address_status') === null ? 0 : 1
            ];

            Address::updateOrCreate([
                'model_id' => $place->id,
                'model_type' => Place::class
            ], $addressData);

            // All Images
            $imageSync = [];

            // Place Base Image
            if ($request->hasFile('image')) {

                $file = $request->file('image');

                $filePath = filePathGenerator(
                    'places/base/',
                    'place_base_',
                    '.'.$file->getClientOriginalExtension()
                );

                $file->storeAs('media', $filePath, 'public');

                $image = File::create([
                    'user_id' => auth()->id(),
                    'disk' => config('filesystems.default'),
                    'filename' => $file->getClientOriginalName(),
                    'path' => $filePath,
                    'extension' => $file->guessClientExtension() ?? '',
                    'mime' => $file->getClientMimeType(),
                    'size' => $file->getSize(),
                ]);

                $imageSync['base_image'] = [$image->id];
            }

            // Place Cover Image
            if ($request->hasFile('cover')) {

                $file = $request->file('cover');

                $filePath = filePathGenerator(
                    'places/cover/',
                    'place_cover_',
                    '.'.$file->getClientOriginalExtension()
                );

                $file->storeAs('media', $filePath, 'public');

                $image = File::create([
                    'user_id' => auth()->id(),
                    'disk' => config('filesystems.default'),
                    'filename' => $file->getClientOriginalName(),
                    'path' => $filePath,
                    'extension' => $file->guessClientExtension() ?? '',
                    'mime' => $file->getClientMimeType(),
                    'size' => $file->getSize(),
                ]);

                $imageSync['cover_image'] = [$image->id];
            }

            // Place Additional Images
            if ($request->hasFile('images')) {

                $files = [];

                $images = $request->file('images');

                foreach ($images as $image) {

                    $filePath = filePathGenerator(
                        'places/additional/',
                        'place_additional_',
                        '.' . $image->getClientOriginalExtension()
                    );

                    $image->storeAs('media', $filePath, 'public');

                    $saveImage = File::create([
                        'user_id' => auth()->id(),
                        'disk' => config('filesystems.default'),
                        'filename' => $image->getClientOriginalName(),
                        'path' => $filePath,
                        'extension' => $image->guessClientExtension() ?? '',
                        'mime' => $image->getClientMimeType(),
                        'size' => $image->getSize(),
                    ]);

                    $files[] = $saveImage->id;
                }

                $imageSync['additional_images'] = $files;
            }

            // Sync Images
            $place->syncFiles($imageSync);

            return redirect()
                ->route('ecommerce.places.index')
                ->with('success', 'Place uğurla əlavə edildi');
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
        $place = Place::findOrFail($id);

        // Place Tags Reset
        $place->tags()->sync([]);

        // Place Facilities Reset
        $place->facilities()->sync([]);

        // Sync Images Reset
        $place->syncFiles([
            'base_image' => [],
            'cover_image' => [],
            'additional_images' => []
        ]);

        // Delete Translation
        PlaceTranslation::where(['place_id' => $place->id])->delet();

        if ($place->delete()) {
            return response()->json([
                'status' => true
            ]);
        }

        return response()->json([
            'status' => false
        ]);
    }
}

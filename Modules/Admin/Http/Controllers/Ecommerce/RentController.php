<?php

namespace Modules\Admin\Http\Controllers\Ecommerce;

use JsonException;
use App\Models\Tag;
use App\Models\Address;
use App\Models\RentCar;
use App\Models\Facility;
use App\Models\Category;
use App\Models\Destination;
use App\Models\RegionGroup;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Modules\Admin\Entities\File;
use Modules\Admin\Entities\Brand;
use Illuminate\Http\JsonResponse;
use App\Models\RentCarTranslation;
use Modules\Admin\Entities\Language;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Support\Renderable;
use Modules\Admin\Http\Controllers\Controller;

class RentController extends Controller
{
    /**
     * @var string $viewPath
     */
    protected string $viewPath = 'pages.ecommerce.rent.';

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(): Renderable
    {
        $rents = RentCar::all();

        return $this->view($this->viewPath . 'index', [
            'rents' => $rents
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

        $brands = Brand::where(['status' => 1])->get();

        $categories = Category::where(['status' => 1, 'id' => Category::RENT_CAR])->get();

        $destinations = Destination::where(['status' => 1])->get();

        $regionGroups = RegionGroup::where(['status' => 1])->get();

        $facilities = Facility::where(['status' => 1])
            ->whereIn('type', [
                Facility::RENT_CAR
            ])->get();

        $engineTypes = ['petrol', 'diesel'];

        return $this->view($this->viewPath . 'create', [
            'tags' => $tags,
            'languages' => $languages,
            'brands' => $brands,
            'categories' => $categories,
            'destinations' => $destinations,
            'regionGroups' => $regionGroups,
            'facilities' => $facilities,
            'engineTypes' => $engineTypes,
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
            'brand_id' => 'required',
            'category_id' => 'required',
            'region_group_id' => 'required',
            'destination_id' => 'required',
            'daily_price' => 'required',
            'weekly_price' => 'required',
            'monthly_price' => 'required',
            'year' => 'required',
            'seats' => 'required',
            'engine_type' => 'required',
            'sort' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png,bmp,gif,svg,webp',
            'slug' => 'required|unique:rent_cars,slug|max:191',
            'title' => 'required'
        ]);

        // RentCar Data
        $data = [
            'daily_price' => $request->post('daily_price'),
            'weekly_price' => $request->post('weekly_price'),
            'monthly_price' => $request->post('monthly_price'),
            'year' => $request->post('year'),
            'seats' => $request->post('seats'),
            'engine_type' => $request->post('engine_type'),
            'brand_id' => $request->post('brand_id'),
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
        $description = $request->post('description');
        $color = $request->post('color');

        foreach ($titles as $key => $value) {
            $data[$key] = [
                'title' => $value,
                'color' => $color[$key],
                'description' => $description[$key],
            ];
        }

        // Create RentCar
        if ($rent = RentCar::create($data)) {

            // RentCar Tags
            $rent->tags()->sync($request->post('tags'));

            // RentCar Facilities
            $rent->facilities()->sync($request->post('facilities'));

            // All Images
            $imageSync = [];

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
                'model_id' => $rent->id,
                'model_type' => RentCar::class
            ], $addressData);

            // RentCar Base Image
            if ($request->hasFile('image')) {

                $file = $request->file('image');

                $filePath = filePathGenerator(
                    'rents/base/',
                    'rent_base_',
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

            // Rent Car Cover Image
            if ($request->hasFile('cover')) {

                $file = $request->file('cover');

                $filePath = filePathGenerator(
                    'rents/cover/',
                    'rent_cover_',
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

            // RentCar Additional Images
            if ($request->hasFile('images')) {

                $files = [];

                $images = $request->file('images');

                foreach ($images as $image) {

                    $filePath = filePathGenerator(
                        'rents/additional/',
                        'rent_additional_',
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
            $rent->syncFiles($imageSync);

            return redirect()
                ->route('ecommerce.rents.index')
                ->with('success', 'RentCar uğurla əlavə edildi');
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
        $rent = RentCar::findOrFail($id);

        return $this->view($this->viewPath . 'show', [
            'rent' => $rent
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
        $rent = RentCar::findOrFail($id);

        $tags = Tag::all();

        $engineTypes = ['petrol', 'diesel'];

        $languages = Language::where(['status' => 1])->get();

        $brands = Brand::where(['status' => 1])->get();

        $categories = Category::where(['status' => 1])->get();

        $destinations = Destination::where(['status' => 1])->get();

        $regionGroups = RegionGroup::where(['status' => 1])->get();

        $facilities = Facility::where(['status' => 1])
            ->whereIn('type', [
                Facility::RENT_CAR
            ])->get();

        $translations = [];

        foreach ($rent->translations as $translation) {
            $translations[$translation->locale] = [
                'title' => $translation['title'],
                'color' => $translation['color'],
                'description' => $translation['description']
            ];
        }

        $initialPreview = [];
        $initialPreviewConfig = [];

        foreach ($rent->additional_images as $key => $image) {
            $initialPreview[] = "/storage/public/media/".$image->path;
            $initialPreviewConfig[] = [
                'key' => $key + 1,
                'caption' => $image->filename,
                'size' => $image->size,
                'url' => "/storage/public/media/".$image->path,
            ];
        }

        return $this->view($this->viewPath . 'edit', [
            'rent' => $rent,
            'tags' => $tags,
            'languages' => $languages,
            'engineTypes' => $engineTypes,
            'brands' => $brands,
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
        $rent = RentCar::findOrFail($id);

        // Slug Generator
        $request['slug'] = Str::slug($request->post('slug'));

        $request->validate([
            'brand_id' => 'required',
            'category_id' => 'required',
            'region_group_id' => 'required',
            'destination_id' => 'required',
            'daily_price' => 'required',
            'weekly_price' => 'required',
            'monthly_price' => 'required',
            'year' => 'required',
            'seats' => 'required',
            'engine_type' => 'required',
            'sort' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png,bmp,gif,svg,webp',
            'slug' => 'required|unique:rent_cars,slug,'.$id.'|max:191',
            'title' => 'required'
        ]);

        // RentCar Data
        $data = [
            'daily_price' => $request->post('daily_price'),
            'weekly_price' => $request->post('weekly_price'),
            'monthly_price' => $request->post('monthly_price'),
            'year' => $request->post('year'),
            'seats' => $request->post('seats'),
            'engine_type' => $request->post('engine_type'),
            'brand_id' => $request->post('brand_id'),
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
        $description = $request->post('description');
        $color = $request->post('color');

        foreach ($titles as $key => $value) {
            $data[$key] = [
                'title' => $value,
                'color' => $color[$key],
                'description' => $description[$key],
            ];
        }

        if ($rent->update($data)) {

            // RentCar Tags
            $rent->tags()->sync($request->post('tags'));

            // RentCar Facilities
            $rent->facilities()->sync($request->post('facilities'));

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
                'model_id' => $rent->id,
                'model_type' => RentCar::class
            ], $addressData);

            // All Images
            $imageSync = [];

            // RentCar Base Image
            if ($request->hasFile('image')) {

                $file = $request->file('image');

                $filePath = filePathGenerator(
                    'rents/base/',
                    'rent_base_',
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

            // Rent Car Cover Image
            if ($request->hasFile('cover')) {

                $file = $request->file('cover');

                $filePath = filePathGenerator(
                    'rents/cover/',
                    'rent_cover_',
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

            // RentCar Additional Images
            if ($request->hasFile('images')) {

                $files = [];

                $images = $request->file('images');

                foreach ($images as $image) {

                    $filePath = filePathGenerator(
                        'rents/additional',
                        'rent_additional_',
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
            $rent->syncFiles($imageSync);

            return redirect()
                ->route('ecommerce.rents.index')
                ->with('success', 'RentCar uğurla əlavə edildi');
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
        $rent = RentCar::findOrFail($id);

        // RentCar Tags Reset
        $rent->tags()->sync([]);

        // RentCar Facilities Reset
        $rent->facilities()->sync([]);

        // Sync Images Reset
        $rent->syncFiles([
            'base_image' => [],
            'additional_images' => []
        ]);

        // Delete Translation
        RentCarTranslation::where(['rent_car_id' => $rent->id])->delet();

        if ($rent->delete()) {
            return response()->json([
                'status' => true
            ]);
        }

        return response()->json([
            'status' => false
        ]);
    }
}

<?php

namespace Modules\Admin\Http\Controllers\Ecommerce;

use JsonException;
use App\Models\Tag;
use App\Models\Tour;
use App\Models\Address;
use App\Models\Facility;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\RegionGroup;
use App\Models\Destination;
use Illuminate\Http\Request;
use App\Models\TourTranslation;
use Modules\Admin\Entities\File;
use Illuminate\Http\JsonResponse;
use Modules\Admin\Entities\Language;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Support\Renderable;
use Modules\Admin\Http\Controllers\Controller;

class TourController extends Controller
{
    /**
     * @var string $viewPath
     */
    protected string $viewPath = 'pages.ecommerce.tour.';

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(): Renderable
    {
        $tours = Tour::all();

        return $this->view($this->viewPath . 'index', [
            'tours' => $tours
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

        $categories = Category::where(['status' => 1])->get();

        $destinations = Destination::where(['status' => 1])->get();

        $regionGroups = RegionGroup::where(['status' => 1])->get();

        $facilities = Facility::where(['status' => 1])
            ->whereIn('type', [
                Facility::TOUR
            ])->get();

        return $this->view($this->viewPath . 'create', [
            'tags' => $tags,
            'languages' => $languages,
            'categories' => $categories,
            'regionGroups' => $regionGroups,
            'destinations' => $destinations,
            'facilities' => $facilities,
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
            'region_group_id' => 'required',
            'destination_id' => 'required',
            'price' => 'required',
            'sort' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png,bmp,gif,svg,webp',
            'slug' => 'required|unique:tours,slug|max:191',
            'title' => 'required'
        ]);

        // Tour Data
        $data = [
            'price' => $request->post('price'),
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

        // Create Tour
        if ($tour = Tour::create($data)) {

            // Tour Tags
            $tour->tags()->sync($request->post('tags'));

            // Tour Facilities
            $tour->facilities()->sync($request->post('facilities'));

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
                'model_id' => $tour->id,
                'model_type' => Tour::class
            ], $addressData);

            // All Images
            $imageSync = [];

            // Tour Base Image
            if ($request->hasFile('image')) {

                $file = $request->file('image');

                $filePath = filePathGenerator(
                    'tours/',
                    'tour_',
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

            // Tour Additional Images
            if ($request->hasFile('images')) {

                $files = [];

                $images = $request->file('images');

                foreach ($images as $image) {

                    $filePath = filePathGenerator(
                        'tours/',
                        'tour_',
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
            $tour->syncFiles($imageSync);

            return redirect()
                ->route('ecommerce.tours.index')
                ->with('success', 'Tour uğurla əlavə edildi');
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
        $tour = Tour::findOrFail($id);

        return $this->view($this->viewPath . 'show', [
            'tour' => $tour
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
         * @var Tour $tour
         */
        $tour = Tour::with(['address'])->findOrFail($id);

        $tags = Tag::all();

        $languages = Language::where(['status' => 1])->get();

        $categories = Category::where(['status' => 1])->get();

        $destinations = Destination::where(['status' => 1])->get();

        $regionGroups = RegionGroup::where(['status' => 1])->get();

        $facilities = Facility::where(['status' => 1])
            ->whereIn('type', [
                Facility::TOUR
            ])->get();

        $translations = [];

        foreach ($tour->translations as $translation) {
            $translations[$translation->locale] = [
                'title' => $translation['title'],
                'why_choose_us' => $translation['why_choose_us'],
                'description' => $translation['description']
            ];
        }

        $initialPreview = [];
        $initialPreviewConfig = [];

        foreach ($tour->additional_images as $key => $image) {
            $initialPreview[] = "/storage/public/media/".$image->path;
            $initialPreviewConfig[] = [
                'key' => $key + 1,
                'caption' => $image->filename,
                'size' => $image->size,
                'url' => "/storage/public/media/".$image->path,
            ];
        }

        return $this->view($this->viewPath . 'edit', [
            'tour' => $tour,
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
        $tour = Tour::findOrFail($id);

        // Slug Generator
        $request['slug'] = Str::slug($request->post('slug'));

        // Validation
        $request->validate([
            'category_id' => 'required',
            'region_group_id' => 'required',
            'destination_id' => 'required',
            'price' => 'required',
            'sort' => 'required',
            'slug' => 'required|unique:tours,slug,'.$id.'|max:191',
            'title' => 'required'
        ]);

        // Tour Data
        $data = [
            'price' => $request->post('price'),
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

        if ($tour->update($data)) {

            // Tour Tags
            $tour->tags()->sync($request->post('tags'));

            // Tour Facilities
            $tour->facilities()->sync($request->post('facilities'));

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
                'model_id' => $tour->id,
                'model_type' => Tour::class
            ], $addressData);

            // All Images
            $imageSync = [];

            // Tour Base Image
            if ($request->hasFile('image')) {

                $file = $request->file('image');

                $filePath = filePathGenerator(
                    'tours/base/',
                    'tour_base_',
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
                    'tours/cover/',
                    'tour_cover_',
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

            // Tour Additional Images
            if ($request->hasFile('images')) {

                $files = [];

                $images = $request->file('images');

                foreach ($images as $image) {

                    $filePath = filePathGenerator(
                        'tours/additional',
                        'tour_additional_',
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
            $tour->syncFiles($imageSync);

            return redirect()
                ->route('ecommerce.tours.index')
                ->with('success', 'Tour uğurla əlavə edildi');
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
        $tour = Tour::findOrFail($id);

        // Tour Tags Reset
        $tour->tags()->sync([]);

        // Tour Facilities Reset
        $tour->facilities()->sync([]);

        // Sync Images Reset
        $tour->syncFiles([
            'base_image' => [],
            'additional_images' => []
        ]);

        // Delete Translation
        TourTranslation::where(['tour_id' => $tour->id])->delet();

        if ($tour->delete()) {
            return response()->json([
                'status' => true
            ]);
        }

        return response()->json([
            'status' => false
        ]);
    }
}

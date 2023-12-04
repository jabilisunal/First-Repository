<?php

namespace Modules\Admin\Http\Controllers\Content;

use App\Models\Banner;
use App\Services\CropService;
use Illuminate\Http\Request;
use Modules\Admin\Entities\File;
use Modules\Admin\Entities\Language;
use Illuminate\Http\RedirectResponse;
use Modules\Admin\Entities\BannerType;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Support\Renderable;
use Modules\Admin\Http\Controllers\Controller;

class BannerController extends Controller
{
    /**
     * @var string $viewPath
     */
    protected string $viewPath = 'pages.content.banners.';

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(): Renderable
    {
        $banners = Banner::all();

        return $this->view($this->viewPath.'index', [
            'banners' => $banners
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(): Renderable
    {
        $bannerTypes = BannerType::all();
        $positions = ['left', 'center', 'right'];
        $languages = Language::where(['status' => 1])->get();

        return $this->view($this->viewPath.'create', [
            'positions' => $positions,
            'languages' => $languages,
            'bannerTypes' => $bannerTypes,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'type_id' => 'required',
            'position' => 'required',
            'effect' => 'required',
            'duration' => 'required',
            'sort' => 'required',
            'title' => 'required',
            'description' => 'required'
        ]);

        $data = [
            'sort' => $request->post('sort', 0),
            'type_id' => $request->post('type_id', 0),
            'position' => $request->post('position', 'left'),
            'effect' => $request->post('effect', 'fadeInUpShorter'),
            'duration' => $request->post('duration', '1s'),
            'status' => $request->post('status') === null ? 0 : 1
        ];

        $titles = $request->post('title');
        $descriptions = $request->post('description');
        $buttonTitles = $request->post('button_title');
        $buttonUrls = $request->post('button_url');
        $buttonIcons = $request->post('button_icon');

        foreach ($titles as $key => $value) {

            $data[$key] = [
                'title' => $value,
                'description' => $descriptions[$key] ?? null,
                'button_title' => $buttonTitles[$key] ?? null,
                'button_url' => $buttonUrls[$key] ?? null,
                'button_icon' => $buttonIcons[$key] ?? null
            ];
        }

        if ($banner = Banner::create($data)) {

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

                $banner->syncFiles(['base_image' => [$image->id]]);
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

                $banner->syncFiles(['additional_images' => [$additional_image->id]]);
            }

            return redirect()
                ->route('content.banner.index')
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
        $banner = Banner::findOrFail($id);

        return $this->view($this->viewPath.'show', [
            'banner' => $banner
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

        $banner = Banner::findOrFail($id);
        $bannerTypes = BannerType::all();
        $positions = ['left', 'center', 'right'];
        $languages = Language::where(['status' => 1])->get();

        foreach ($banner->translations as $translation) {
            $translations[$translation->locale] = [
                'title' => $translation['title'],
                'description' => $translation['description'],
                'button_title' => $translation['button_title'],
                'button_url' => $translation['button_url'],
                'button_icon' => $translation['button_icon']
            ];
        }

        return $this->view($this->viewPath.'edit', [
            'banner' => $banner,
            'languages' => $languages,
            'positions' => $positions,
            'bannerTypes' => $bannerTypes,
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
        $banner = Banner::findOrFail($id);

        $request->validate([
            'type_id' => 'required',
            'position' => 'required',
            'effect' => 'required',
            'duration' => 'required',
            'sort' => 'required',
            'title' => 'required',
            'description' => 'required'
        ]);

        $data = [
            'sort' => $request->post('sort', 0),
            'type_id' => $request->post('type_id', 0),
            'position' => $request->post('position', 'left'),
            'effect' => $request->post('effect', 'fadeInUpShorter'),
            'duration' => $request->post('duration', '1s'),
            'status' => $request->post('status') === null ? 0 : 1
        ];

        $titles = $request->post('title');
        $descriptions = $request->post('description');
        $buttonTitles = $request->post('button_title');
        $buttonUrls = $request->post('button_url');
        $buttonIcons = $request->post('button_icon');

        foreach ($titles as $key => $value) {

            $data[$key] = [
                'title' => $value,
                'description' => $descriptions[$key] ?? null,
                'button_title' => $buttonTitles[$key] ?? null,
                'button_url' => $buttonUrls[$key] ?? null,
                'button_icon' => $buttonIcons[$key] ?? null
            ];
        }

        if ($banner->update($data)) {

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

                $banner->syncFiles(['base_image' => [$image->id]]);
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

                $banner->syncFiles(['additional_images' => [$additional_image->id]]);
            }

            return redirect()
                ->route('content.banner.index')
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
        Banner::findOrFail($id)->delete();

        return back()->with('message', 'Uğurla silindi')
            ->with('type', 'success');
    }
}

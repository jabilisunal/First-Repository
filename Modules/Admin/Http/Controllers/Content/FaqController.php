<?php

namespace Modules\Admin\Http\Controllers\Content;

use App\Services\CropService;
use Illuminate\Http\Request;
use Modules\Admin\Entities\File;
use App\Models\Faq;
use Modules\Admin\Entities\Language;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Support\Renderable;
use Modules\Admin\Http\Controllers\Controller;

class FaqController extends Controller
{
    /**
     * @var string $viewPath
     */
    protected string $viewPath = 'pages.content.faqs.';

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(): Renderable
    {
        $faqs = Faq::all();

        return $this->view($this->viewPath.'index', [
            'faqs' => $faqs
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(): Renderable
    {
        $languages = Language::where(['status' => 1])->get();

        return $this->view($this->viewPath.'create', [
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
        $request->validate([
            'sort' => 'required',
            'title' => 'required',
            'description' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png,bmp,gif,svg,webp',
        ]);

        $data = [
            'sort' => $request->post('sort') ?? "",
            'status' => $request->post('status') === null ? 0 : 1
        ];

        $titles = $request->post('title');

        $descriptions = $request->post('description');

        foreach ($titles as $key => $value) {

            $data[$key] = [
                'title' => $value,
                'description' => $descriptions[$key] ?? null,
            ];
        }

        if ($faq = Faq::create($data)) {

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

                $faq->syncFiles(['base_image' => [$image->id]]);
            }

            return redirect()
                ->route('content.faqs.index')
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
        $faq = Faq::findOrFail($id);

        return $this->view($this->viewPath.'show', [
            'faqs' => $faq
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(int $id): Renderable
    {
        $faq = Faq::findOrFail($id);

        $languages = Language::where(['status' => 1])->get();

        $translations = [];

        foreach ($faq->translations as $translation) {
            $translations[$translation->locale] = [
                'title' => $translation['title'],
                'description' => $translation['description'],
            ];
        }

        return $this->view($this->viewPath.'edit', [
            'faqs' => $faq,
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
        $faq = Faq::findOrFail($id);

        $request->validate([
            'sort' => 'required',
            'title' => 'required',
            'description' => 'required'
        ]);

        $data = [
            'sort' => $request->post('sort') ?? "",
            'status' => $request->post('status') === null ? 0 : 1
        ];

        $titles = $request->post('title');

        $descriptions = $request->post('description');

        foreach ($titles as $key => $value) {

            $data[$key] = [
                'title' => $value,
                'description' => $descriptions[$key] ?? null,
            ];
        }

        if ($faq->update($data)) {

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

                $faq->syncFiles(['base_image' => [$image->id]]);
            }

            return redirect()
                ->route('content.faqs.index')
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
        Faq::findOrFail($id)->delete();

        return back()->with('message', 'Uğurla silindi')
            ->with('type', 'success');
    }
}

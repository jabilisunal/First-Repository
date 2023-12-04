<?php

namespace Modules\Admin\Http\Controllers\Content;

use App\Models\Post;
use App\Services\CropService;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Modules\Admin\Entities\File;
use Modules\Admin\Entities\Language;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Support\Renderable;
use Modules\Admin\Http\Controllers\Controller;

class PostController extends Controller
{
    /**
     * @var string $viewPath
     */
    protected string $viewPath = 'pages.content.posts.';

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(): Renderable
    {
        $posts = Post::all();

        return $this->view($this->viewPath.'index', [
            'posts' => $posts
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
        $request['slug'] = Str::slug($request->post('slug'));

        $request->validate([
            'sort' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png,bmp,gif,svg,webp',
            'slug' => 'required|unique:posts,slug|max:191',
            'title' => 'required',
            'description' => 'required'
        ]);

        $data = [
            'sort' => $request->post('sort') ?? "",
            'slug' => $request->post('slug') ?? "",
            'status' => $request->post('status') === null ? 0 : 1,
            'is_popular' => $request->post('is_popular') === null ? 0 : 1
        ];

        $titles = $request->post('title');

        $descriptions = $request->post('description');

        foreach ($titles as $key => $value) {

            $data[$key] = [
                'title' => $value,
                'description' => $descriptions[$key] ?? null,
            ];
        }

        if ($post = Post::create($data)) {

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

                $post->syncFiles(['base_image' => [$image->id]]);
            }

            return redirect()
                ->route('content.posts.index')
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
        $post = Post::findOrFail($id);

        return $this->view($this->viewPath.'show', [
            'post' => $post
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(int $id): Renderable
    {
        $post = Post::findOrFail($id);

        $languages = Language::where(['status' => 1])->get();

        $translations = [];

        foreach ($post->translations as  $translation) {
            $translations[$translation->locale] = [
                'title' => $translation['title'],
                'description' => $translation['description'],
            ];
        }

        return $this->view($this->viewPath.'edit', [
            'post' => $post,
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
        $post = Post::findOrFail($id);

        $request['slug'] = Str::slug($request->post('slug'));

        $request->validate([
            'sort' => 'required',
            'image' => 'mimes:jpeg,png,jpg,gif',
            'slug' => 'required|unique:posts,slug,'.$id.'|max:191',
            'title' => 'required',
            'description' => 'required'
        ]);

        $data = [
            'sort' => $request->post('sort') ?? "",
            'slug' => $request->post('slug') ?? "",
            'status' => $request->post('status') === null ? 0 : 1,
            'is_popular' => $request->post('is_popular') === null ? 0 : 1
        ];

        $titles = $request->post('title');

        $descriptions = $request->post('description');

        foreach ($titles as $key => $value) {

            $data[$key] = [
                'title' => $value,
                'description' => $descriptions[$key] ?? null,
            ];
        }

        if ($post->update($data)) {

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

                $post->syncFiles(['base_image' => [$image->id]]);
            }

            return redirect()
                ->route('content.posts.index')
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
        Post::findOrFail($id)->delete();

        return back()->with('message', 'Uğurla silindi')
            ->with('type', 'success');
    }
}

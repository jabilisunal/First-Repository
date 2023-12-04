<?php

namespace Modules\Admin\Http\Controllers\Filemanager;

use App\Models\File;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\CropService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Modules\Admin\Transformers\FileResource;
use Modules\Admin\Http\Controllers\Controller;

class FilemanagerController extends Controller
{
    /**
     * @var string $viewPath
     */
    protected string $viewPath = 'pages.filemanager.filemanager.';


    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        if ($request->has('query')) {

            $files = File::when($request->get('query'), static function ($query) use ($request) {
                $query->where('filename', '%'.$request->get('query').'%');
            })
                ->get();

            return FileResource::collection($files);
        }

        return $this->view($this->viewPath . 'index');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request): mixed
    {
        $file = $request->file('file');

        $filePath = filePathGenerator(
            'files/',
            'file_',
            '.'.$file->getClientOriginalExtension()
        );

        $file->storeAs('media', $filePath, 'public');

        return \Modules\Admin\Entities\File::create([
            'user_id' => auth()->id(),
            'disk' => config('filesystems.default'),
            'filename' => $file->getClientOriginalName(),
            'path' => $filePath,
            'extension' => $file->guessClientExtension() ?? '',
            'mime' => $file->getClientMimeType(),
            'size' => $file->getSize(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        File::find($id)->delete();

        return back()->with('message', 'Uğurla silindi')
            ->with('type', 'success');
    }
}

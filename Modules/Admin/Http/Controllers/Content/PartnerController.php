<?php

namespace Modules\Admin\Http\Controllers\Content;

use App\Models\Partner;
use App\Services\CropService;
use Illuminate\Http\Request;
use Modules\Admin\Entities\File;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Support\Renderable;
use Modules\Admin\Http\Controllers\Controller;

class PartnerController extends Controller
{

    /**
     * @var string $viewPath
     */
    protected string $viewPath = 'pages.content.partner.';

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(): Renderable
    {
        $partners = Partner::get();

        return $this->view($this->viewPath.'index', [
            'partners' => $partners
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(): Renderable
    {
        return $this->view($this->viewPath.'create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'url' => 'required',
            'sort' => 'required',
        ]);

        $partner = Partner::create([
            'name' => $request->post('name') ?? "",
            'url' => $request->post('url') ?? "",
            'sort' => $request->post('sort') ?? "",
            'status' => $request->post('status') === null ? 0 : 1
        ]);

        if ($partner) {

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

                $partner->syncFiles(['base_image' => [$image->id]]);
            }

            return redirect()->route('content.partner.index')
                ->with('message', 'Uğurla əlavə edildi')
                ->with('type', 'success');
        }

        return redirect()->back()
            ->with('message', 'Doldurulan məlumatlarda xəta var')
            ->with('type', 'danger');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(int $id): Renderable
    {
        $partner = Partner::find($id);

        return $this->view($this->viewPath.'show', [
            'partner' => $partner
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(int $id): Renderable
    {
        $partner = Partner::find($id);

        return $this->view($this->viewPath.'edit', [
            'partner' => $partner
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
        $partner = Partner::findOrFail($id);

        $request->validate([
            'url' => 'required'
        ]);

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

            $partner->syncFiles(['base_image' => [$image->id]]);
        }

        $update = $partner->update([
            'name' => $request->post('name') ?? "",
            'url' => $request->post('url') ?? "",
            'sort' => $request->post('sort') ?? "",
            'status' => $request->post('status') === null ? 0 : 1
        ]);

        if ($update) {
            return redirect()->route('content.partner.index')
                ->with('message', 'Uğurla düzəliş edildi')
                ->with('type', 'success');
        }

        return redirect()->back()
            ->with('message', 'Doldurulan məlumatlarda xəta var')
            ->with('type', 'danger');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        Partner::findOrFail($id)->delete();

        return back()->with('message', 'Uğurla silindi')
            ->with('type', 'success');
    }
}

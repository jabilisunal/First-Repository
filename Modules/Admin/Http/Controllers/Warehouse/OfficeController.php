<?php

namespace Modules\Admin\Http\Controllers\Warehouse;

use App\Models\Office;
use App\Services\CropService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Storage;
use Modules\Admin\Entities\File;
use Modules\Admin\Http\Controllers\Controller;

class OfficeController extends Controller
{

    /**
     * @var string $viewPath
     */
    protected string $viewPath = 'pages.warehouse.offices.';

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(): Renderable
    {
        $offices = Office::get();

        return $this->view($this->viewPath.'index', [
            'types' => $offices
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
            'name' => 'required',
            'sort' => 'required'
        ]);

        $office = Office::create([
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'lat' => $request->input('lat'),
            'lng' => $request->input('lng'),
            'sort' => $request->input('sort'),
            'status' => $request->has('status') ? 1 : 0,
        ]);

        if ($request->hasFile('image')) {

            $file = $request->file('image');

            $filePath = filePathGenerator(
                'office/',
                'off_',
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

            $office->syncFiles(['base_image' => [$image->id]]);
        }

        if ($office) {
            return redirect()->route('warehouse.offices.index')
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
        $office = Office::find($id);

        return $this->view($this->viewPath.'show', [
            'office' => $office
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(int $id): Renderable
    {
        $office = Office::find($id);

        return $this->view($this->viewPath.'edit', [
            'office' => $office
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
        $office = Office::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'sort' => 'required',
        ]);

        $update = $office->update([
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'lat' => $request->input('lat'),
            'lng' => $request->input('lng'),
            'sort' => $request->input('sort'),
            'status' => $request->has('status') ? 1 : 0,
        ]);

        if ($update) {

            if ($request->hasFile('image')) {

                $file = $request->file('image');

                $filePath = filePathGenerator(
                    'office/',
                    'off_',
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

                $office->syncFiles(['base_image' => [$image->id]]);
            }

            return redirect()->route('warehouse.offices.index')
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
        Office::findOrFail($id)->delete();

        return back()->with('message', 'Uğurla silindi')
            ->with('type', 'success');
    }
}

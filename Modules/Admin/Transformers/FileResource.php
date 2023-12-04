<?php

namespace Modules\Admin\Transformers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $path
 * @property mixed $filename
 * @property mixed $id
 * @property mixed $created_at
 */
class FileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request
     * @return array
     */
    public function toArray($request): array
    {

        $actions = '<div class="list-icons">
            <form action="'.route('filemanager.filemanager.destroy', [$this->id]).'" method="post">
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" class="list-icons-item m-0 p-0 border-0"><i class="icon-trash"></i></button>
            </form>
        </div>';

        return [
            'id' => $this->id,
            'path' => '<img src="/storage/public/media/'.$this->path.'" alt="thumbnail" style="width: 50px; height: 50px; object-fit: contain;">',
            'filename' => $this->filename,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'action' => $actions,
        ];
    }
}

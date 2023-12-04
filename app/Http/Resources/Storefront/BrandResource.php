<?php

namespace App\Http\Resources\Storefront;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $status
 * @property mixed $sort
 * @property mixed $title
 * @property mixed $files
 * @property mixed $created_at
 */
class BrandResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'sort' => $this->sort,
            'title' => $this->title,
            'files' => $this->files[0],
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
        ];
    }
}

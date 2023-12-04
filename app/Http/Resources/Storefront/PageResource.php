<?php

namespace App\Http\Resources\Storefront;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $sort
 * @property mixed $id
 * @property mixed $status
 * @property mixed $created_at
 * @property mixed $title
 * @property mixed $description
 */
class PageResource extends JsonResource
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
            'description' => $this->description,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
        ];
    }
}

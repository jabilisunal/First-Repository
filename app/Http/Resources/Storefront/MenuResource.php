<?php

namespace App\Http\Resources\Storefront;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $slug
 * @property mixed $title
 * @property mixed $items
 * @property mixed $url
 * @property mixed $translation
 * @property mixed $type
 * @property mixed $target_blank
 * @property mixed $is_new
 * @property mixed $style
 */
class MenuResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        $data = [
            'id' => $this->id,
            'href' => $this->translation->url,
            'name' => $this->title,
            'type' => $this->style,
            'targetBlank' => (bool) $this->target_blank,
            'isNew' =>  (bool) $this->is_new
        ];

        if ($this->items) {
            $data['children'] = self::collection($this->items);
        } else {
            $data['children'] = [];
        }

        return $data;
    }
}

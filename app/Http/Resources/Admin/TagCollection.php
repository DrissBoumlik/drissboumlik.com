<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TagCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
//        return TagResource::collection($this->resource);
        return $this->resource->map(function ($item, $key) {
            return (object) [
                "id" => $item->id,
                "name" => $item->name,
                "slug" => $item->slug,
                "description" => $item->description,
                "color" => $item->color,
                "created_at" => $item->created_at,
                'active' => $item->deleted_at == null,
                "posts_count" => $item->posts_count,
            ];
        });
    }
}

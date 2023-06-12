<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class TagResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return object
     */
    public function toArray($request)
    {
        return (object) [
            "id" => $this->id,
            "name" => $this->name,
            "slug" => $this->slug,
            "description" => $this->description,
            "color" => $this->color,
            "created_at" => $this->created_at,
            'active' => $this->deleted_at == null,
            "posts_count" => $this->posts_count,
        ];
    }
}

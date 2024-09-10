<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class TagResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return object|array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "slug" => $this->slug,
            "description" => $this->description,
            "color" => $this->color,
            "cover" => $this->cover,
            "created_at" => $this->created_at,
            'active' => $this->active,
            'deleted' => $this->deleted_at !== null,
            "posts_count" => $this->posts_count,
        ];
    }
}

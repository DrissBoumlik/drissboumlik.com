<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'author_id' => $this->author_id,
            'title' => $this->title,
            'short_title' => shortenTextIfLongByLength($this->title, 20),
            'slug' => $this->slug,
            'excerpt' => $this->excerpt,
            'content' => $this->content,
            'cover' => $this->cover,
            'description' => $this->description,
            'published' => $this->published,
            'featured' => $this->featured,
            'likes' => $this->likes,
            'views' => $this->views,
            'updated_at' => $this->updated_at,
            'published_at' => $this->published_at,
            'created_at' => $this->created_at,
            'tags' => $this->tags,
//            'author' => $this->author,
            'active' => $this->active,
            'deleted' => $this->deleted_at !== null,
        ];
    }
}

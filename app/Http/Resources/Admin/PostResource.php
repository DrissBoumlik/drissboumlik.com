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
        $coverSplitted = $this->cover ? explode('.webp', $this->cover) : null;
        return (object) [
            'id' => $this->id,
            'author_id' => $this->author_id,
            'title' => $this->title,
            'short_title' => shortenTextIfLongByLength($this->title, 20),
            'slug' => $this->slug,
            'excerpt' => $this->excerpt,
            'content' => $this->content,
            'cover' => $this->cover,
            'cover_compressed' => $this->cover ? "$coverSplitted[0]--compressed.webp" : $this->cover,
            'description' => $this->description,
            'status' => $this->getDomClass(),
            'featured' => $this->featured,
            'likes' => $this->likes,
            'views' => $this->views,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'published_at' => $this->published_at,
            'created_at' => $this->created_at,
            'tags' => $this->tags,
//            'author' => $this->author,
            'active' => $this->deleted_at == null,
        ];
    }
}

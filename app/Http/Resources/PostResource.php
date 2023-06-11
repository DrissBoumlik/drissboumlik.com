<?php

namespace App\Http\Resources;

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
            'author_id' => $this->author_id,
            'category_id' => $this->category_id,
            'title' => strlen($this->title) < 25 ? $this->title : \Str::words($this->title, 2),
            // Str::limit($this->body, Post::EXCERPT_LENGTH)
            'slug' => $this->slug,
            'excerpt' => $this->excerpt ?? \Str::words($this->content, 20),
            'content' => $this->content,
            'image' => $this->image,
            'description' => $this->description,
            'status' => $this->status,
            'featured' => $this->featured,
            'likes' => $this->likes,
            'views' => $this->views,
            'published_at' => $this->published_at->diffForHumans(),
            'tags' => $this->tags,
            'author' => $this->author,
        ];
    }
}

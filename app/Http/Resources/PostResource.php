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
        return (object) [
            'author_id' => $this->author_id,
            'author' => $this->author,
            'title' => $this->title,
            'short_title' => shortenTextIfLongByLength($this->title, 20),
            'slug' => $this->slug,
            'excerpt' => $this->excerpt ?? \Str::words($this->content, 20),
            'short_excerpt' => shortenTextIfLongByLength($this->excerpt ?? $this->content, 100),
            'content' => $this->content,
            'read_duration' => \Str::readDuration($this->content),
            'cover' => $this->cover,
            'description' => $this->description,
            'status' => $this->status,
            'featured' => $this->featured,
            'likes' => $this->likes,
            'views' => $this->views,
            'published_at' => $this->published_at,
            'published_at_formatted' => $this->published_at?->diffForHumans(),
            'tags' => $this->tags,
        ];
    }
}

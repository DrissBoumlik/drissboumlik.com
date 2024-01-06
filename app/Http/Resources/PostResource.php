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
        $coverSplitted = $this->cover ? explode('.webp', $this->cover) : null;
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
            'cover_compressed' => $this->cover ? "$coverSplitted[0]--compressed.webp" : $this->cover,
            'description' => $this->description,
            'published' => $this->published,
            'featured' => $this->featured,
            'likes' => $this->likes,
            'views' => $this->views,
            'updated_at' => $this->updated_at,
            'updated_at_formatted' => $this->updated_at?->diffForHumans(),
            'updated_at_short_format' => $this->updated_at?->format('F d, Y'),
            'published_at' => $this->published_at,
            'published_at_formatted' => $this->published_at?->diffForHumans(),
            'published_at_short_format' => $this->published_at?->format('F d, Y'),
            'tags' => $this->tags,
        ];
    }
}

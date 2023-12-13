<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PostCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->resource->map(function ($item, $key) {
            return (object) [
                'author_id' => $item->author_id,
                'title' => $item->title,
                'short_title' => shortenTextIfLongByLength($item->title, 20),
                'slug' => $item->slug,
                'excerpt' => $item->excerpt ?? \Str::words($item->content, 20),
                'short_excerpt' => shortenTextIfLongByLength($item->excerpt ?? $this->content, 100),
                'content' => $item->content,
                'cover' => $item->cover,
                'description' => $item->description,
                'status' => $item->status,
                'featured' => $item->featured,
                'likes' => $item->likes,
                'views' => $item->views,
                'published_at' => $item->published_at,
                'published_at_formatted' => $item->published_at?->diffForHumans(),
                'published_at_short_format' => $item->published_at?->format('F d, Y'),
                'tags' => $item->tags,
                'author' => $item->author,
                'read_duration' => \Str::readDuration($item->content),
            ];
        });
    }
}

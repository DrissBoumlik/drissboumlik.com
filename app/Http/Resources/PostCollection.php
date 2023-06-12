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
                'short_title' => strlen($item->title) < 25 ? $item->title : \Str::words($item->title, 2),
                // Str::limit($item->body, Post::EXCERPT_LENGTH)
                'slug' => $item->slug,
                'excerpt' => $item->excerpt ?? \Str::words($item->content, 20),
                'content' => $item->content,
                'image' => $item->image,
                'description' => $item->description,
                'status' => $item->status,
                'featured' => $item->featured,
                'likes' => $item->likes,
                'views' => $item->views,
                'published_at' => $item->published_at ? $item->published_at->diffForHumans() : '',
                'tags' => $item->tags,
                'author' => $item->author,
                'read_duration' => \Str::readDuration($item->content),
            ];
        });
    }
}

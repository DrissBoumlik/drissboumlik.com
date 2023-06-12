<?php

namespace App\Http\Resources\Admin;

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
//        return PostResource::collection($this->resource);
        return $this->resource->map(function ($item, $key) {
            return (object) [
                'id' => $item->id,
                'author_id' => $item->author_id,
                'title' => strlen($item->title) < 25 ? $item->title : \Str::words($item->title, 2), // Str::limit($item->body, Post::EXCERPT_LENGTH)
                'slug' => $item->slug,
                'excerpt' => $item->excerpt,
                'content' => $item->content,
//            'image' => $item->image,
                'description' => $item->description,
                'status' => $item->getDomClass(),
                'featured' => $item->featured,
                'likes' => $item->likes,
                'views' => $item->views,
                'published_at' => $item->published_at,
                'created_at' => $item->created_at,
                'tags' => $item->tags->pluck('name')->toArray(), // $item->tags,
//            'author' => $item->author,
                'active' => $item->deleted_at == null,
            ];
        });
    }
}

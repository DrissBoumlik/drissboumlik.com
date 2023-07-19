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
                'title' => $item->title,
                'short_title' => strlen($item->title) < 20 ? $item->title : \Str::limit($item->title, 20), // Str::limit($item->body, Post::EXCERPT_LENGTH)
                'slug' => $item->slug,
                'excerpt' => $item->excerpt,
                'content' => $item->content,
//            'image' => $item->image,
                'description' => $item->description,
                'status' => $item->getDomClass(),
                'featured' => $item->featured,
                'likes' => $item->likes,
                'views' => $item->views,
                'published_at' => $item->published_at ?? '',
                'published_at_for_humans' => $item->published_at?->diffForHumans() ?? '---',
                'created_at' => $item->created_at,
                'created_at_for_humans' => $item->created_at->diffForHumans(),
                'tags' => $item->tags->pluck('name')->toArray(), // $item->tags,
//            'author' => $item->author,
                'active' => $item->deleted_at == null,
            ];
        });
    }
}
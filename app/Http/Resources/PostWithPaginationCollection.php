<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PostWithPaginationCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return [
            'data' => PostResource::collection($this->resource),
            'perPage' => $this->resource->perPage(),
            'currentPage' => $this->resource->currentPage(),
            'path' => $this->resource->path(),
            // 'query' => $this->resource->query,
            'fragment' => $this->resource->fragment(),
            'pageName' => $this->resource->getPageName(),
            'onEachSide' => $this->resource->onEachSide,
            'options' => $this->resource->getOptions(),
            'total' => $this->resource->total(),
            'lastPage' => $this->resource->lastPage(),
        ];
    }
}

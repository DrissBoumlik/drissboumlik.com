<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SearchWithPaginationCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'items' => SearchResource::collection($this->resource)->resolve(),
            'perPage' => $this->resource->perPage(),
            'currentPage' => $this->resource->currentPage(),
            'path' => $this->resource->path(),
            'fragment' => $this->resource->fragment(),
            'pageName' => $this->resource->getPageName(),
            'onEachSide' => $this->resource->onEachSide,
            'options' => $this->resource->getOptions(),
            'total' => $this->resource->total(),
            'lastPage' => $this->resource->lastPage(),
        ];
    }
}

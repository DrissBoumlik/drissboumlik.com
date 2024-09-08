<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SearchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array|object
    {
        return (object) [
            'title' => $this->title,
            'short_title' => shortenTextIfLongByLength($this->title, 30),
            'link' => $this->link,
            'cover' => json_decode($this->cover),
            'type' => $this->type,
        ];
    }
}

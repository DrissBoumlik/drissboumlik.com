<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class VisitorResource extends JsonResource
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
            "id" => $this->id,
            "ip" => $this->ip,
            "visits_count" => $this->visits_count,
            "countryName" => $this->countryName,
            "countryCode" => $this->countryCode,
            "regionCode" => $this->regionCode,
            "regionName" => $this->regionName,
            "cityName" => $this->cityName,
            "zipCode" => $this->zipCode,
            "isoCode" => $this->isoCode,
            "postalCode" => $this->postalCode,
            "latitude" => $this->latitude,
            "longitude" => $this->longitude,
            "metroCode" => $this->metroCode,
            "areaCode" => $this->areaCode,
            "timezone" => $this->timezone,
            "driver" => $this->driver,
            "created_at" => $this->created_at,
            'created_at_formatted' => $this->created_at->format('Y-M-d h:m:s'),
            'created_at_for_humans' => $this->created_at->diffForHumans(),
            "updated_at" => $this->updated_at,
            "updated_at_formatted" => $this->updated_at->diffForHumans(),
        ];
    }
}

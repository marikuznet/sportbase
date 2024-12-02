<?php

namespace App\Http\Resources\Profile;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResourse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'city' => $this->city->title,
            'region' => $this->city->region->title,
            'country' => $this->city->region->country->title,
            'postIndex' => $this->postIndex,
            'address' => $this->address,
            'longtitude' => $this->longtitude,
            'latitude' => $this->latitude,
        ];
    }
}

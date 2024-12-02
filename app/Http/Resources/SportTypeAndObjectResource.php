<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SportTypeAndObjectResource extends JsonResource
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
            'sportObject_id' => $this->sportObject_id,
            'sportType_id' => $this->sportType->id,
            'sportType_title' => $this->sportType->title,
        ];
    }
}

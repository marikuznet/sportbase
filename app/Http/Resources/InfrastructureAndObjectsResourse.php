<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InfrastructureAndObjectsResourse extends JsonResource
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
            'infrastructure_id' => $this->id,
            'title' => $this->title,
            'image' => json_decode($this->image)->image,
            'options' => OptionResource::collection($this->when($this->options, new OptionResource($this->options))),
            'sportObject_id' => $this->pivot->sportObject_id,
        ];
    }
}

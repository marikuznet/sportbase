<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AccomodationConditionAndPricingAndObjectsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'accomodationType_id' => $this->accomodationType_id,
            'accomodationType_title' => $this->accomodationType->title,
            'pricing' => $this->when($this->price, json_decode($this->price)),
            'description' => $this->description ?? null,
          //  'pricing' => $this->when($this->typeAndPricing, new AccomodationTypeAndPricingResource($this->typeAndPricing)),
        ];
    }
}

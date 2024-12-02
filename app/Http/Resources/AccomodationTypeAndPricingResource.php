<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AccomodationTypeAndPricingResource extends JsonResource
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
            'idAccType' => $this->accomodationType->id,
            'accomodationType_title' => $this->accomodationType->title,
            'description' => $this->description,
            'price' => json_decode($this->price),
            'included' => $this->when($this->includedInAccomodationPricing, new IncludedInAccomodationPricingResource($this->includedInAccomodationPricing)),
        ];
    }
}

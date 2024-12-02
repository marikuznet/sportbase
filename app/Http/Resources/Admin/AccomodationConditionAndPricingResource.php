<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class AccomodationConditionAndPricingResource extends JsonResource
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
            'description' => $this->description,
            'includedInAccomodationPricing_id' => $this->includedInAccomodationPricing_id,
            'image' => $this->image,
            'accomodationTypeAndPricing_id' => $this->accomodationTypeAndPricing_id,
        ];
    }
}

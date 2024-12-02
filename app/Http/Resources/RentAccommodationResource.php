<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RentAccommodationResource extends JsonResource
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
            'checkAccm' => $this->checkAccm,
            'accommodations' => $this->accommodations,
            'daysAccm' => $this->daysAccm,
            'priceFood' => $this->priceFood,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'sumAccm' => $this->sumAccm,
            'sumPriceFood' => $this->sumPriceFood,
            'titlePriceFood' => $this->titlePriceFood,
            'typeFood' => $this->typeFood->title ?? null,
            'typeFood_id' => $this->typeFood->id ?? null,
        ];
    }
}

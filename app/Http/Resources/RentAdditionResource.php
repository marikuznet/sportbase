<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RentAdditionResource extends JsonResource
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
            'checkLaundry' => $this->checkLaundry,
            'washingVolume' => $this->washingVolume,
            'priceWashing' => $this->priceWashing,
            'sumLaundry' => $this->sumLaundry,
            'checkTransfer' => $this->checkTransfer,
            'durationTransfer' => $this->durationTransfer,
            'priceTransfer' => $this->priceTransfer,
            'sumTransfer' => $this->sumTransfer,
            'infrastructures' => json_decode($this->infrastructures),
            'totalPrice' => $this->totalPrice,
        ];
    }
}

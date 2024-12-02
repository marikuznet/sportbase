<?php

namespace App\Http\Resources\Deal;

use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationTenderResource extends JsonResource
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
            'minPrice' => $this->minPrice,
            'fullStartDate' => $this->startDate,
            'fullEndDate' => $this->endDate,
        ];
    }
}

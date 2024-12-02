<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminAdvertisementResource extends JsonResource
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
            'date_start' => $this->dateStart->translatedFormat('d F Y'),
            'date_end' => $this->date_end,
            'days' => $this->days,
            'status' => $this->statusAdvertisment->title,
            'amount' => $this->amount,
            'paused' => $this->paused,
            'paused_at' => $this->paused_at,
            'payment' => $this->paymentTransaction->status === 'succeeded',
            'rate' => $this->rateAdvertisment[0],
        ];
    }
}

<?php

namespace App\Http\Resources\AdvertisementAndTariffs;

use App\Http\Resources\SportObjectResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use NumberFormatter;

class AdvertisementResource extends JsonResource
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
            'date_start' => $this->paymentTransaction->payment_at->translatedFormat('d F Y / H:i'),
            'sport_object' => [
                'id' => $this->sportObject->id ?? null,
                'title' => $this->sportObject->title ?? null
            ],
           'tariff' => [
                'id' => $this->rateAdvertisment[0]->id,
                'title' => $this->rateAdvertisment[0]->title
            ],
            'currentAdvertisementTariff' => $this->currentAdvertisementTariff(),
            'days' => $this->days,
            'amount' => $this->amount,
            'priceAdvertisement' => number_format($this->currentAdvertisementTariff()['allPrice'], 0, ',', ','),
            'status' => $this->statusAdvertisment->title,
            //'transaction' => $this->paymentTransaction
        ];
    }

    public function currentAdvertisementTariff(){
        foreach ($this->rateAdvertisment[0]->price as $item)
            if ((int)$item['days'] == (int)$this->days) return $item;
    }
}

<?php

namespace App\Http\Resources\AdvertisementAndTariffs;

use Illuminate\Http\Resources\Json\JsonResource;

class RateAdvertismentResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price['data'],
            'minPrice' => $this->minPrice(),
        ];
    }

    public function minPrice(){
        $tmp = [];
        $result = 0;
        foreach ($this->price as $item){
            foreach((array)$item['days'] as $days) {
                $tmp[$days][] = $item['oneDay'];
            }
        }
        foreach($tmp as $prices) {
            $result = min($prices);
        }
        return $result;
    }
}

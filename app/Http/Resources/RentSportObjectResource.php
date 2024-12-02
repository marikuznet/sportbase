<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class RentSportObjectResource extends JsonResource
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
            'checkSport' => $this->checkSport,
            'price' => $this->price,
            'sum' => $this->sum,
            'start_date' => Carbon::parse($this->start_date),
            'end_date' => Carbon::parse($this->end_date),
            'time' => $this->time,
            'training' => $this->training,
            'trainingTime' => json_decode($this->trainingTime),
            'trainingTime_diff' => json_decode($this->trainingTime_diff),
        ];
    }
}

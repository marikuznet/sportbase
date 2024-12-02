<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\InfoCompanyResource;
use App\Http\Resources\Profile\PaymentDetailsResourse;
use App\Http\Resources\RentAccommodationResource;
use App\Http\Resources\RentAdditionResource;
use App\Http\Resources\RentSportObjectResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class EstimatesResource extends JsonResource
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
            'documents' => json_decode($this->documents),
            'status' => $this->status,
            'deal_id' => $this->deal_id,
            'customer_id' => $this->deal->tender ? $this->deal->tender->user->id : 'direct',
            'sportObject' => $this->when($this->sportObject, new SportObjectResource($this->sportObject)),
            'payment_at_customer' => $this->payment_at_customer,
            'replay_estimate' => $this->replay_estimate,
            'rentSportObject' => $this->when($this->rentSportObject, new RentSportObjectResource($this->rentSportObject)),
            'rentAccommodation' => $this->when($this->rentAccomodation, new RentAccommodationResource($this->rentAccomodation)),
            'rentAddition' => $this->when($this->rentAddition, new RentAdditionResource($this->rentAddition)),
            'sum' => $this->sum,
            'show_customer' => $this->show_customer,
            'date_send_customer' => $this->date_send_customer,
            'date_send' => Carbon::parse($this->date_send_customer)->translatedFormat('m.d.Y H:i'),
            'date_payment' => Carbon::parse($this->date_payment)->translatedFormat('m.d.Y H:i'),
            'deal_date_ago' => Carbon::parse($this->created_at)->translatedFormat('m.d.Y H:i'),
            'cut_date_est' => Carbon::parse($this->created_at)->translatedFormat('d.m.Y'),

            /*'status' => $this->status,
            'sportObject' => $this->when($this->sportObject, new SportObjectResource($this->sportObject)),
            'deal_id' => $this->deal_id,
            'payment_at_customer' => $this->payment_at_customer,
            'replay_estimate' => $this->replay_estimate,
            'rentSportObject' => $this->when($this->rentSportObject, new RentSportObjectResource($this->rentSportObject)),
            'rentAccommodation' => $this->when($this->rentAccomodation, new RentAccommodationResource($this->rentAccomodation)),
            'rentAddition' => $this->when($this->rentAddition, new RentAdditionResource($this->rentAddition)),
            'sum' => $this->sum,
            'show_customer' => $this->show_customer,
            'date_send_customer' => $this->date_send_customer,
            'documents' => json_decode($this->documents),
            'date_send' => Carbon::parse($this->date_send_customer)->translatedFormat('m.d.Y H:i'),
            'date_payment' => Carbon::parse($this->date_payment)->translatedFormat('m.d.Y H:i'),
            'deal_date_ago' => Carbon::parse($this->created_at)->translatedFormat('m.d.Y H:i'),*/
        ];
    }
}

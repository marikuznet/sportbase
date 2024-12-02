<?php

namespace App\Http\Resources;

use App\Http\Resources\Admin\DirectCustomerResource;
use App\Http\Resources\Admin\TenderCustomerResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class EstimateResource extends JsonResource
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
            'status' => $this->status,
            'sportObject' => $this->when($this->sportObject, new SportObjectResource($this->sportObject)),
            'deal_id' => $this->deal_id,
            'dealComplete' => $this->deal->complete,
            'customer_info' => $this->deal->tender ?
                $this->when($this->deal->tender, new TenderCustomerResource($this->deal->tender))
                : $this->when($this->deal->direct, new DirectCustomerResource($this->deal->direct)),
            'payment_at_customer' => $this->payment_at_customer,
            'replay_estimate' => $this->replay_estimate,
            'rentSportObject' => $this->when($this->rentSportObject, new RentSportObjectResource($this->rentSportObject)),
            'rentAccommodation' => $this->when($this->rentAccomodation, new RentAccommodationResource($this->rentAccomodation)),
            'rentAddition' => $this->when($this->rentAddition, new RentAdditionResource($this->rentAddition)),
            'sum' => $this->sum,
            'show_customer' => $this->show_customer,
            'date_send_customer' => $this->date_send_customer,
            'documents' => json_decode($this->documents),

            'date_payment' => $this->date_payment ? $this->date_payment->format('m.d.Y H:i') : null,
            'payment_confirm_date' => $this->payment_confirm_date,
            'confirm_date' => $this->payment_confirm_date ? Carbon::parse($this->payment_confirm_date)->translatedFormat('d M Y / H:i') : null,
            'payment_overdue_date' => $this->payment_overdue_date,

            'date_send' => $this->date_send_customer ? $this->date_send_customer->format('m.d.Y H:i') : null,
            'deal_date_ago' => $this->created_at ? $this->created_at->format('m.d.Y H:i') : null,

            'payment_at' => $this->date_payment ? Carbon::parse($this->date_payment)->translatedFormat('d M Y') : null,
            'created_at' => $this->created_at ? Carbon::parse($this->created_at)->translatedFormat('d M Y') : null,
            'created_at_full' => $this->created_at,

            'is_overdue' => $this->is_overdue
        ];
    }
}

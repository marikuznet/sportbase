<?php

namespace App\Http\Resources\Profile;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserEstimateResource extends JsonResource
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
            'deal_id' => $this->deal_id,
            'dealComplete' => $this->deal->complete,
            'payment_at_customer' => $this->payment_at_customer,
            'sum' => $this->sum,
            'show_customer' => $this->show_customer,
            'date_send_customer' => $this->date_send_customer,

            'date_payment' => $this->date_payment ? $this->date_payment->format('m.d.Y H:i') : null,
            'payment_confirm_date' => $this->payment_confirm_date,
            'confirm_date' => $this->payment_confirm_date ? Carbon::parse($this->payment_confirm_date)->translatedFormat('d M Y / H:i') : null,
            'payment_overdue_date' => $this->payment_overdue_date ?  Carbon::parse($this->payment_overdue_date) : null,

            'date_send' => $this->date_send_customer ? $this->date_send_customer->format('m.d.Y H:i') : null,

            'payment_at' => $this->date_payment ? Carbon::parse($this->date_payment)->translatedFormat('d M Y') : null,
            'created_at' => $this->created_at ? Carbon::parse($this->created_at)->translatedFormat('d M Y') : null,
            'created_at_full' => $this->created_at,

            'is_overdue' => $this->is_overdue
        ];
    }
}

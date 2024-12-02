<?php

namespace App\Http\Resources\Admin\Estimates;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentAdvertisementResource extends JsonResource
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
            'dateStart' => $this->paymentTransaction->payment_at ? $this->paymentTransaction->payment_at->translatedFormat('d F Y / H:i') : null,
            'end_date_payment' => $this->created_at ? $this->created_at->addMinutes(10)->translatedFormat('d F Y / H:i') : null,
            'end_date_payment_full' => $this->created_at ? $this->created_at->addMinutes(10) : null,

            'sportObject' => [
                'id' => $this->sportObject->id,
                'title' => $this->sportObject->title,
            ],
            'type_advertisement' => $this->rateAdvertisment[0]->title,
            'duration' => $this->days,
            'sum' => number_format($this->amount, 3, '.', ','),
            'status' => $this->status,
            'transaction_status' => $this->paymentTransaction->status ?? null,
        ];
    }
}

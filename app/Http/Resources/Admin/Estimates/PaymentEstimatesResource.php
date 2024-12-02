<?php

namespace App\Http\Resources\Admin\Estimates;

use App\Http\Resources\Admin\DirectCustomerResource;
use App\Http\Resources\Admin\SportObjectResource;
use App\Http\Resources\Admin\TenderCustomerResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentEstimatesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $sportObject = $this->when($this->sportObject, new SportObjectResource($this->sportObject));
        return [
            'id' => $this->id,
            'status' => $this->status,
            'documents' => json_decode($this->documents),
            'payment_doc' => $this->payment_doc,
            'order_number' => $this->order_number,
            'total_amount' => number_format($this->sum, 2, '.', ','),

            'deal_id' => $this->deal_id,
            'sportObject' => [
                'id' => $this->sportObject->id,
                'title' => $this->sportObject->title,
            ],
            'customer_info' => $this->deal->tender ? new TenderCustomerResource($this->deal->tender)
                : new DirectCustomerResource($this->deal->direct),
            'created_info' => [
                'id' => $sportObject->id,
                'title' => $sportObject->title
            ],
            'dates' => [
                'send_customer' => $this->date_send_customer ?? null,
                'payment' => Carbon::parse($this->date_payment)->translatedFormat('d.m.Y / H:i') ?? null,
                'payment_to_executor' => Carbon::parse($this->date_payment_to_executor)->translatedFormat('d.m.Y / H:i') ?? null,
                'confirmed' => Carbon::parse($this->payment_confirm_date)->translatedFormat('d.m.Y / H:i') ?? null,
            ],
        ];
    }
}

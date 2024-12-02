<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\RentAccommodationResource;
use App\Http\Resources\RentAdditionResource;
use App\Http\Resources\RentSportObjectResource;
use App\Http\Resources\Tender\TenderResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class BillsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $paymentOverdue = Carbon::parse($this->payment_overdue_date);
        $user_id = null;
        $title = null;
        $logo = null;
        $info = $this->sportObject->user->infoCompany ?? null;
        if (isset($info)) {
            $user_id = $info->user_id;
            $title = $info->typePerson === 0 ? $info->title : $info->name . ' ' . $info->surname;
            $logo = json_decode($info->image);
        }


        return [
            'id' => $this->id,
            'status' => $this->status,
            'sportObject' => [
                'id' => $this->sportObject->id,
                'title' => $this->sportObject->title,
                'created' => [
                    'user_id' => $user_id,
                    'title' => $title,
                    'image' => $logo,
                ],
            ],
            'deal_id' => $this->deal_id,
            'customer_info' => $this->deal->tender ?
                $this->when($this->deal->tender, new TenderCustomerResource($this->deal->tender))
                : $this->when($this->deal->direct, new DirectCustomerResource($this->deal->direct)),
            'sum' => $this->sum,
            'created_at' => Carbon::parse($this->created_at)->translatedFormat('d.m.Y H:i'),
            'payment_overdue' => $paymentOverdue->isBefore(Carbon::now()),
            'is_overdue' => $this->is_overdue
        ];
    }
}

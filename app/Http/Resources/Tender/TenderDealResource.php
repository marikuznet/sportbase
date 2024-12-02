<?php

namespace App\Http\Resources\Tender;

use App\Http\Resources\Admin\UsersResource;
use App\Http\Resources\InfoCompanyResource;
use App\Models\Tender\ResponsesTenderAndTenders;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TenderDealResource extends JsonResource
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
            'rejectionsDeal' => json_decode($this->rejectionsDeal),
            'status' => $this->status,
            'step' => $this->step,
            'complete' => $this->complete,
            'show_customer' => $this->show_customer,
            'deal_date' => Carbon::parse($this->created_at)->translatedFormat('d.m.Y H:i'),
            'deal_date_ago' => Carbon::parse($this->created_at)->translatedFormat('m.d.Y H:i'),
            'accept_by_customer' => $this->accept_by_customer,
            'accept_by_executor' => $this->accept_by_executor,
            'accept_customer_date' => $this->accept_customer_date,
            'accept_executor_date' => $this->accept_executor_date,
        ];
    }
}

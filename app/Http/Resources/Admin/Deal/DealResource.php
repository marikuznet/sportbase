<?php

namespace App\Http\Resources\Admin\Deal;

use App\Http\Resources\Admin\EstimatesResource;
use App\Http\Resources\Admin\SportObjectResource;
use App\Http\Resources\Deal\ReviewDealResource;
use App\Models\Estimate;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class DealResource extends JsonResource
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
            'tender' => $this->when($this->tender, new AdminTenderResource($this->tender)),
            'direct' => $this->when($this->direct, new AdminDirectResource($this->direct)),
            'responsesTender' => $this->when($this->responsesTender, new AdminResponseTenderResource($this->responsesTender)),

            'sportObject' => $this->tender ? $this->when($this->responsesTender->sportObject, new SportObjectResource($this->responsesTender->sportObject))
                : $this->when($this->direct->sportObject, new SportObjectResource($this->direct->sportObject)),

           /* 'customer_info' => $this->tender ? $this->when($this->responsesTender->sportObject, new SportObjectResource($this->responsesTender->sportObject))
                : $this->when($this->direct->sportObject, new SportObjectResource($this->direct->sportObject)),*/
            'review' => $this->when($this->review, new ReviewDealResource($this->review)) ?? null,
            'estimates' => EstimatesResource::collection(Estimate::all()->where('deal_id', '=', $this->id)),

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

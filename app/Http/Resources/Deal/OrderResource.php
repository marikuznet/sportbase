<?php

namespace App\Http\Resources\Deal;

use App\Http\Resources\Admin\EstimatesCollection;
use App\Http\Resources\Admin\EstimatesResource;
use App\Http\Resources\SportObjectResource;
use App\Http\Resources\Tender\DirectApplicationResource;
use App\Http\Resources\Tender\ResponsesTenderResourse;
use App\Http\Resources\Tender\TenderResource;
use App\Models\Deal\ReviewDeal;
use App\Models\Estimate;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $responseTender = $this->when($this->responsesTender, new OrderResponseTenderResource($this->responsesTender));
        return [
            'id' => $this->id,
            'rejectionsDeal' => json_decode($this->rejectionsDeal),
            'application' => (bool)$this->tender ? new ApplicationTenderResource($this->tender) : new ApplicationDirectResource($this->direct),
            'responses_tender' => $responseTender,
            'sport_objectId' => $this->tender ? $this->when($this->responsesTender->sportObject, $this->responsesTender->sportObject->id)
                : $this->when($this->direct->sportObject, $this->direct->sportObject->id),
            'sport_object' => $this->tender ? $this->when($this->responsesTender->sportObject, new SportObjectReviewsResource($this->responsesTender->sportObject))
                : $this->when($this->direct->sportObject, new SportObjectReviewsResource($this->direct->sportObject)),
            'tender' => (bool)$this->tender,
            'direct' => (bool)$this->direct,
            'estimates' => EstimatesResource::collection(Estimate::all()->where('deal_id', '=', $this->id)),

            'status' => $this->status,
            'step' => $this->step,
            'complete' => $this->complete,
            'accept_by_customer' => $this->accept_by_customer,
            'accept_by_executor' => $this->accept_by_executor,
            'accept_customer_date' => $this->accept_customer_date,
            'accept_executor_date' => $this->accept_executor_date,
        ];
    }
}
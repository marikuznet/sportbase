<?php

namespace App\Http\Resources\Deal;

use App\Http\Resources\Admin\EstimatesResource;
use App\Http\Resources\SportObjectResource;
use App\Http\Resources\Tender\DirectApplicationResource;
use App\Http\Resources\Tender\ResponsesTenderResourse;
use App\Http\Resources\Tender\TenderResource;
use App\Models\Deal\Deal;
use App\Models\Estimate;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $customer = $this->tender ? $this->tender->user->infoCompany : $this->direct->user->infoCompany;
        $executor = $this->tender ? $this->responsesTender->user->infoCompany : $this->direct->sportObject->user->infoCompany;

        return [
            'id' => $this->id,
            'sportObject' => $this->tender ? $this->when($this->responsesTender->sportObject, new SportObjectResource($this->responsesTender->sportObject))
                : $this->when($this->direct->sportObject, new SportObjectResource($this->direct->sportObject)),
            'review' => $this->when($this->review, new ReviewDealResource($this->review)),
            'rejectionsDeal' => json_decode($this->rejectionsDeal),
            'show_customer' => $this->show_customer,
            'deal_date_ago' => Carbon::parse($this->created_at)->translatedFormat('m.d.Y H:i'),
            'user_customer_info' => [
                'user_id' => $customer->user_id,
                'title' => $customer->typePerson == 1 ? $customer->name . ' ' . $customer->surname : $customer->title,
                'logo' => json_decode($customer->image),
            ],
            'user_executor_info' => [
                'user_id' => $executor->user_id,
                'title' => $executor->title,
                'logo' => json_decode($executor->image),
            ],
        ];
    }
}

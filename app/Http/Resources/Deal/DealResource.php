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
        $tender = $this->tender;
        if ($tender->user->infoCompany->phoneCompany != "[]") {
            $phoneCompany = json_decode($tender->user->infoCompany->phoneCompany)[0];
        } else $phoneCompany = "";

        $title_company = $tender->user->infoCompany->typePerson === 0 ? $tender->user->infoCompany->title :
            $tender->user->infoCompany->name . ' ' . $tender->user->infoCompany->surname;
        $phone_company = $tender->user->infoCompany->typePerson === 0 ? $phoneCompany :
            json_decode($tender->user->infoCompany->phone);
        $email_company = $tender->user->infoCompany->typePerson === 0 ? $tender->user->infoCompany->emailCompany :
            $tender->user->infoCompany->email;
        $image_company = json_decode($tender->user->infoCompany->image);

        return [
            'id' => $this->id,
            'tender' => $this->when($this->tender, new TenderResource($this->tender)),
            'customer_info' => $this->when($this->tender, [
                'user_id' => $this->tender->user->id,
                'title' => $title_company,
                'email' => $email_company,
                'phone' => $phone_company,
                'logo' => $image_company,
            ]),
            'direct' => $this->when($this->direct, new DirectApplicationResource($this->direct)),
            'responsesTender' => $this->when($this->responsesTender, new ResponsesTenderResourse($this->responsesTender)),
            'sportObject' => $this->tender ? $this->when($this->responsesTender->sportObject, new SportObjectResource($this->responsesTender->sportObject))
                : $this->when($this->direct->sportObject, new SportObjectResource($this->direct->sportObject)),
            'review' => $this->when($this->review, new ReviewDealResource($this->review)),
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
            'completed_at' => $this->completed_at,
            'confirmed_at' => $this->confirmed_at,
            'reason_canceled' => $this->reason_canceled
        ];
    }
}

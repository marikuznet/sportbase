<?php

namespace App\Http\Resources\Deal;

use App\Http\Resources\Admin\EstimatesResource;
use App\Http\Resources\SportObjectResource;
use App\Http\Resources\Tender\DirectApplicationResource;
use App\Models\Estimate;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class DealDirectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $direct = $this->direct;
        if ($direct->user->infoCompany->phoneCompany != "[]") {
            $phoneCompany = json_decode($direct->user->infoCompany->phoneCompany)[0];
        } else $phoneCompany = "";

        $title_company = $direct->user->infoCompany->typePerson === 0 ? $direct->user->infoCompany->title :
            $direct->user->infoCompany->name . ' ' . $direct->user->infoCompany->surname;
        $phone_company = $direct->user->infoCompany->typePerson === 0 ? $phoneCompany :
            json_decode($direct->user->infoCompany->phone);
        $email_company = $direct->user->infoCompany->typePerson === 0 ? $direct->user->infoCompany->emailCompany :
            $direct->user->infoCompany->email;
        $image_company = json_decode($direct->user->infoCompany->image);

        $executorInfo = $direct->sportObject->user->infoCompany;

        return [
            'id' => $this->id,
            'customer_info' => $this->when($this->direct, [
                'user_id' => $this->direct->user->id,
                'title' => $title_company,
                'email' => $email_company,
                'phone' => $phone_company,
                'logo' => $image_company,
            ]),
            'executor_info' => [
                'user_id' => $executorInfo->user_id,
                'title' => $executorInfo->title,
                'logo' => json_decode($executorInfo->image),
            ],
            'direct' => $this->when($this->direct, new DirectApplicationResource($this->direct)),
            'sportObject' => $this->when($this->direct->sportObject, new SportObjectResource($this->direct->sportObject)),
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
        ];
    }
}

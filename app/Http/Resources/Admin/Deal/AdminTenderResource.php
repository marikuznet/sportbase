<?php

namespace App\Http\Resources\Admin\Deal;

use App\Http\Resources\Admin\EstimatesCollection;
use App\Http\Resources\Admin\EstimatesResource;
use App\Http\Resources\Deal\ReviewDealResource;
use App\Http\Resources\SportObjectResource;
use App\Http\Resources\Tender\DirectApplicationResource;
use App\Http\Resources\Tender\ResponsesTenderResourse;
use App\Http\Resources\Tender\TenderResource;
use App\Models\Estimate;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminTenderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        if ($this->user->infoCompany) {
            if ($this->user->infoCompany->phoneCompany != "[]") {
                $phoneCompany = json_decode($this->user->infoCompany->phoneCompany)[0];
            } else $phoneCompany = "";
            $title_company = $this->user->infoCompany->typePerson === 0 ? $this->user->infoCompany->title :
                $this->user->infoCompany->name . ' ' . $this->user->infoCompany->surname;
            $phone_company = $this->user->infoCompany->typePerson === 0 ? $phoneCompany :
                json_decode($this->user->infoCompany->phone);
            $email_company = $this->user->infoCompany->typePerson === 0 ? $this->user->infoCompany->emailCompany :
                $this->user->infoCompany->email;
            $image_company = json_decode($this->user->infoCompany->image);
            $typePerson = $this->user->infoCompany->typePerson;
        } else {
            $title_company = null;
            $phone_company = null;
            $email_company = null;
            $typePerson = null;
            $image_company = null;
        }
        return [
            'id' => $this->id,
            'customer_info' => [
                'user_id' => $this->user_id,
                'title' => $title_company,
                'email' => $email_company,
                'phone' => $phone_company,
                'logo' => $image_company,
            ],
            'typePerson' => $typePerson,
            'type_sports' => $this->when($this->sports, $this->sports->map(function ($sport) {
                return [
                    'id' => $sport->id,
                    'title' => $sport->title,
                ];
            }), null),
            'typeFoods' => $this->when($this->foods, $this->foods->map(function ($food) {
                return [
                    'id' => $food->id,
                    'title' => $food->title,
                ];
            }), null),
            'additionsTender' => $this->additions->map(function ($addition) {
                return [
                    'id' => $addition->id,
                    'title' => $addition->title,
                ];
            }),
            'infrastructures' => $this->infrastructures ? $this->infrastructures->map(function ($infrastructure) {
                return [
                    'id' => $infrastructure->id,
                    'title' => $infrastructure->title,
                ];
            }) : null,
            'city' => $this->city->title ?? null,
            'country' => $this->city->region->country->title ?? null,
            'startDate' => Carbon::parse($this->startDate)->translatedFormat('d F'),
            'endDate' => Carbon::parse($this->endDate)->translatedFormat('d F'),
            'endDate_year' => Carbon::parse($this->endDate)->translatedFormat('Y'),
            'spreadDate' => $this->spreadDate,
            'minPrice' => $this->minPrice,
            'comment' => $this->comment,
            'colPeople' => $this->colPeople,

            'fullDate' => Carbon::parse($this->created_at)->format('d.m.y/H:i'),
        ];
    }
}

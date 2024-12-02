<?php

namespace App\Http\Resources\Tender;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TenderResource extends JsonResource
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
            $userCreated = $this->user->infoCompany->user_id;
        } else {
            $title_company = null;
            $phone_company = null;
            $email_company = null;
            $typePerson = null;
            $image_company = null;
            $userCreated = null;
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
            'region_id' => $this->city->region->id ?? null,
            'region' => $this->city->region->title ?? null,
            'country' => $this->city->region->country->title ?? null,
            'colPeople' => $this->colPeople,
            'fullStartDate' => Carbon::parse($this->startDate)->format('Y-m-d'),
            'startDate' => Carbon::parse($this->startDate)->translatedFormat('d F'),
            'startDate_day' => Carbon::parse($this->startDate)->translatedFormat('d'),
            'fullEndDate' => Carbon::parse($this->endDate)->format('Y-m-d'),
            'endDate' => Carbon::parse($this->endDate)->translatedFormat('d F'),
            'endDate_year' => Carbon::parse($this->endDate)->translatedFormat('Y'),
            'spreadDate' => $this->spreadDate,
            'cancelDate' => Carbon::parse($this->date_cancel)->translatedFormat('d.m.y/H:i'),
            'minPrice' => $this->minPrice,
            'priceForPerson' => $this->priceForPerson,
            'accred' => $this->accred,
            'fullDate' => Carbon::parse($this->created_at)->format('d.m.y/H:i'),
            'createDate' => Carbon::parse($this->created_at)->format('d.m.y'),
            'createDate_month' => Carbon::parse($this->created_at)->translatedFormat('d F'),
            'createDate_year' => Carbon::parse($this->created_at)->translatedFormat('Y'),
            'createDate_time' => Carbon::parse($this->created_at)->translatedFormat('H:i'),
            'comment' => $this->comment,
            'archive' => $this->archive,
            'responses' => ResponsesTenderResourse::collection($this->responses) ?? null,
            'allResponses_count' => $this->countResponses(),
            'myResponses_count' => $this->myResponses(),
            'deal' => $this->deal ? true : false,
            'dealData' => $this->when($this->deal, new TenderDealResource($this->deal)),
            'deal_id' => $this->when($this->deal, function () {
                return $this->deal['id'];
            })
        ];
    }

    public function countResponses()
    {
        return count($this->responses);
    }

    public function myResponses()
    {
        $count = 0;
        $responses = ResponsesTenderResourse::collection($this->responses) ?? null;
        if ($responses != null)
            foreach ($responses as $response)
                if ($response->user_id == Auth::id() && $response->archive == 0)
                    $count++;
        return $count;
    }
}

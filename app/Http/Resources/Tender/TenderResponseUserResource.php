<?php

namespace App\Http\Resources\Tender;

use App\Http\Resources\Admin\UsersResource;
use App\Http\Resources\InfoCompanyResource;
use App\Http\Resources\SportObjectResource;
use App\Models\Tender\ResponsesTenderAndTenders;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TenderResponseUserResource extends JsonResource
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
            $infoCompany = $this->user->infoCompany;
            $phoneCompany = $infoCompany->phoneCompany !== "[]" ? json_decode($infoCompany->phoneCompany)[0] : "";
            $title_company = $infoCompany->typePerson === 0 ? $infoCompany->title : $infoCompany->name . ' ' . $infoCompany->surname;
            $phone_company = $infoCompany->typePerson === 0 ? $phoneCompany : json_decode($infoCompany->phone);
            $email_company = $infoCompany->typePerson === 0 ? $infoCompany->emailCompany : $infoCompany->email;
            $image_company = json_decode($infoCompany->image);
            $typePerson = $infoCompany->typePerson;
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
            'region_id' => $this->city->region->id ?? null,
            'region' => $this->city->region->title ?? null,
            'country' => $this->city->region->country->title ?? null,

            'colPeople' => $this->colPeople,
            'stayDate' => Carbon::parse($this->startDate)->translatedFormat('d - d F Y'),
            'startDate' => Carbon::parse($this->startDate)->translatedFormat('d F'),
            'startDate_day' => Carbon::parse($this->startDate)->translatedFormat('d'),
            'endDate' => Carbon::parse($this->endDate)->translatedFormat('d F Y'),
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
            'deal' => $this->deal ? true : false,
            'deal_id' => $this->when($this->deal, function () {
                return $this->deal['id'];
            }),
            'responses' => ResponsesTenderResourse::collection($this->responses),
            'created_at' => $this->created_at
        ];
    }
}

<?php

namespace App\Http\Resources\Tender;

use App\Http\Resources\InfoCompanyResource;
use App\Http\Resources\SportObjectResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class DirectApplicationResource extends JsonResource
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
            $title_company = $this->user->infoCompany->typePerson === 0 ? $this->user->infoCompany->title :
                $this->user->infoCompany->name . ' ' . $this->user->infoCompany->surname;
                json_decode($this->user->infoCompany->phone);
            $image_company = json_decode($this->user->infoCompany->image);
        } else {
            $title_company = "";
            $image_company = null;
        }
        return [
            'id' => $this->id,
            'customer_info' => [
                'user_id' => $this->infoCompany->user_id,
                'title' => $title_company,
                'logo' => $image_company,
            ],
            'owner_info' => [
                'user_id' => $this->sportObject->user_id,
                'title' => $this->sportObject->user->infoCompany->title,
                'logo' => json_decode($this->sportObject->user->infoCompany->image),
            ],
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

            'company_info' => $this->when($this->infoCompany, new InfoCompanyResource($this->infoCompany)),
            'city_id' => $this->city_id,
            'city' => $this->city->title,
            'country' => $this->city->region->country->title,
            'colPeople' => $this->colPeople,
            'sportObject_id' => $this->sportObject_id,
            'sportObject' => $this->when($this->sportObject, new SportObjectResource($this->sportObject)),
            'sportObject_region' => $this->sportObject->city->region->title,
            'sportObject_country' => $this->sportObject->city->region->country->title,
            'sportObject_city' => $this->sportObject->city->title,
            'sportObject_type' => $this->sportObject->objectType->title,
            'sportType' => $this->sportObject->sportType->title,
            'sportObject_userId' => $this->sportObject->user_id,
            'startDate' => Carbon::parse($this->startDate)->translatedFormat('d F'),
            'startDate_day' => Carbon::parse($this->startDate)->translatedFormat('d'),
            'endDate' => Carbon::parse($this->endDate)->translatedFormat('d F Y'),
            'endDate_year' => null ?? '',
            'fullStartDate' => $this->startDate,
            'fullEndDate' => $this->endDate,
            'spreadDate' => $this->spreadDate,
            'cancelDate' => Carbon::parse($this->date_cancel)->translatedFormat('d.m.Y/H:i'),
            'minPrice' => $this->minPrice,
            'priceForPerson' => $this->priceForPerson,
            'fullDate' => Carbon::parse($this->created_at)->format('d.m.y/H:i'),
            'createDate' => Carbon::parse($this->created_at)->format('m.d.Y'),
            'createDate_full' => Carbon::parse($this->created_at)->translatedFormat('d F Y'),
            'createDate_month' => Carbon::parse($this->created_at)->translatedFormat('d F'),
            'createDate_year' => null ?? '',
            'createDate_time' => Carbon::parse($this->created_at)->translatedFormat('H:i'),
            'user_id' => $this->user,
            'comment' => $this->comment,
            'archive' => $this->archive,
            'isShow' => false,
            'deal' => $this->deal ? true : false,
            'deal_id' => $this->when($this->deal, function (){
                return $this->deal['id'];
            })
        ];
    }
}

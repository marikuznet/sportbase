<?php

namespace App\Http\Resources\Tender;

use App\Http\Resources\InfoCompanyResource;
use App\Http\Resources\SportObjectResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ResponsesTenderResourse extends JsonResource
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
            'company_info' => $this->when($this->infoCompany, new InfoCompanyResource($this->infoCompany)),
            'sportObject' => $this->when($this->sportObject, new SportObjectResource($this->sportObject)),
            'city' => $this->city->title,
            'city_id' => $this->city->id,
            'country' => $this->city->region->country->title,
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
            'colPeople' => $this->colPeople,
            'fullStartDate' => $this->startDate,
            'fullEndDate' => $this->endDate,
            'startDate' => Carbon::parse($this->startDate)->translatedFormat('d F'),
            'startDate_day' => Carbon::parse($this->startDate)->translatedFormat('d'),
            'endDate' => Carbon::parse($this->endDate)->translatedFormat('d F'),
            'endDate_year' => Carbon::parse($this->endDate)->translatedFormat('Y'),
            'spreadDate' => $this->spreadDate,
            'minPrice' => $this->minPrice,
            'priceForPerson' => $this->priceForPerson,
            'createDate' => Carbon::parse($this->created_at)->format('m.d.y') ,
            'createDate_month' => Carbon::parse($this->created_at)->translatedFormat('d F') ,
            'createDate_year' => Carbon::parse($this->created_at)->translatedFormat('Y') ,
            'createDate_time' => Carbon::parse($this->created_at)->translatedFormat('H:i') ,
            'user_id' => $this->user_id,
            'comment' => $this->comment,
            'archive' => $this->archive,
            'deal' => $this->deal ? true : false,
            'dealData' => $this->when($this->deal, new TenderDealResource($this->deal)),
            'fullDate' => Carbon::parse($this->created_at)->format('d.m.y/H:i'),
        ];
    }
}

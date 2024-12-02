<?php

namespace App\Http\Resources\Tender;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ResponsesAndTendersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */


    public function toArray($request)
    {
        $address = $this->responsesTender->infoCompany->address;
        if ($address)
            $full_address = $address->city->region->country->title . ', ' . $address->city->title . ', ' .
                $address->city->region->title . ', ' . $address->address;
        else $full_address = null;

        return [
            'id' => $this->id,
            'responsesTender' => $this->responsesTender,
            'responsesTender_userId' => $this->responsesTender->user_id,
            'tender' => $this->tender,
            'tender_id' => $this->tender->id,
            'tender_info_company' => $this->tender->infoCompany,

            'tender_type_sports' => json_decode($this->tender->type_sports),
            'tender_city_id' => $this->tender->city->id,
            'tender_country' => $this->tender->city->region->country->title,
            'tender_region' => $this->tender->city->region->title,
            'tender_city' => $this->tender->city->title,
            'tender_typeFoods' => json_decode($this->tender->typeFoods),
            'tender_additionsTender' => json_decode($this->tender->additionsTender),
            'tender_colPeople' => $this->tender->colPeople,
            'tender_infrastructures' => json_decode($this->tender->infrastructures),
            'tender_startDate' => Carbon::parse($this->tender->startDate)->translatedFormat('d F'),
            'tender_startDate_day' => Carbon::parse($this->tender->startDate)->translatedFormat('d'),
            'tender_endDate' => Carbon::parse($this->tender->endDate)->translatedFormat('d F'),
            'tender_endDate_year' => Carbon::parse($this->tender->endDate)->translatedFormat('Y'),
            'tender_spreadDate' => $this->tender->spreadDate,
            'tender_minPrice' => $this->tender->minPrice,
            'tender_priceForPerson' => $this->tender->priceForPerson,
            'tender_createDate' => Carbon::parse($this->tender->created_at)->format('m.d.y'),
            'tender_createDate_month' => Carbon::parse($this->tender->created_at)->translatedFormat('d F'),
            'tender_createDate_year' => Carbon::parse($this->tender->created_at)->translatedFormat('Y'),
            'tender_createDate_time' => Carbon::parse($this->tender->created_at)->translatedFormat('H:i'),
            'tender_comment' => $this->tender->comment,
            'tender_archive' => $this->tender->archive,


            'responsesTender_infoCompany' => $this->responsesTender->infoCompany,
            'responsesTender_titleCompany' => $this->responsesTender->infoCompany->title,
            'responsesTender_logoCompany' => json_decode($this->responsesTender->infoCompany->image),

            'responsesTender_address' => $full_address,

            'responsesTender_type_sports' => json_decode($this->responsesTender->type_sports),
            'responsesTender_city_id' => $this->tender->city_id,
            'responsesTender_country' => $this->tender->city->region->country->title,
            'responsesTender_city' => $this->tender->city->title,
            'responsesTender_typeFoods' => json_decode($this->responsesTender->typeFoods),
            'responsesTender_additionsTender' => json_decode($this->responsesTender->additionsTender),
            'responsesTender_colPeople' => $this->responsesTender->colPeople,
            'responsesTender_accred' => $this->responsesTender->accred,
            'responsesTender_infrastructures' => json_decode($this->responsesTender->infrastructures),
            'responsesTender_fullStartDate' => $this->responsesTender->startDate,
            'responsesTender_fullEndDate' => $this->responsesTender->endDate,
            'responsesTender_startDate' => Carbon::parse($this->responsesTender->startDate)->translatedFormat('d F'),
            'responsesTender_startDate_day' => Carbon::parse($this->responsesTender->startDate)->translatedFormat('d'),
            'responsesTender_endDate' => Carbon::parse($this->responsesTender->endDate)->translatedFormat('d F'),
            'responsesTender_endDate_year' => Carbon::parse($this->responsesTender->endDate)->translatedFormat('Y'),
            'responsesTender_spreadDate' => $this->responsesTender->spreadDate,
            'responsesTender_dateResponse' => $this->responsesTender->dateResponse,
            'responsesTender_minPrice' => $this->responsesTender->minPrice,
            'responsesTender_priceForPerson' => $this->responsesTender->priceForPerson,
            'responsesTender_date' => Carbon::parse($this->responsesTender->created_at)->format('d.m.y/H:i'),
            'responsesTender_createDate' => Carbon::parse($this->responsesTender->created_at)->format('d.m.y'),
            'responsesTender_createDate_month' => Carbon::parse($this->responsesTender->created_at)->translatedFormat('d F'),
            'responsesTender_createDate_year' => Carbon::parse($this->responsesTender->created_at)->translatedFormat('Y'),
            'responsesTender_createDate_time' => Carbon::parse($this->responsesTender->created_at)->translatedFormat('H:i'),
            'responsesTender_comment' => $this->responsesTender->comment,
            'responsesTender_archive' => $this->responsesTender->archive,
        ];
    }
}

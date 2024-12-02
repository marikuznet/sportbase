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

class AdminDirectResource extends JsonResource
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

            'city' => $this->city->title ?? null,
            'country' => $this->city->region->country->title ?? null,
            'startDate' => Carbon::parse($this->startDate)->translatedFormat('d F'),
            'startDate_day' => Carbon::parse($this->startDate_day)->translatedFormat('d F'),
            'endDate' => Carbon::parse($this->endDate)->translatedFormat('d F'),
            'endDate_year' => Carbon::parse($this->endDate)->translatedFormat('Y'),
            'spreadDate' => $this->spreadDate,
            'minPrice' => $this->minPrice,
            'priceForPerson' => $this->priceForPerson,
            'comment' => $this->comment,
            'colPeople' => $this->colPeople,

            'fullDate' => Carbon::parse($this->created_at)->format('d.m.y/H:i'),
        ];
    }
}

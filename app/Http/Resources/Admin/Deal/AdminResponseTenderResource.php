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

class AdminResponseTenderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $title = null;
        $user_id = null;
        $logo = null;
        $info = $this->user->infoCompany ?? null;
        if (isset($info)) {
            $user_id = $info->user_id;
            $title = $info->typePerson === 0 ? $info->title : $info->name . ' ' . $info->surname;
            $logo = json_decode($info->image);
        }

        return [
            'company_info' => $this->when($this->infoCompany, [
                'title' => $this->infoCompany->title,
                'logo' => json_decode($this->infoCompany->image),
                'user_id' => $this->infoCompany->user_id
            ]),
            'sportObject' => $this->when($this->user, [
                'created' => [
                    'user_id' => $user_id,
                    'title' => $title,
                    'image' => $logo,
                ],
            ]),

            'id' => $this->id,
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

            'city' => $this->city->title,
            'country' => $this->city->region->country->title,
            'colPeople' => $this->colPeople,
            'startDate' => Carbon::parse($this->startDate)->translatedFormat('d F'),
            'endDate' => Carbon::parse($this->endDate)->translatedFormat('d F'),
            'endDate_year' => Carbon::parse($this->endDate)->translatedFormat('Y'),
            'spreadDate' => $this->spreadDate,
            'minPrice' => $this->minPrice,
            'comment' => $this->comment,

            'fullDate' => Carbon::parse($this->created_at)->format('d.m.y/H:i'),
        ];
    }
}

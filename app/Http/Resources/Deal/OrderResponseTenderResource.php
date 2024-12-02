<?php

namespace App\Http\Resources\Deal;

use App\Http\Resources\Admin\EstimatesCollection;
use App\Http\Resources\Admin\EstimatesResource;
use App\Http\Resources\InfoCompanyResource;
use App\Http\Resources\SportObjectResource;
use App\Http\Resources\Tender\DirectApplicationResource;
use App\Http\Resources\Tender\ResponsesTenderResourse;
use App\Http\Resources\Tender\TenderResource;
use App\Models\Deal\ReviewDeal;
use App\Models\Estimate;
use App\Models\SportObject;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResponseTenderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $sport_object = $this->when($this->sportObject, new SportObjectResource($this->sportObject));
        $company_info = $this->when($this->infoCompany, new InfoCompanyResource($this->infoCompany));
        return [
            'id' => $this->id,
            'company_info' => [
                'user_id' => $this->user_id,
                'image' => json_decode($company_info->image),
                'full_name' => $company_info->typePerson === 1 ? $company_info->surname . ' ' . $company_info->surname->name
                    : $company_info->title,
                'type_person' => $company_info->typePerson,
                'surname' => $company_info->surname,
                'name' => $company_info->name,
                'title' => $company_info->title,
            ],
            'sport_object' => [
                'id' => $sport_object->id,
                'title' => $sport_object->title,
                'country' => $sport_object->country,
                'city' => $sport_object->city->title,
                'address' => $sport_object->address,
                'minPrice' => $this->minPrice(),
                'average_rating' => $sport_object->average_rating,
                'reviews_count' => $sport_object->reviews_count,
            ],
            'createDate_month' => Carbon::parse($this->created_at)->translatedFormat('d F'),
            'createDate_year' => Carbon::parse($this->created_at)->translatedFormat('Y'),
            'createDate_time' => Carbon::parse($this->created_at)->translatedFormat('H:i'),
        ];
    }

    public function minPrice()
    {
        $array = [];
        $minPrices = [];
        foreach (SportObject::query()->find($this->sportObject->id)->pricing as $pricing) {
            array_push($array, $pricing['price']);
        }

        foreach ($array as $item) {
            $price = json_decode($item)[Carbon::now()->month - 1];
            array_push($minPrices, (int)$price->minPrice);
        }
        if (count($minPrices) > 0) {
            return min($minPrices);
        } else return 0;
    }
}

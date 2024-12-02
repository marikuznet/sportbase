<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\AccomodationConditionAndPricingAndObjectsResource;
use App\Http\Resources\InfrastructureAndObjectsResourse;
use App\Http\Resources\ServiceAndObjectResource;
use App\Http\Resources\SportTypeAndObjectResource;
use App\Models\SportObject;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SportObjectAddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'city' => $this->city->title,
            'country' => $this->city->region->country->title,
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longtitude' => $this->longtitude,
            'title' => $this->title,
            'image' => json_decode($this->image)[0],
            'average_rating' => round($this->reviewsAverageRating(), 2),
            'minPrice' => $this->minPrice(),
        ];
    }

    public function reviewsAverageRating()
    {
        return $this->directApplications->flatMap->deals->flatMap->reviews->merge($this->responsesTender->flatMap->deals->flatMap->reviews)->avg(function ($review) {
            if ($review->status !== 1) return;
            return ($review->infrastructure + $review->sport_object + $review->food + $review->territory + $review->place + $review->price) / 6;
        });
    }

    private function minPrice()
    {
        $array = [];
        $minPrices = [];
        foreach (SportObject::query()->find($this->id)->pricing as $pricing) {
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

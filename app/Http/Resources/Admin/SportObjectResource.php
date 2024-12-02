<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\AccomodationConditionAndPricingAndObjectsResource;
use App\Http\Resources\AdvertisementResource;
use App\Http\Resources\InfrastructureAndObjectsResourse;
use App\Http\Resources\ServiceAndObjectResource;
use App\Http\Resources\SportTypeAndObjectResource;
use App\Models\SportObject;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SportObjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        $user_id = null;
        $title = null;
        $logo = null;
        $info = $this->user->infoCompany ?? null;
        if (isset($info)) {
            $user_id = $info->user_id;
            $title = $info->typePerson === 0 ? $info->title : $info->name . ' ' . $info->surname;
            $logo = json_decode($info->image);
        }
        return [
            'id' => $this->id,
            'advertisements' => AdvertisementResource::collection(
                $this->when($this->advertisements, function () {
                    $now = Carbon::now();
                    return $this->advertisements->filter(function ($advertisement) use ($now) {
                        $paymentTransaction = $advertisement->paymentTransaction;
                        if ($paymentTransaction && $paymentTransaction->status) {
                            return $paymentTransaction->status == 'succeeded' && (!$advertisement->date_end || $advertisement->date_end >= $now);
                        } else {
                            return false;
                        }
                    });
                })
            ),
            'finished_advertisements' => AdvertisementResource::collection(
                $this->when($this->advertisements, function () {
                    $now = Carbon::now();
                    return $this->advertisements->filter(function ($advertisement) use ($now) {
                        return $advertisement->date_end && $advertisement->date_end < $now;
                    });
                })
            ),
            'review' => $this->review,
            'created' => [
                'user_id' => $user_id,
                'title' => $title,
                'image' => $logo,
            ],
            'title' => $this->title,
            'objectType_title' => $this->objectType->title,
            'image' => json_decode($this->image),
            'images' => json_decode($this->image),
            'description' => $this->description,
            'sportType_title' => $this->sportType->title,
            'sports' => $this->when($this->sports, $this->sports->map(function ($sport) {
                return [
                    'id' => $sport->id,
                    'title' => $sport->title,
                ];
            })),
            'services' => $this->when($this->services, $this->services->map(function ($service) {
                return [
                    'id' => $service->id,
                    'title' => $service->title,
                ];
            })),
            'infrastructures' => InfrastructureAndObjectsResourse::collection($this->when($this->infrastructures, new InfrastructureAndObjectsResourse($this->infrastructures))),
            'accommodations' => AccomodationConditionAndPricingAndObjectsResource::collection($this->when($this->pricing, new AccomodationConditionAndPricingAndObjectsResource($this->pricing))),
            'accm_minPrice' => $this->minPrice(),
            'termsAndPrices' => $this->accomodationConditionAndPricing->description,
            'accomodationConditionAndPricing_included' => json_decode($this->accomodationConditionAndPricing
                    ->includedInAccomodationPricing->title ?? null),
            'accomodationConditionAndPricing_included_id' => json_decode($this->accomodationConditionAndPricing
                    ->includedInAccomodationPricing->id ?? null),
            'sportType_id' => $this->sportType_id,
            'accomodationConditionAndPricing_id' => $this->accomodationConditionAndPricing_id,
            'infrastructure_id' => $this->infrastructure_id,
            'city_id' => $this->city_id,
            'city' => $this->city->title,
            'region' => $this->city->region->title,
            'country' => $this->city->region->country->title,
            'address' => $this->address,
            'postIndex' => $this->postIndex,
            'longtitude' => $this->longtitude,
            'latitude' => $this->latitude,
            'rating' => $this->rating,
            'feedback_id' => $this->feedback_id,
            'user_id' => $this->user_id,
            'hasPromotion' => $this->getHasRate(2),
            'hasHighlightion' => $this->getHasRate(1),
            'hasVIP' => $this->getHasRate(3),
            'visible' => $this->visible,
            'verify' => $this->verify,
            'owner_id' => $this->user->id
        ];
    }

    private function getHasRate($typeRate)
    {
        $hasRate = $this->when($this->advertisements, function () use ($typeRate) {
            $now = Carbon::now();
            return $this->advertisements->contains(function ($advertisement) use ($now, $typeRate) {
                $paymentTransaction = $advertisement->paymentTransaction;
                $rateAdvertisement = $advertisement->rateAdvertisment->first()->id;


                return $rateAdvertisement == $typeRate && $paymentTransaction && $paymentTransaction->status == 'succeeded' && (!$advertisement->date_end || $advertisement->date_end >= $now);
            });
        });

        return $hasRate ? 1 : 0;
    }

    public function minPrice()
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

<?php

namespace App\Http\Resources;

use App\Http\Resources\Admin\UsersResource;
use App\Http\Resources\CityResource;
use App\Models\AccomodationTypeAndPricingAndObject;
use App\Models\City;
use App\Models\DirectApplications;
use App\Models\SportObject;
use Carbon\Carbon;
use Faker\Core\Number;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class SportObjectResource extends JsonResource
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
            'id' => $this->id,
            'user_id' => $this->user_id,
            'created' => [
                'user_id' => $user_id,
                'title' => $title,
                'image' => $logo,
            ],
            'title' => $this->title,
            'objectType_title' => $this->objectType->title,
            'objectType_id' => $this->objectType->id,
            'image' => json_decode($this->image),
            'images' => json_decode($this->image),
            'description' => $this->description,
            'sportType_title' => $this->sportType->title,
            'sports' => $this->sports->map(function ($sport) {
                return [
                    'id' => $sport->id,
                    'title' => $sport->title,
                ];
            }),
            'services' => $this->services->map(function ($service) {
                return [
                    'id' => $service->id,
                    'title' => $service->title,
                ];
            }),
            'infrastructures' => InfrastructureAndObjectsResourse::collection($this->when($this->infrastructures, new InfrastructureAndObjectsResourse($this->infrastructures))),
            'accommodations' => AccomodationConditionAndPricingResource::collection($this->when($this->pricing,
                new AccomodationConditionAndPricingResource($this->pricing))),
            'accm_minPrice' => $this->minPrice(),
            'termsAndPrices' => $this->accomodationConditionAndPricing->description,
            'accomodationConditionAndPricing_id' => json_decode($this->accomodationConditionAndPricing->id ?? null),
            'accomodationConditionAndPricing_included' => json_decode($this->accomodationConditionAndPricing
                    ->includedInAccomodationPricing->title ?? null),
            'accomodationConditionAndPricing_included_id' => json_decode($this->accomodationConditionAndPricing
                    ->includedInAccomodationPricing->id ?? null),
            'pricing' => $this->accomodationConditionAndPricing,
            'city_id' => $this->city->id,
            'city' => $this->city->title,
            'region' => $this->city->region->title,
            'country' => $this->city->region->country->title,
            'address' => $this->address,
            'postIndex' => $this->postIndex,
            'longtitude' => $this->longtitude,
            'latitude' => $this->latitude,
            'reviews' => $this->directApplications->flatMap->deals->flatMap->reviews->merge($this->responsesTender->flatMap->deals->flatMap->reviews),
            'reviews_count' => $this->getReviewsCount(),
            'average_rating' => round($this->reviewsAverageRating(), 2),
            'hasPromotion' => $this->getHasRate(2),
            'hasHighlightion' => $this->getHasRate(1),
            'hasVIP' => $this->getHasRate(3),//$this->hasVIP,
            'visible' => $this->visible,
            'verify' => $this->verify,

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
            'has_active_request' => $this->directApplications()->when(Auth::check(), function ($query) {
                return $query->where('user_id', Auth::id())
                    ->whereNotIn('archive', [
                        DirectApplications::STATUS_COMPLETE,
                        DirectApplications::STATUS_REJECTED_EXECUTOR,
                        DirectApplications::STATUS_REJECTED_CUSTOMER
                    ]);
            })->count() > 0,
        ];
    }

    private function getHasRate($typeRate)
    {
        $hasRate = $this->when($this->advertisements, function () use ($typeRate) {
            $now = Carbon::now();
            return $this->advertisements->contains(function ($advertisement) use ($now, $typeRate) {
                $paymentTransaction = $advertisement->paymentTransaction;
                $rateAdvertisement = $advertisement->rateAdvertisment->first()->id;

                return $rateAdvertisement == $typeRate && $paymentTransaction && $paymentTransaction->status == 'succeeded'
                    && (!$advertisement->date_end || $advertisement->date_end >= $now && $advertisement->paused == 0);
            });
        });

        return $hasRate ? 1 : 0;
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

    public function reviewsAverageRating()
    {
        return $this->directApplications->flatMap->deals->flatMap->reviews->merge($this->responsesTender->flatMap->deals->flatMap->reviews)->avg(function ($review) {
            if ($review->status !== 1) return;
            return ($review->infrastructure + $review->sport_object + $review->food + $review->territory + $review->place + $review->price) / 6;
        });
    }

    public function getReviewsCount()
    {
        return $this->directApplications
            ->flatMap->deals
            ->flatMap->reviews
            ->merge($this->responsesTender->flatMap->deals->flatMap->reviews)
            ->filter(function ($review) {
                return $review->status === 1;
            })->count();
    }
}

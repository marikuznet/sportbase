<?php

namespace App\Http\Resources\Admin;

use \App\Http\Resources\Admin\AdminAdvertisementResource;
use App\Http\Resources\AdvertisementResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomSportObjectResource extends JsonResource
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
            'review' => $this->review,
            'created' => [
                'user_id' => $user_id,
                'title' => $title,
                'image' => $logo,
            ],
            'title' => $this->title,
            'objectType_title' => $this->objectType->title,
            'image' => json_decode($this->image),
            'city' => $this->city->title,
            'address' => $this->address,
            'visible' => $this->visible,
            'verify' => $this->verify,
            'owner_id' => $this->user->id,
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
        ];
    }
}

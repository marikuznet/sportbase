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

class AdminSportObjectResource extends JsonResource
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
            'reviews_count' => $this->getReviewsCount(),
            'average_rating' => round($this->reviewsAverageRating(), 2),
        ];
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

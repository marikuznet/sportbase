<?php

namespace App\Http\Resources\Deal;

use App\Http\Resources\SportObjectResource;
use App\Http\Resources\Tender\DirectApplicationResource;
use App\Http\Resources\Tender\ResponsesTenderResourse;
use App\Http\Resources\Tender\TenderResource;
use App\Models\Deal\Deal;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class SportObjectReviewsResource extends JsonResource
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

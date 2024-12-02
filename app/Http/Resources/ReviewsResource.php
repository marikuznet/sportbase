<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewsResource extends JsonResource
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
            'sportObject_id' => $this->deal->direct ? $this->deal->direct->sportObject->id
                : $this->deal->responsesTender->sportObject->id,
            'infrastructure' => $this->infrastructure,
            'sport_object' => $this->sport_object,
            'food' => $this->food,
            'territory' => $this->territory,
            'place' => $this->place,
            'price' => $this->price,
            'average' => $this->getRating(),
            'text' => $this->text,
            'status' => $this->status ?? null,
            'user_id_executor' => $this->deal->direct ? $this->deal->direct->user_id : $this->deal->responsesTender->user_id,
            'user_customer_info' => [
                'user_id' => $this->user->infoCompany->user_id,
                'title' => $this->user->infoCompany->typePerson == 1 ? $this->user->infoCompany->name . ' ' .
                    $this->user->infoCompany->surname : $this->user->infoCompany->title,
                'logo' => json_decode($this->user->infoCompany->image),
            ],
            'user_executor_info' => [
                'user_id' => $this->deal->direct
                    ? $this->deal->direct->user->infoCompany->user_id
                    : $this->deal->responsesTender->user->infoCompany->user_id,
                'title' => $this->deal->direct
                    ? $this->deal->direct->user->infoCompany->title
                    : $this->deal->responsesTender->user->infoCompany->title,
                'logo' => $this->deal->direct
                    ? json_decode($this->deal->direct->user->infoCompany->image)
                    : json_decode($this->deal->responsesTender->user->infoCompany->image),
            ],
            'created_at' => Carbon::parse($this->created_at)->translatedFormat('d.m.y'),
        ];
    }

    protected function getRating()
    {
        return round(($this->infrastructure + $this->sport_object + $this->food + $this->territory + $this->place + $this->price) / 6, 2);
    }
}

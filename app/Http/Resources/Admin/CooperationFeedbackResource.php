<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\Deal\DealResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CooperationFeedbackResource extends JsonResource
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
            'deal' => $this->when($this->deal, $this->deal),
            'sportObject' => $this->deal->direct ?
                $this->when($this->deal->direct->sportObject, new \App\Http\Resources\SportObjectResource($this->deal->direct->sportObject))
                : $this->when($this->deal->responsesTender->sportObject, new \App\Http\Resources\SportObjectResource($this->deal->responsesTender->sportObject)),
            'infrastructure' => $this->infrastructure,
            'sport_object' => $this->sport_object,
            'food' => $this->food,
            'territory' => $this->territory,
            'place' => $this->place,
            'price' => $this->price,
            'average' => $this->getRating(),
            'text' => $this->text,
            'status' => $this->status,
            'reasonDeleted' => $this->reasonDeleted ?? null,
            'user_customer_info' => [
                'user_id' => $this->user->infoCompany->user_id,
                'title' => $this->user->infoCompany->typePerson == 1 ? $this->user->infoCompany->name . ' ' .
                    $this->user->infoCompany->surname : $this->user->infoCompany->title,
                'logo' => json_decode($this->user->infoCompany->image),
            ]
        ];
    }

    protected function getRating()
    {
        return round(($this->infrastructure + $this->sport_object + $this->food + $this->territory + $this->place + $this->price) / 6, 2);
    }
}

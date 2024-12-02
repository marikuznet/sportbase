<?php

namespace App\Http\Resources\Profile;

use Illuminate\Http\Resources\Json\JsonResource;

class SendNotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'eventNotification' => $this->eventNotification,
            'eventNotification_id' => $this->eventNotification->id,
            'user_id' => $this->user_id,
        ];
    }
}

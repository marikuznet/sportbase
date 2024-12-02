<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class MessagesArbitrResource extends JsonResource
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
            'deal_id' => $this->deal_id,
            'user_id' => $this->user_id,
            'user_role' => $this->user->role,
            'user_title' => $this->user->infoCompany->title ?? "",
            'user_logo' => $this->user->infoCompany->image ?? null,
            'message' => $this->message,
        ];
    }
}

<?php

namespace App\Http\Resources;

use App\Http\Resources\Profile\UserResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
            'from' => $this->when($this->user_from, new UserResource($this->user_from)),
           // 'to' => $this->when($this->user_to, new UserResource($this->user_to)),
            'read' => $this->read,
            'text' => $this->text,
            'images' => $this->images,
            'time' => Carbon::parse($this->created_at)->format("H:i"),
            'date' => Carbon::parse($this->created_at)->format("d.m.Y"),
        ];
    }
}

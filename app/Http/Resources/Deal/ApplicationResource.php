<?php

namespace App\Http\Resources\Deal;

use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $responseTender = $this->when($this->responsesTender, new OrderResponseTenderResource($this->responsesTender));
        return [
            'id' => $this->id,

        ];
    }
}

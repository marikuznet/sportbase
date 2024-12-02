<?php

namespace App\Http\Resources\Profile;

use Illuminate\Http\Resources\Json\JsonResource;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;

class PaymentDetailsResourse extends JsonResource
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
            'user_id' => $this->user_id,
            'legal_name' => $this->legal_name,
            'title' => $this->title,
            'tin' => $this->tin,
            'numKpp' => $this->numKpp,
            'bic' => $this->bic,
            'requisites' => $this->requisites,
            'kc' => $this->kc,
            'okpo' => $this->okpo,
            'okato' => $this->okato,
            'orgn' => $this->orgn,
            'address_id' => $this->address_id,
            'address' => $this->when($this->address, new AddressResourse($this->address)),
        ];
    }
}

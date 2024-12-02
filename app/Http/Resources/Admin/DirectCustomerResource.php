<?php

namespace App\Http\Resources\Admin;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class DirectCustomerResource extends JsonResource
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
            'id' => $this->infoCompany->user_id,
            'title' => $this->infoCompany->typePerson === 0 ? $this->infoCompany->title :
                $this->infoCompany->name . ' ' . $this->infoCompany->surname,
        ];
    }
}

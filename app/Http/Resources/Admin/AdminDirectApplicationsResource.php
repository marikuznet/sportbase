<?php

namespace App\Http\Resources\Admin;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminDirectApplicationsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        if ($this->user->infoCompany) {
            $title_company = $this->user->infoCompany->typePerson === 0 ? $this->user->infoCompany->title :
                $this->user->infoCompany->name . ' ' . $this->user->infoCompany->surname;
            json_decode($this->user->infoCompany->phone);
        } else {
            $title_company = "";
        }
        return [
            'id' => $this->id,
            'dateCreate' => Carbon::parse($this->created_at)->translatedFormat('d F Y / H:i'),
            'dateObservation' => Carbon::parse($this->startDate)->translatedFormat('d') . ' - '
                . Carbon::parse($this->endDate)->translatedFormat('d F Y') . ' ' . $this->spreadDate,
            'sportObject_type' => $this->sportObject->objectType->title,
            'sportObject' => [
                'id' => $this->sportObject->id,
                'title' => $this->sportObject->title,
                'created' => [
                    'id' => $this->sportObject->user_id,
                    'title' => $this->sportObject->user->infoCompany->title,
                ]
            ],
            'customer_info' => [
                'id' => $this->user_id,
                'title' => $title_company,
            ],
            'sportObject_created' => $this->sportObject->user->infoCompany->title,
            'archive' => $this->archive,
            'hasDeal' => (bool)$this->deal,
            'dealId' => $this->deal->id ?? null,
        ];
    }
}

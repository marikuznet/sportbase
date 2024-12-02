<?php

namespace App\Http\Resources\Admin;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminTenderApplicationsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $title_company = null;
        if ($this->user) {
            if ($this->user->infoCompany) {
                $title_company = $this->user->infoCompany->typePerson === 0 ? $this->user->infoCompany->title :
                    $this->user->infoCompany->name . ' ' . $this->user->infoCompany->surname;
            }
        }
        $title_executor = null;
        $id_executor = null;
        if($this->deal) {
            $responses = $this->deal->responsesTender ?? null;
            if ($responses) {
                $info_company = $responses->infoCompany ?? null;
                if ($info_company) {
                    $title_executor = $info_company->title;
                    $id_executor = $info_company->id;
                }
            }
        }
        return [
            'id' => $this->id,
            'title' => $title_company,
            'createDate' => Carbon::parse($this->created_at)->translatedFormat('d F Y / H:i'),
            'dateOfStay' => Carbon::parse($this->startDate)->translatedFormat('d') . ' - ' .
                Carbon::parse($this->endDate)->translatedFormat('d F Y') . ' ' . $this->spreadDate,
            'region' => $this->city->region->title,
            'customer_title' => $title_company,
            'title_executor' => $title_executor,
            'customer_info' => [
                'user_id' => $this->user_id,
                'title' => $title_company,
            ],
            'executor_info' => [
                'user_id' => $id_executor,
                'title' => $title_executor,
            ],
            'archive' => $this->archive,
            'hasDeal' => (bool)$this->deal,
            'deal' => $this->deal,
            'start_date' => $this->startDate
        ];
    }
}

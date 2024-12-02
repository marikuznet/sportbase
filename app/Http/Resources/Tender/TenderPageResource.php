<?php

namespace App\Http\Resources\Tender;

use App\Http\Resources\Admin\UsersResource;
use App\Http\Resources\Deal\DealResource;
use App\Models\Tender\ResponsesTenderAndTenders;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TenderPageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        if ($this->user->infoCompany->phoneCompany != "[]") {
            $phoneCompany = json_decode($this->user->infoCompany->phoneCompany)[0];
        } else $phoneCompany = "";

        $title_company = $this->user->infoCompany ?
            ($this->user->infoCompany->typePerson === 0 ? $this->user->infoCompany->title :
                $this->user->infoCompany->name . ' ' . $this->user->infoCompany->surname) : null;

        $phone_company = $this->user->infoCompany->typePerson === 0 ? $phoneCompany :
            json_decode($this->user->infoCompany->phone);

        $email_company = $this->user->infoCompany ?
            ($this->user->infoCompany->typePerson === 0 ? $this->user->infoCompany->emailCompany :
                $this->user->infoCompany->email) : null;

        $image_company = $this->user->infoCompany ? json_decode($this->user->infoCompany->image) : null;

        return [
            'id' => $this->id,
            'customer_info' => [
                'user_id' => $this->user_id,
                'title' => $title_company,
                'email' => $email_company,
                'phone' => $phone_company,
                'logo' => $image_company,
            ],
            'type_sports' => $this->sports->map(function ($sport) {
                return [
                    'id' => $sport->id,
                    'title' => $sport->title,
                ];
            }),
            'infrastructures' => $this->infrastructures ? $this->infrastructures->map(function ($infrastructure) {
                return [
                    'id' => $infrastructure->id,
                    'title' => $infrastructure->title,
                ];
            }) : null,
            'city' => $this->city->title ?? null,
            'region_id' => $this->city->region->id ?? null,
            'region' => $this->city->region->title ?? null,
            'country' => $this->city->region->country->title ?? null,
            'colPeople' => $this->colPeople,
            'minPrice' => $this->minPrice,
            'priceForPerson' => $this->priceForPerson,
            'startDate' => Carbon::parse($this->startDate)->translatedFormat('d F'),
            'endDate' => Carbon::parse($this->endDate)->translatedFormat('d F'),
            'spreadDate' => $this->spreadDate,
            'comment' => $this->comment,
            'allResponses_count' => $this->countResponses(),
            'myResponses_count' => $this->myResponses(),
            'responses' => ResponsesTenderResourse::collection($this->responses),
        ];
    }

    public function countResponses()
    {
        return count($this->responses);
    }

    public function myResponses()
    {
        $count = 0;
        $responses = ResponsesTenderResourse::collection($this->responses) ?? null;
        if ($responses != null)
            foreach ($responses as $response)
                if ($response->user_id == Auth::id() && $response->archive == 0)
                    $count++;
        return $count;
    }
}

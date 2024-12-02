<?php

namespace App\Http\Resources;

use App\Http\Resources\Profile\PaymentDetailsResourse;
use Illuminate\Http\Resources\Json\JsonResource;

class InfoCompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        if ($this->address) {
            $city = $this->address->city->title;
            $city_id = $this->address->city->id;
            $region = $this->address->city->region->title;
            $country = $this->address->city->region->country->title;
            $postIndex = $this->address->postIndex;
            $address = $this->address->address;
            $longtitude = $this->address->longtitude;
            $latitude = $this->address->latitude;
        } else {
            $city = null;
            $city_id = null;
            $region = null;
            $country = null;
            $postIndex = null;
            $address = null;
            $longtitude = null;
            $latitude = null;
        }
        return [
            'id' => $this->id,
            'typePerson' => $this->typePerson,
            'name_user' => $this->typePerson == 0 ? $this->title : $this->surname . ' ' . $this->name . ' ' . $this->patronymic,

            'user_id' => $this->user_id,
            'title' => $this->title,
            'contactPerson' => $this->name . ' ' . $this->surname,
            'image' => json_decode($this->image),
            'phoneCompany' => json_decode($this->phoneCompany),
            'quantityEmployees' => $this->quantityEmployees,
            'emailCompany' => $this->emailCompany,
            'site' => $this->site,
            'description' => $this->description,
            'description_no_tags' => strip_tags($this->description),

            'address_id' => $this->address_id,
            'city_id' => $city_id,
            'city' => $city,
            'region' => $region,
            'country' => $country,
            'postIndex' => $postIndex,
            'address' => $address,
            'longtitude' => $longtitude,
            'latitude' => $latitude,

            'social' => [
                'facebook' => $this->facebook,
                'twitter' => $this->twitter,
                'linkedIn' => $this->linkedIn,
                'telegram' => $this->telegram,
                'slack' => $this->slack,
                'instagram' => $this->instagram,
            ],

            'surname' => $this->surname,
            'name' => $this->name,
            'patronymic' => $this->patronymic,
            'position' => $this->position,
            'position_id' => $this->position_id,
            'email' => $this->email ?? "",
            'phone' => $this->when($this->phone, json_decode($this->phone), ""),
            'payment_details' => $this->when($this->paymentDetails, new PaymentDetailsResourse($this->paymentDetails)),
        ];
    }
}

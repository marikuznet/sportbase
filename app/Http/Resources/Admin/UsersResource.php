<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\InfoCompanyResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UsersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $address = null;
        if ($this->infoCompany) {
            if ($this->infoCompany->address) {
                $address = $this->infoCompany->address->city->region->title . ", " . $this->infoCompany->address->city->title
                    . ", " . $this->infoCompany->address->address;
            }
            else $address = null;
            $info = $this->infoCompany;
        } else {
            $info = null;
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => $this->password,
            'role' => $this->role,
            'status' => $this->status,
            'block' => $this->block,
            'brief_info' => $this->brief_info,
            'created_at' => Carbon::parse($this->created_at)->translatedFormat('d.m.Y/H:i'),
            'info' => $this->when($this->infoCompany, new InfoCompanyResource($this->infoCompany)),
            'address' => $address,
            'notifications' => $this->when($this->notifications, new AdminUserNotificationCollection($this->notifications))
        ];
    }
}

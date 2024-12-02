<?php

namespace App\Http\Resources\Profile;

use App\Http\Resources\InfoCompanyResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $infoCompany = $this->when($this->infoCompany, new InfoCompanyResource($this->infoCompany));
        $created = $this->message ? ($this->message->created_at ? $this->message->created_at : null) : null;
        return [
            'id' => $this->id,
            'role' => $this->role,
            'info' => [
                'name' => $this->infoCompany->typePerson == 0 ? $this->infoCompany->title :
                    $this->infoCompany->surname . ' ' . $this->infoCompany->name . ' ' . $this->infoCompany->patronymic,
                'image' => json_decode($infoCompany->image) ?? null
            ],
            'isOnline' => Cache::has('user-is-online-' . $this->id),
        ];
    }
}

<?php

namespace App\Http\Resources\Profile;

use App\Http\Resources\InfoCompanyResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class UserWithLastMessageResource extends JsonResource
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
            'last_message' => $this->message->text ?? null,
            'last_message_read' => $this->message->read ?? null,
            'unread' => $this->unread,
            'time' => $created ? Carbon::parse($this->message->created_at
                ->timezone('Europe/Moscow'))->format("H:i") : null,
            'date' => Carbon::parse($created)->translatedFormat("d M"),
            'prevDay' => Carbon::parse($created)->isCurrentDay(),
            'created_at' => $created ? Carbon::parse($created)->format("Y-m-d H:i:s") : null,
        ];
    }
}

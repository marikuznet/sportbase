<?php

namespace App\Http\Resources\Admin;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'image' => $this->image,
            'slug' => str_slug($this->title),
            'content' => $this->content,
            'view_count' => $this->view_count,
            'share_vk_count' => $this->share_vk_count,
            'share_fb_count' => $this->share_fb_count,
            'share_tw_count' => $this->share_tw_count,
            'created' => Carbon::parse($this->created_at)->translatedFormat('d.m.y'),
        ];
    }
}

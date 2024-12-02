<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'image', 'content', 'view_count', 'share_vk_count',
        'share_fb_count', 'share_tw_count'
    ];

    protected $casts = [
        'id' => 'integer',
        'view_count' => 'integer',
        'share_vk_count' => 'integer',
        'share_fb_count' => 'integer',
        'share_tw_count' => 'integer',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}

<?php

namespace App\Models\Profile;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendNotifEmail extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'eventNotification_id',
        'user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'eventNotification_id' => 'integer',
        'user_id' => 'integer',
    ];

    public function eventNotification()
    {
        return $this->belongsTo(\App\Models\Profile\EventNotification::class, 'eventNotification_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}

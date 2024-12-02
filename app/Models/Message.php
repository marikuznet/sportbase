<?php

namespace App\Models;

use App\Traits\HasLocalDates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    use HasLocalDates;

    protected $fillable = [
        'from', 'to', 'read', 'text', 'images'
    ];

    protected $casts = [
        'from' => 'integer',
        'to' => 'integer',
        'read' => 'boolean',
        'images' => 'array',
        'created_at' => 'datetime'
    ];

    public function fromContact(){
        return $this->hasOne(User::class, 'id', 'from');
    }

    public function user_to()
    {
        return $this->hasOne(User::class, 'id', 'to');
    }

    public function user_from()
    {
        return $this->hasOne(User::class, 'id', 'from');
    }
}

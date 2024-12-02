<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SportTypeAndObject extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sportObject_id',
        'sportType_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'sportObject_id' => 'integer',
        'sportType_id' => 'integer',
    ];


    public function sportObject()
    {
        return $this->belongsTo(\App\Models\SportObject::class);
    }

    public function sportType()
    {
        return $this->belongsTo(\App\Models\SportType::class, 'sportType_id');
    }
}

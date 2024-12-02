<?php

namespace App\Models\Profile;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'city_id',
        'postIndex',
        'address',
        'longtitude',
        'latitude',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'city_id' => 'integer',
        'longtitude' => 'float',
        'latitude' => 'float',
    ];

    public function city()
    {
        return $this->belongsTo(\App\Models\City::class);
    }
}

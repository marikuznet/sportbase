<?php

namespace App\Models;

use App\Http\Resources\RegionResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'region_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'region_id' => 'integer',
    ];


    public function region()
    {
        return $this->belongsTo(\App\Models\Region::class, 'region_id', 'id');
    }

    public function sportObject()
    {
        return $this->belongsTo(\App\Models\SportObject::class, 'sportObject_id');
    }
}
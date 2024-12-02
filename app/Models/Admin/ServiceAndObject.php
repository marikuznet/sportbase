<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceAndObject extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sportObject_id',
        'service_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'sportObject_id' => 'integer',
        'service_id' => 'integer',
    ];


    public function sportObject()
    {
        return $this->belongsTo(\App\Models\SportObject::class);
    }

    public function service()
    {
        return $this->belongsTo(\App\Models\Service::class);
    }
}

<?php

namespace App\Models\Advertisment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusAdvertisment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

   /* public function advertismentOrder()
    {
        return $this->belongsTo(\App\Models\Advertisment\AdvertismentOrders::class);
    }*/
}

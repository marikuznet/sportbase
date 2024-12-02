<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rentAddition extends Model
{
    use HasFactory;
    protected $fillable = [
        'checkLaundry', 'washingVolume', 'priceWashing', 'sumLaundry', 'checkTransfer',
        'durationTransfer', 'priceTransfer', 'sumTransfer', 'infrastructures', 'totalPrice'];
    protected $casts = [
        'id' => 'integer',
        'checkLaundry' => 'boolean',
        'washingVolume' => 'integer',
        'priceWashing' => 'float',
        'sumLaundry' => 'float',
        'checkTransfer' => 'boolean',
        'durationTransfer' => 'integer',
        'priceTransfer' => 'float',
        'sumTransfer' => 'float',
        'infrastructures' => 'array',
        'totalPrice' => 'float',
    ];
}

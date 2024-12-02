<?php

namespace App\Models;

use App\Models\Advertisment\AdvertismentOrders;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentTransaction extends Model
{
    use HasFactory;

    protected $fillable = ["payment_id", "amount", "status", "payment_at"];

    protected $casts = [
        'id' => 'integer',
        'amount' => 'float',
        'payment_at' => 'datetime',
    ];

    public function advertisementOrder()
    {
        return $this->hasMany(AdvertismentOrders::class, 'payment_transaction_id', 'id');
    }
}

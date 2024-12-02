<?php

namespace App\Models\Advertisment;

use App\Traits\HasLocalDates;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class AdvertismentOrders extends Model
{
    use HasFactory, HasLocalDates;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'dateStart',
        'date_end',
        'sportObject_id',
        'days',
        'statusAdvertisment_id',
        'amount',
        'description',
        'status',
        'payment_transaction_id',
        'paused',
        'paused_at',
        'pause_until'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'dateStart' => 'datetime',
        'date_end' => 'datetime',
        'sportObject_id' => 'integer',
        'rateAdvertisment_id' => 'integer',
        'days' => 'integer',
        'statusAdvertisment_id' => 'integer',
        'amount' => 'float',
        'payment_transaction_id' => 'integer',
        'paused' => 'boolean',
        'paused_at' => 'datetime',
        'pause_until' => 'datetime',
    ];


    public function sportObject()
    {
        return $this->belongsTo(\App\Models\SportObject::class, 'sportObject_id', 'id');
    }

    public function rateAdvertisment()
    {
        return $this->belongsToMany(RateAdvertisment::class, 'advertisment_orders_and_rate_advertisments', 'advertisment_order_id', 'rate_advertisment_id');
    }

    public function statusAdvertisment()
    {
        return $this->belongsTo(\App\Models\Advertisment\StatusAdvertisment::class, 'statusAdvertisment_id');
    }

    public function paymentTransaction()
    {
        return $this->belongsTo(\App\Models\PaymentTransaction::class, 'payment_transaction_id');
    }

    public function pause($days)
    {
        $pauseUntil = now()->addDays($days);
        $this->update([
            'paused' => true,
            'paused_at' => Carbon::now(),
            'pause_until' => $pauseUntil,
        ]);
    }

    public function resume()
    {
       /* $currentDateTime = now();
        $startDate = Carbon::parse($this->dateStart);
        $pausedDateTime = $this->paused_at ?? $currentDateTime;

        $activeMinutes = $pausedDateTime->diffInMinutes($startDate);
        $daysSincePause = $pausedDateTime->diffInMinutes($currentDateTime) / (24 * 60);
        $remainingDays = $this->days - ($activeMinutes / (24 * 60)) - $daysSincePause;
        $endDateTime = $currentDateTime->addDays($remainingDays + 1);
        $this->update([
            'paused' => false,
            'paused_at' => null,
            'date_end' => $endDateTime
        ]);*/
    }


    public function isPaused()
    {
        return $this->paused;
    }

    public function incrementViews()
    {
        if ($this->sportObject->user_id !== Auth::id()) {
            $this->increment('views');
        }
    }

    public function incrementClicks()
    {
        if ($this->sportObject->user_id !== Auth::id()) {
            $this->increment('clicks');
        }
    }

    public function incrementConversions()
    {
        if ($this->sportObject->user_id !== Auth::id()) {
            $this->increment('conversions');
        }
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccomodationTypeAndPricingAndObject extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sportObject_id',
        'accomodationType_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'sportObject_id' => 'integer',
        'accomodationType_id' => 'integer',
    ];

    public function sportObject(): BelongsTo
    {
        return $this->belongsTo(SportObject::class);
    }

    public function typeAndPricing()
    {
        return $this->belongsTo(AccomodationTypeAndPricing::class, 'accomodationType_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AccomodationTypeAndPricing extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'accomodation_type_and_pricings';
    protected $fillable = [
        'accomodationType_id',
        'description',
        'price',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'accomodationType_id' => 'integer',
        'price' => 'array',
    ];

    public function accomodationType(): BelongsTo
    {
        return $this->belongsTo(AccomodationType::class, 'accomodationType_id');
    }

    public function includedInAccomodationPricing(): HasOne
    {
        return $this->hasOne(IncludedInAccomodationPricing::class, 'id');
    }

    public function sportObject(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(SportObject::class, 'accomodation_type_and_pricing_and_objects',
            'accomodationType_id', 'sportObject_id');
    }

    public function accomodationTypeAndPricingAndObject(){
        return $this->belongsTo(AccomodationTypeAndPricingAndObject::class);
    }
}

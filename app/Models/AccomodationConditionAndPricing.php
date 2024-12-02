<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccomodationConditionAndPricing extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description',
        'included_in_accomodation_pricing_id',
        'image',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'included_in_accomodation_pricing_id' => 'integer',
        'image' => 'json',
    ];


    public function includedInAccomodationPricing()
    {
        return $this->belongsTo(IncludedInAccomodationPricing::class);
    }

    public function accomodationTypePricing()
    {
        return $this->belongsTo(AccomodationTypeAndPricing::class, 'accCondAndPricing_id');
    }

    public function typeAndPricing()
    {
        return $this->belongsTo(AccomodationTypeAndPricing::class, 'accomodationType_id');
    }
}

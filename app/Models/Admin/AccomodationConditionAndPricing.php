<?php

namespace App\Models\Admin;

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
        'includedInAccomodationPricing_id',
        'image',
        'accomodationTypeAndPricing_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'includedInAccomodationPricing_id' => 'integer',
        'image' => 'array',
        'accomodationTypeAndPricing_id' => 'integer',
    ];


    public function includedInAccomodationPricing()
    {
        return $this->belongsTo(\App\Models\IncludedInAccomodationPricing::class);
    }

    public function accomodationTypeAndPricing()
    {
        return $this->belongsTo(\App\Models\AccomodationTypeAndPricing::class);
    }
}

<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SportObject extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'objectType_id',
        'image',
        'description',
        'sportType_id',
        'accomodationConditionAndPricing_id',
        'infrastructure_id',
        'city_id',
        'address',
        'postIndex',
        'longtitude',
        'latitude',
        'rating',
        'feedback_id',
        'user_id',
        'hasPromotion',
        'hasHighlightion',
        'hasVIP',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'objectType_id' => 'integer',
        'image' => 'array',
        'sportType_id' => 'integer',
        'accomodationConditionAndPricing_id' => 'integer',
        'infrastructure_id' => 'integer',
        'city_id' => 'integer',
        'longtitude' => 'float',
        'latitude' => 'float',
        'rating' => 'float',
        'feedback_id' => 'array',
        'hasPromotion' => 'boolean',
        'hasHighlightion' => 'boolean',
        'hasVIP' => 'boolean',
    ];


    public function feedback()
    {
        return $this->hasMany(\App\Models\Feedback::class);
    }

    public function sportTypes()
    {
        return $this->hasMany(\App\Models\SportType::class);
    }

    public function objectType()
    {
        return $this->belongsTo(\App\Models\ObjectType::class);
    }

    public function sportType()
    {
        return $this->belongsTo(\App\Models\SportType::class);
    }

    public function accomodationConditionAndPricing()
    {
        return $this->belongsTo(\App\Models\AccomodationConditionAndPricing::class);
    }

    public function infrastructure()
    {
        return $this->belongsTo(\App\Models\Infrastructure::class);
    }

    public function city()
    {
        return $this->belongsTo(\App\Models\City::class);
    }
}

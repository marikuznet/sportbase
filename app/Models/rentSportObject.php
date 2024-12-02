<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rentSportObject extends Model
{
    use HasFactory;

    protected $fillable = [
        'checkSport', 'price', 'sum', 'start_date', 'end_date', 'time',
        'training', 'trainingTime', 'trainingTime_diff'];
    protected $casts = [
        'id' => 'integer',
        'checkSport' => 'boolean',
        'price' => 'float',
        'sum' => 'float',
        'start_date' => 'date',
        'end_date' => 'date',
        'time' => 'boolean',
        'training' => 'integer',
        'trainingTime' => 'array',
        'trainingTime_diff' => 'array',
    ];

    private function estimate()
    {
        return $this->belongsTo(\App\Models\Estimate::class, 'estimate_id');
    }
}

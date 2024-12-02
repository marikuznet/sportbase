<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rentAccommodation extends Model
{
    use HasFactory;
    protected $fillable = [
        'checkAccm', 'accommodations', 'daysAccm', 'priceFood', 'start_date',
        'end_date', 'sumAccm', 'sumPriceFood', 'titlePriceFood', 'typeFood_id'];
    protected $casts = [
        'id' => 'integer',
        'checkAccm' => 'boolean',
        'accommodations' => 'array',
        'daysAccm' => 'integer',
        'priceFood' => 'float',
        'start_date' => 'date',
        'end_date' => 'date',
        'sumAccm' => 'float',
        'sumPriceFood' => 'float',
        'typeFood_id' => 'integer',
    ];

    public function typeFood(){
        return $this->belongsTo(\App\Models\Tender\TypeFood::class, "typeFood_id");
    }
}

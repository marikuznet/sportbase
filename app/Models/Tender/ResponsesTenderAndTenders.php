<?php

namespace App\Models\Tender;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponsesTenderAndTenders extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'responsesTender_id',
        'tender_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'responsesTender_id' => 'integer',
        'tender_id' => 'integer',
    ];


    public function responsesTender()
    {
        return $this->belongsTo(\App\Models\Tender\ResponsesTender::class, 'responsesTender_id');
    }

    public function tender()
    {
        return $this->belongsTo(\App\Models\Tender\Tender::class);
    }
}

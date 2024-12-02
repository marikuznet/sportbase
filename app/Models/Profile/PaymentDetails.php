<?php

namespace App\Models\Profile;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentDetails extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'legal_name', 'title', 'tin', 'numKpp', 'bic', 'requisites',
        'kc', 'okpo', 'okato', 'orgn', 'address_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
    ];

    public function address()
    {
        return $this->belongsTo(\App\Models\Profile\Address::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}

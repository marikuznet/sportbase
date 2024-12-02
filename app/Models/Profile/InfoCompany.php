<?php

namespace App\Models\Profile;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoCompany extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'image',
        'typePerson',
        'user_id',
        'phoneCompany',
        'quantityEmployees',
        'emailCompany',
        'site',
        'description',
        'address_id',

        'facebook',
        'twitter',
        'linkedIn',
        'telegram',
        'slack',
        'instagram',

        'surname',
        'name',
        'patronymic',
        'position_id',
        'email',
        'phone',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'address_id' => 'integer',
        'position_id' => 'integer',
        'phoneCompany' => 'array',
        'typePerson' => 'integer',
        'phone' => 'array',
        'image' => 'array',
    ];


    public function position()
    {
        return $this->belongsTo(\App\Models\Profile\Position::class);
    }

    public function address()
    {
        return $this->belongsTo(\App\Models\Profile\Address::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function tender(){
        return $this->hasOne(\App\Models\Tender\Tender::class);
    }

    public function responsesTender(){
        return $this->hasOne(\App\Models\Tender\ResponsesTender::class);
    }

    public function paymentDetails(){
        return $this->hasOne(\App\Models\Profile\PaymentDetails::class, 'user_id', 'user_id');
    }
}

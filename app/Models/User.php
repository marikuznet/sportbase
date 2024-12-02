<?php

namespace App\Models;

use App\Models\Profile\SendNotifEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Support\Facades\Cache;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasApiTokens;

    const STATUS_DELETED = 0;
    const STATUS_REGISTER = 9;
    const STATUS_VERIFY = 10;
    const STATUS_ACTIVE = 11;
    const STATUS_BLOCK = 12;
    const STATUS_CHECK = 13;
    const USER_ROLE_CUSTOMER = 2;
    const USER_ROLE_EXECUTOR = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'verify_token', 'status', 'role', 'brief_info', 'block', 'isOnline', 'last_seen',
        'user_timezone'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'phone_verified_at' => 'datetime',
        'role' => 'int',
        'block' => 'int',
        'last_seen' => 'datetime'
    ];

    protected $primaryKey = 'id';

    /**
     * @var mixed
     */


    public function infoCompany()
    {
        return $this->hasOne(\App\Models\Profile\InfoCompany::class);
    }

    public function paymentDetails()
    {
        return $this->hasOne(\App\Models\Profile\PaymentDetails::class, 'user_id');
    }

    public function notifications()
    {
        return $this->hasMany(SendNotifEmail::class, 'user_id');
    }

    public function isAdmin()
    {
        return $this->role === 1;
    }

    public function isOnline()
    {
        return Cache::has('user-is-online-' . $this->id);
    }

    public static function self()
    {
        return User::where("id", Auth::id())->first();
    }

    public function messagesArbitr()
    {
        return $this->hasMany(MessageArbitr::class);
    }

    public function sportObjects()
    {
        return $this->hasMany(SportObject::class, 'user_id', 'id')->with(['advertisements' => function ($query) {
            $query->where(function ($q) {
                $q->whereNull('date_end')
                    ->orWhere('date_end', '>', now()->toDateString());
            });//->where('paused', 0);
        }]);
    }

    public function messagesProfile()
    {
        return $this->hasMany(Message::class, 'from');
    }

    public function messagesProfileTo()
    {
        return $this->hasMany(Message::class, 'to');
    }
}

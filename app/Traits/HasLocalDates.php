<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

trait HasLocalDates
{

    private function setLocalDateTimeAttribute($value, string $field)
    {
        $this->attributes[$field] = $this->inUsersTimezone(Carbon::parse($value));
    }

    /**
     * Localize a date to the user's timezone
     *
     * @param Carbon|null $date
     * @return Carbon
     */
    public function localize(?Carbon $date = null): Carbon
    {
        $dateValue = $date ?? now();
        return $this->inUsersTimezone($dateValue);
    }

    /**
     * Change the timezone of a Carbon date
     *
     * @param Carbon $dateValue
     * @return Carbon
     */
    private function inUsersTimezone(Carbon $dateValue): Carbon
    {
        $timezone = optional(Auth::user())->user_timezone ?? config('app.timezone');
        return $dateValue->timezone($timezone);
    }

    public function setUpdatedAtAttribute($value)
    {
        $this->attributes['updated_at'] = $this->inUsersTimezone(Carbon::parse($value));
    }

    public function setCreatedAtAttribute($value)
    {
        $this->attributes['created_at'] = $this->inUsersTimezone(Carbon::parse($value));
    }

    public function setBlockedAtAttribute($value)
    {
        $this->attributes['blocked_at'] = $this->inUsersTimezone(Carbon::parse($value));
    }

    public function setPausedAtAttribute($value)
    {
        $this->attributes['paused_at'] = $this->inUsersTimezone(Carbon::parse($value));
    }

}

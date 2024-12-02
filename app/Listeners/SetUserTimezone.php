<?php

namespace App\Listeners;

use App\Events\AuthUser;

class SetUserTimezone
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AuthUser $event)
    {
        $userTimezone = request()->input('user_timezone');
        if ($userTimezone && $event->user) {
            $event->user->user_timezone = $userTimezone;
            $event->user->save();
        }
    }
}

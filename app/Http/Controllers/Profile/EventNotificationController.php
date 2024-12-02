<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Resources\Profile\EventNotificationResource;
use App\Http\Resources\Profile\SendNotificationResource;
use App\Models\Profile\EventNotification;
use App\Models\Profile\SendNotifEmail;
use Illuminate\Http\Request;

class EventNotificationController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function index(Request $request)
    {
        $event = EventNotification::all();
        $array = [];
        foreach ($event as $object)
            array_push($array, new EventNotificationResource($object));
        return $array;
    }

    public function indexFetch(Request $request)
    {
        $event = SendNotifEmail::all();
        $array = [];
        foreach ($event as $object)
            array_push($array, new SendNotificationResource($object));
        return $array;
    }
}

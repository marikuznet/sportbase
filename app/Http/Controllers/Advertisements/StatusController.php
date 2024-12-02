<?php

namespace App\Http\Controllers\Advertisements;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdvertisementAndTariffs\StatusAdvertismentCollection;
use App\Models\Advertisment\StatusAdvertisment;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return StatusAdvertismentCollection
     */
    public function index(Request $request)
    {
        $statuses = StatusAdvertisment::all();
        return new StatusAdvertismentCollection($statuses);
    }
}

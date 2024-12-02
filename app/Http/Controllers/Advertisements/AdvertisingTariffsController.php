<?php

namespace App\Http\Controllers\Advertisements;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdvertisementAndTariffs\AdvertisingTariffsCollection;
use App\Models\Advertisment\RateAdvertisment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AdvertisingTariffsController extends Controller
{
    public function index(){
        $rates = RateAdvertisment::all();
        return response(new AdvertisingTariffsCollection($rates), 200);
    }
}

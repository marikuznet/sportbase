<?php

namespace App\Http\Controllers\Advertisements;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdvertisementAndTariffs\AdvertisementCollection;
use App\Http\Resources\AdvertisementAndTariffs\RateAdvertismentCollection;
use App\Models\Advertisment\AdvertismentOrders;
use App\Models\Advertisment\RateAdvertisment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RateAdvertisementController extends Controller
{
    public function index(Request $request)
    {
        $rates = RateAdvertisment::all();
        return response(new RateAdvertismentCollection($rates), 200);
    }

    public function update(Request $request, $id)
    {
        RateAdvertisment::find($id)->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);
        return response(null, 200);
    }

    public function updatePrice(Request $request, $id)
    {
        RateAdvertisment::find($id)->update([
            'price' => $request->price
        ]);
        return response(null, 200);
    }
}

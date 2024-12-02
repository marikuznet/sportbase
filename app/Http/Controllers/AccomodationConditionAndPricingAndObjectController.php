<?php

namespace App\Http\Controllers;

use App\Http\Resources\AccomodationConditionAndPricingAndObjectsCollection;
use App\Http\Resources\AccomodationConditionAndPricingAndObjectsResource;
use App\Http\Resources\AccomodationConditionAndPricingCollection;
use App\Http\Resources\AccomodationTypeAndPricingCollection;
use App\Models\AccomodationTypeAndPricingAndObject;
use Illuminate\Http\Request;

class AccomodationConditionAndPricingAndObjectController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return AccomodationConditionAndPricingAndObjectsCollection
     */
    public function index(Request $request)
    {
        //return $array;
        /*if (!$request->ajax())
            return response()->noContent();*/

        $accomCondPricings = AccomodationTypeAndPricingAndObject::get()->all();
        return new AccomodationConditionAndPricingAndObjectsCollection($accomCondPricings);
    }

    public function store(Request $request) {
        $pricingsAndObject = AccomodationTypeAndPricingAndObject::create([
            'sportObject_id' => $request->sportObject_id,
            'accomodationType_id' => $request->accomodationType_id,
        ]);
        return $request;
    }
}

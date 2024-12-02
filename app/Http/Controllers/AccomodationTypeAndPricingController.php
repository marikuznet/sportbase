<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccomodationTypeAndPricingStoreRequest;
use App\Http\Requests\AccomodationTypeAndPricingUpdateRequest;
use App\Http\Resources\AccomodationTypeAndPricingCollection;
use App\Http\Resources\AccomodationTypeAndPricingResource;
use App\Models\AccomodationType;
use App\Models\AccomodationTypeAndPricing;
use Illuminate\Http\Request;

class AccomodationTypeAndPricingController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $accomodationTypeAndPricings = AccomodationTypeAndPricing::all();
        $array = [];
        foreach ($accomodationTypeAndPricings as $object)
            array_push($array, new AccomodationTypeAndPricingResource($object));
        return $array;
        //return response()->json('success', 200);
    }

    /**
     * @param \App\Http\Requests\AccomodationTypeAndPricingStoreRequest $request
     * @return \App\Http\Resources\AccomodationTypeAndPricingResource
     */
    public function store(AccomodationTypeAndPricingStoreRequest $request)
    {
        $accomodationTypeAndPricing = AccomodationTypeAndPricing::create($request->validated());

        $request->session()->flash('$accomodationTypeAndPricing.id', $accomodationTypeAndPricing->id);
        return new AccomodationTypeAndPricingResource($accomodationTypeAndPricing);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AccomodationTypeAndPricing $accomodationTypeAndPricing
     * @return \App\Http\Resources\AccomodationTypeAndPricingResource
     */
    public function show(Request $request, AccomodationTypeAndPricing $accomodationTypeAndPricing)
    {
        return new AccomodationTypeAndPricingResource($accomodationTypeAndPricing);
    }

    /**
     * @param \App\Http\Requests\AccomodationTypeAndPricingUpdateRequest $request
     * @param \App\Models\AccomodationTypeAndPricing $accomodationTypeAndPricing
     * @return \App\Http\Resources\AccomodationTypeAndPricingResource
     */
    public function update(AccomodationTypeAndPricingUpdateRequest $request, AccomodationTypeAndPricing $accomodationTypeAndPricing)
    {
        $accomodationTypeAndPricing->update($request->validated());

        return new AccomodationTypeAndPricingResource($accomodationTypeAndPricing);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AccomodationTypeAndPricing $accomodationTypeAndPricing
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, AccomodationTypeAndPricing $accomodationTypeAndPricing)
    {
        $accomodationTypeAndPricing->delete();

        return response()->noContent();
    }
}

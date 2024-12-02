<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\AccomodationTypeAndPricingStoreRequest;
use App\Http\Requests\Admin\AccomodationTypeAndPricingUpdateRequest;
use App\Http\Resources\Admin\AccomodationTypeAndPricingCollection;
use App\Http\Resources\Admin\AccomodationTypeAndPricingResource;
use App\Models\Admin\AccomodationTypeAndPricing;
use Illuminate\Http\Request;

class AccomodationTypeAndPricingController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\AccomodationTypeAndPricingCollection
     */
    public function index(Request $request)
    {
        $accomodationTypeAndPricings = AccomodationTypeAndPricing::all();

        return new AccomodationTypeAndPricingCollection($accomodationTypeAndPricings);
    }

    /**
     * @param \App\Http\Requests\AccomodationTypeAndPricingStoreRequest $request
     * @return \App\Http\Resources\AccomodationTypeAndPricingResource
     */
    public function store(AccomodationTypeAndPricingStoreRequest $request)
    {
        $accomodationTypeAndPricing = AccomodationTypeAndPricing::create($request->validated());

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

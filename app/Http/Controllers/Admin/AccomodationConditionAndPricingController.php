<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\AccomodationConditionAndPricingStoreRequest;
use App\Http\Requests\Admin\AccomodationConditionAndPricingUpdateRequest;
use App\Http\Resources\Admin\AccomodationConditionAndPricingCollection;
use App\Http\Resources\Admin\AccomodationConditionAndPricingResource;
use App\Models\Admin\AccomodationConditionAndPricing;
use Illuminate\Http\Request;

class AccomodationConditionAndPricingController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\AccomodationConditionAndPricingCollection
     */
    public function index(Request $request)
    {
        $accomodationConditionAndPricings = AccomodationConditionAndPricing::all();

        return new AccomodationConditionAndPricingCollection($accomodationConditionAndPricings);
    }

    /**
     * @param \App\Http\Requests\AccomodationConditionAndPricingStoreRequest $request
     * @return \App\Http\Resources\AccomodationConditionAndPricingResource
     */
    public function store(AccomodationConditionAndPricingStoreRequest $request)
    {
        $accomodationConditionAndPricing = AccomodationConditionAndPricing::create($request->validated());

        return new AccomodationConditionAndPricingResource($accomodationConditionAndPricing);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AccomodationConditionAndPricing $accomodationConditionAndPricing
     * @return \App\Http\Resources\AccomodationConditionAndPricingResource
     */
    public function show(Request $request, AccomodationConditionAndPricing $accomodationConditionAndPricing)
    {
        return new AccomodationConditionAndPricingResource($accomodationConditionAndPricing);
    }

    /**
     * @param \App\Http\Requests\AccomodationConditionAndPricingUpdateRequest $request
     * @param \App\Models\AccomodationConditionAndPricing $accomodationConditionAndPricing
     * @return \App\Http\Resources\AccomodationConditionAndPricingResource
     */
    public function update(AccomodationConditionAndPricingUpdateRequest $request, AccomodationConditionAndPricing $accomodationConditionAndPricing)
    {
        $accomodationConditionAndPricing->update($request->validated());

        return new AccomodationConditionAndPricingResource($accomodationConditionAndPricing);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AccomodationConditionAndPricing $accomodationConditionAndPricing
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, AccomodationConditionAndPricing $accomodationConditionAndPricing)
    {
        $accomodationConditionAndPricing->delete();

        return response()->noContent();
    }
}

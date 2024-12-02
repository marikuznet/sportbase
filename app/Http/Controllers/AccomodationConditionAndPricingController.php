<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccomodationConditionAndPricingStoreRequest;
use App\Http\Requests\AccomodationConditionAndPricingUpdateRequest;
use App\Http\Resources\AccomodationConditionAndPricingCollection;
use App\Http\Resources\AccomodationConditionAndPricingResource;
use App\Models\AccomodationConditionAndPricing;
use App\Models\Admin\AccomodationTypeAndPricing;
use App\Models\IncludedInAccomodationPricing;
use App\Models\SportObject;
use Illuminate\Http\Request;

class AccomodationConditionAndPricingController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function index(Request $request)
    {
        $accomodationConditionAndPricings = AccomodationConditionAndPricing::all();
        $array = [];
        foreach ($accomodationConditionAndPricings as $accomodationConditionAndPricing) {
            array_push($array, new AccomodationConditionAndPricingResource($accomodationConditionAndPricing));
        }
        return $array;
    }

    /**
     * @param \App\Http\Requests\AccomodationConditionAndPricingStoreRequest $request
     * @return int
     */
    public function store(Request $request)
    {
        $includedInAccomodationPricing = IncludedInAccomodationPricing::create([
            'title' => $request->included_in_accomodation_pricing
        ]);
        $accomodationConditionAndPricing = AccomodationConditionAndPricing::create([
            'description' => $request->description,
            'included_in_accomodation_pricing_id' => $includedInAccomodationPricing->id,
            'image' => $request->image
        ]);
        return (int)$accomodationConditionAndPricing->id;
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

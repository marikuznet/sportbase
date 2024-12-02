<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\IncludedInAccomodationPricingStoreRequest;
use App\Http\Requests\Admin\IncludedInAccomodationPricingUpdateRequest;
use App\Http\Resources\Admin\IncludedInAccomodationPricingCollection;
use App\Http\Resources\Admin\IncludedInAccomodationPricingResource;
use App\Models\Admin\IncludedInAccomodationPricing;
use Illuminate\Http\Request;

class IncludedInAccomodationPricingController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\IncludedInAccomodationPricingCollection
     */
    public function index(Request $request)
    {
        $includedInAccomodationPricings = IncludedInAccomodationPricing::all();

        return new IncludedInAccomodationPricingCollection($includedInAccomodationPricings);
    }

    /**
     * @param \App\Http\Requests\IncludedInAccomodationPricingStoreRequest $request
     * @return \App\Http\Resources\IncludedInAccomodationPricingResource
     */
    public function store(IncludedInAccomodationPricingStoreRequest $request)
    {
        $includedInAccomodationPricing = IncludedInAccomodationPricing::create($request->validated());

        return new IncludedInAccomodationPricingResource($includedInAccomodationPricing);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\IncludedInAccomodationPricing $includedInAccomodationPricing
     * @return \App\Http\Resources\IncludedInAccomodationPricingResource
     */
    public function show(Request $request, IncludedInAccomodationPricing $includedInAccomodationPricing)
    {
        return new IncludedInAccomodationPricingResource($includedInAccomodationPricing);
    }

    /**
     * @param \App\Http\Requests\IncludedInAccomodationPricingUpdateRequest $request
     * @param \App\Models\IncludedInAccomodationPricing $includedInAccomodationPricing
     * @return \App\Http\Resources\IncludedInAccomodationPricingResource
     */
    public function update(IncludedInAccomodationPricingUpdateRequest $request, IncludedInAccomodationPricing $includedInAccomodationPricing)
    {
        $includedInAccomodationPricing->update($request->validated());

        return new IncludedInAccomodationPricingResource($includedInAccomodationPricing);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\IncludedInAccomodationPricing $includedInAccomodationPricing
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, IncludedInAccomodationPricing $includedInAccomodationPricing)
    {
        $includedInAccomodationPricing->delete();

        return response()->noContent();
    }
}

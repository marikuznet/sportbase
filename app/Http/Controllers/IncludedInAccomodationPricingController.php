<?php

namespace App\Http\Controllers;

use App\Http\Requests\IncludedInAccomodationPricingStoreRequest;
use App\Http\Requests\IncludedInAccomodationPricingUpdateRequest;
use App\Models\AccomodationConditionAndPricing;
use App\Models\AccomodationType;
use App\Models\IncludedInAccomodationPricing;
use Illuminate\Http\Request;

class IncludedInAccomodationPricingController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $includedInAccomodationPricings = IncludedInAccomodationPricing::all();
        return response()->json($includedInAccomodationPricings);
    }

    /**
     * @param \App\Http\Requests\IncludedInAccomodationPricingStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(IncludedInAccomodationPricingStoreRequest $request)
    {
        $includedInAccomodationPricing = IncludedInAccomodationPricing::create($request->validated());
        $request->session()->flash('includedInAccomodationPricing.id', $includedInAccomodationPricing->id);

        return $includedInAccomodationPricing;
    }

    public function test(IncludedInAccomodationPricingStoreRequest $request)
    {
        $accom = AccomodationConditionAndPricing::find(1);
        $included = $accom->includedInAccomodationPricing()-get();
        return $included;

       /* $includedInAccomodationPricing = new IncludedInAccomodationPricing();
        $includedInAccomodationPricing->create($request->all);

        foreach ($request->get('accomodation_condition_and_pricings') as $accomId){
            $accom = AccomodationConditionAndPricing::find($accomId);
            $includedInAccomodationPricing->includedInAccomodationPricing ;
        }

        $request->session()->flash('includedInAccomodationPricing.id', $includedInAccomodationPricing->id);*/

       // return response()->json($includedInAccomodationPricing);
    }

    /**
     * @param \App\Http\Requests\IncludedInAccomodationPricingUpdateRequest $request
     * @param \App\Models\IncludedInAccomodationPricing $includedInAccomodationPricing
     * @return \Illuminate\Http\Response
     */
    public function update(IncludedInAccomodationPricingUpdateRequest $request, IncludedInAccomodationPricing $includedInAccomodationPricing)
    {
        $includedInAccomodationPricing->update($request->validated());

        $request->session()->flash('includedInAccomodationPricing.id', $includedInAccomodationPricing->id);

        return response()->json($includedInAccomodationPricing);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\IncludedInAccomodationPricing $includedInAccomodationPricing
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, IncludedInAccomodationPricing $includedInAccomodationPricing)
    {
        $includedInAccomodationPricing->delete();

        return response()->json($includedInAccomodationPricing);
    }
}

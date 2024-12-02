<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccomodationTypeStoreRequest;
use App\Http\Requests\AccomodationTypeUpdateRequest;
use App\Http\Resources\AccomodationTypeCollection;
use App\Http\Resources\AccomodationTypeResource;
use App\Models\AccomodationType;
use Illuminate\Http\Request;

class AccomodationTypeController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\AccomodationTypeCollection
     */
    public function index(Request $request)
    {
        $accomodationTypes = AccomodationType::all();
        return new AccomodationTypeCollection($accomodationTypes);
    }

    /**
     * @param \App\Http\Requests\AccomodationTypeStoreRequest $request
     * @return \App\Http\Resources\AccomodationTypeResource
     */
    public function store(AccomodationTypeStoreRequest $request)
    {
        $accomodationType = AccomodationType::create($request->validated());

        return new AccomodationTypeResource($accomodationType);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AccomodationType $accomodationType
     * @return \App\Http\Resources\AccomodationTypeResource
     */
    public function show(Request $request, AccomodationType $accomodationType)
    {
        return new AccomodationTypeResource($accomodationType);
    }

    /**
     * @param \App\Http\Requests\AccomodationTypeUpdateRequest $request
     * @param \App\Models\AccomodationType $accomodationType
     * @return \App\Http\Resources\AccomodationTypeResource
     */
    public function update(AccomodationTypeUpdateRequest $request, AccomodationType $accomodationType)
    {
        $accomodationType->update($request->validated());

        return new AccomodationTypeResource($accomodationType);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AccomodationType $accomodationType
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, AccomodationType $accomodationType)
    {
        $accomodationType->delete();

        return response()->noContent();
    }
}

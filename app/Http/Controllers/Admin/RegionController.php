<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\RegionStoreRequest;
use App\Http\Requests\Admin\RegionUpdateRequest;
use App\Http\Resources\Admin\RegionCollection;
use App\Http\Resources\Admin\RegionResource;
use App\Models\Admin\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return RegionCollection
     */
    public function index(Request $request)
    {
        $regions = Region::all();
        return new RegionCollection($regions);
    }

    /**
     * @param \App\Http\Requests\RegionStoreRequest $request
     * @return \App\Http\Resources\RegionResource
     */
    public function store(RegionStoreRequest $request)
    {
        $region = Region::create($request->validated());

        return new RegionResource($region);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Region $region
     * @return \App\Http\Resources\RegionResource
     */
    public function show(Request $request, Region $region)
    {
        return new RegionResource($region);
    }

    /**
     * @param \App\Http\Requests\RegionUpdateRequest $request
     * @param \App\Models\Region $region
     * @return \App\Http\Resources\RegionResource
     */
    public function update(RegionUpdateRequest $request, Region $region)
    {
        $region->update($request->validated());

        return new RegionResource($region);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Region $region
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Region $region)
    {
        $region->delete();

        return response()->noContent();
    }
}

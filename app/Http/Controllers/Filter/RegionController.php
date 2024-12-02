<?php

namespace App\Http\Controllers\Filter;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegionStoreRequest;
use App\Http\Requests\RegionUpdateRequest;
use App\Http\Resources\RegionCollection;
use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $regions = Region::query()->orderBy('title')->get();
        return response(new RegionCollection($regions), 200);
    }

    public function getRegionsInObjects(Request $request)
    {
        /*$regions = Region::whereHas('sportObject.cities', function ($query) {
            $query->where('verify', 1)->where('visible', 1);
        })->get();*/
//->distinct('regions.id')->pluck('regions.id', 'regions.title')

       // return response(new RegionCollection($regions), 200);
    }

    /**
     * @param \App\Http\Requests\RegionStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegionStoreRequest $request)
    {
        $region = Region::create($request->validated());

        $request->session()->flash('region.id', $region->id);

        return response()->json($region);
    }

    /**
     * @param \App\Http\Requests\RegionUpdateRequest $request
     * @param \App\Models\Region $region
     * @return \Illuminate\Http\Response
     */
    public function update(RegionUpdateRequest $request, Region $region)
    {
        $region->update($request->validated());

        $request->session()->flash('region.id', $region->id);

        return response()->json($region);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Region $region
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Region $region)
    {
        $region->delete();

        return response()->json($region);
    }
}

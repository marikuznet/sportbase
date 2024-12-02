<?php

namespace App\Http\Controllers\Filter;

use App\Http\Controllers\Controller;
use App\Http\Requests\CityStoreRequest;
use App\Http\Requests\CityUpdateRequest;
use App\Http\Requests\RegionStoreRequest;
use App\Http\Resources\CityCollection;
use App\Http\Resources\CityResource;
use App\Models\City;
use App\Models\Region;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CityController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return CityCollection|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cities = City::with("region")->orderBy('title')->get();
        return response(new CityCollection($cities), 200);
    }

    public function data(CityStoreRequest $request)
    {
        $city = City::create($request->validated());
        return new CityResource($city);
    }

    /**
     * @param \App\Http\Requests\CityStoreRequest $request
     * @return \App\Http\Resources\CityResource
     */
    public function store(CityStoreRequest $request)
    {
        $city = City::create($request->validated());
        return new CityResource($city);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\City $city
     * @return \App\Http\Resources\CityResource
     */
    public function show(Request $request, City $city)
    {
        return new CityResource($city);
    }

    /**
     * @param \App\Http\Requests\CityUpdateRequest $request
     * @param \App\Models\City $city
     * @return \App\Http\Resources\CityResource
     */
    public function update(CityUpdateRequest $request, City $city)
    {
        $city->update($request->validated());

        return new CityResource($city);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\City $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, City $city)
    {
        $city->delete();
        return response()->noContent();
    }

    public function newRegion(Request $request)
    {
        $country = Country::query()->where('title', $request['titleCountry'])->first();
        if ($country) {
            $idCountry = $country->id;
        } else {
            $newCountry = Country::create(['title' => $request['titleCountry']]);
            $idCountry = $newCountry->id;
        }


        $region = Region::query()->where('title', $request['titleRegion'])->first();
        if ($region) {
            $id = $region->id;
        } else {
            $newRegion = Region::create(['title' => $request['titleRegion'], 'country_id' => $idCountry]);
            $id = $newRegion->id;
        }

        $city = City::query()->where('title', $request['titleCity'])->first();
        if ($city) return $city;
        $newCity = City::create(['title' => $request['titleCity'], 'region_id' => $id]);
    }
}

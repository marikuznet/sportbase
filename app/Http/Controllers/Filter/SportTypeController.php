<?php

namespace App\Http\Controllers\Filter;

use App\Http\Controllers\Controller;
use App\Http\Requests\SportTypeStoreRequest;
use App\Http\Requests\SportTypeUpdateRequest;
use App\Http\Resources\SportTypeCollection;
use App\Http\Resources\SportTypeResource;
use App\Models\SportType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\DB;

class SportTypeController extends Controller
{
    public function index(Request $request)
    {
        $sportTypes = SportType::all();
        return response(SportTypeResource::collection($sportTypes), 200);
    }

    public function getSportTypesInObjects(Request $request)
    {
        $sportTypes = SportType::whereHas('sportObject', function ($q){
            $q->verify()->visible();
        })->orderBy('id')->get();

        return new SportTypeCollection($sportTypes);
    }

    /**
     * @param \App\Http\Requests\SportTypeStoreRequest $request
     * @return \App\Http\Resources\SportTypeResource
     */
    public function store(SportTypeStoreRequest $request)
    {
        $sportType = SportType::create($request->validated());
        return new SportTypeResource($sportType);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SportType $sportType
     * @return \App\Http\Resources\SportTypeResource
     */
    public function show(Request $request, SportType $sportType)
    {
        return new SportTypeResource($sportType);
    }

    /**
     * @param \App\Http\Requests\SportTypeUpdateRequest $request
     * @param \App\Models\SportType $sportType
     * @return SportTypeResource
     */
    public function update(SportTypeUpdateRequest $request, SportType $sportType)
    {
        $sportType->update($request->validated());
        return new SportTypeResource($sportType);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SportType $sportType
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, SportType $sportType)
    {
        $sportType->delete();
        return response()->noContent();
    }
}

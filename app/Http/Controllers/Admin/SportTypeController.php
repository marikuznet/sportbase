<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\SportTypeStoreRequest;
use App\Http\Requests\Admin\SportTypeUpdateRequest;
use App\Http\Resources\Admin\SportTypeCollection;
use App\Http\Resources\Admin\SportTypeResource;
use App\Models\Admin\SportType;
use Illuminate\Http\Request;

class SportTypeController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\SportTypeCollection
     */
    public function index(Request $request)
    {
        $sportTypes = SportType::all();

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
     * @return \App\Http\Resources\SportTypeResource
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

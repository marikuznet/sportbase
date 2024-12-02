<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\SportTypeAndObjectStoreRequest;
use App\Http\Requests\Admin\SportTypeAndObjectUpdateRequest;
use App\Http\Resources\Admin\SportTypeAndObjectCollection;
use App\Http\Resources\Admin\SportTypeAndObjectResource;
use App\Models\Admin\SportTypeAndObject;
use Illuminate\Http\Request;

class SportTypeAndObjectController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\SportTypeAndObjectCollection
     */
    public function index(Request $request)
    {
        $sportTypeAndObjects = SportTypeAndObject::all();

        return new SportTypeAndObjectCollection($sportTypeAndObjects);
    }

    /**
     * @param \App\Http\Requests\SportTypeAndObjectStoreRequest $request
     * @return \App\Http\Resources\SportTypeAndObjectResource
     */
    public function store(SportTypeAndObjectStoreRequest $request)
    {
        $sportTypeAndObject = SportTypeAndObject::create($request->validated());

        return new SportTypeAndObjectResource($sportTypeAndObject);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SportTypeAndObject $sportTypeAndObject
     * @return \App\Http\Resources\SportTypeAndObjectResource
     */
    public function show(Request $request, SportTypeAndObject $sportTypeAndObject)
    {
        return new SportTypeAndObjectResource($sportTypeAndObject);
    }

    /**
     * @param \App\Http\Requests\SportTypeAndObjectUpdateRequest $request
     * @param \App\Models\SportTypeAndObject $sportTypeAndObject
     * @return \App\Http\Resources\SportTypeAndObjectResource
     */
    public function update(SportTypeAndObjectUpdateRequest $request, SportTypeAndObject $sportTypeAndObject)
    {
        $sportTypeAndObject->update($request->validated());

        return new SportTypeAndObjectResource($sportTypeAndObject);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SportTypeAndObject $sportTypeAndObject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, SportTypeAndObject $sportTypeAndObject)
    {
        $sportTypeAndObject->delete();

        return response()->noContent();
    }
}

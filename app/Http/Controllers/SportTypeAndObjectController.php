<?php

namespace App\Http\Controllers;

use App\Http\Requests\SportTypeAndObjectStoreRequest;
use App\Http\Requests\SportTypeAndObjectUpdateRequest;
use App\Http\Resources\SportTypeAndObjectCollection;
use App\Http\Resources\SportTypeAndObjectResource;
use App\Models\SportTypeAndObject;
use Illuminate\Http\Request;

class SportTypeAndObjectController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return SportTypeAndObjectCollection
     */
    public function index(Request $request)
    {
        $sportTypeAndObjects = SportTypeAndObject::all();
        return new SportTypeAndObjectCollection($sportTypeAndObjects);
    }

    /**
     * @param \App\Http\Requests\SportTypeAndObjectStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SportTypeAndObjectStoreRequest $request)
    {
        $sportTypeAndObject = SportTypeAndObject::create($request->validated());

        $request->session()->flash('sportTypeAndObject.id', $sportTypeAndObject->id);

        return response()->json($sportTypeAndObject);
    }

    /**
     * @param \App\Http\Requests\SportTypeAndObjectUpdateRequest $request
     * @param \App\Models\SportTypeAndObject $sportTypeAndObject
     * @return \Illuminate\Http\Response
     */
    public function update(SportTypeAndObjectUpdateRequest $request, SportTypeAndObject $sportTypeAndObject)
    {
        $sportTypeAndObject->update($request->validated());

        $request->session()->flash('sportTypeAndObject.id', $sportTypeAndObject->id);

        return response()->json($sportTypeAndObject);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SportTypeAndObject $sportTypeAndObject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, SportTypeAndObject $sportTypeAndObject)
    {
        $sportTypeAndObject->delete();

        return response()->json($sportTypeAndObject);
    }
}

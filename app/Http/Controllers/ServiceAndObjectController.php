<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceAndObjectStoreRequest;
use App\Http\Requests\ServiceAndObjectUpdateRequest;
use App\Http\Resources\ServiceAndObjectResource;
use App\Models\ServiceAndObject;
use Illuminate\Http\Request;

class ServiceAndObjectController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $serviceAndObjects = ServiceAndObject::all();
        $array = [];
        foreach ($serviceAndObjects as $object)
        {
            array_push($array, ["obj" => new ServiceAndObjectResource($object)]);
        }
        return $array;
    }

    /**
     * @param \App\Http\Requests\ServiceAndObjectStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ServiceAndObjectStoreRequest $request)
    {
        $serviceAndObject = ServiceAndObject::create($request->validated());
        $request->session()->flash('serviceAndObject.id', $serviceAndObject->id);

        return response()->json($serviceAndObject);
    }

    /**
     * @param \App\Http\Requests\ServiceAndObjectUpdateRequest $request
     * @param \App\Models\ServiceAndObject $serviceAndObject
     * @return \Illuminate\Http\Response
     */
    public function update(ServiceAndObjectUpdateRequest $request, ServiceAndObject $serviceAndObject)
    {
        $serviceAndObject->update($request->validated());
        $request->session()->flash('serviceAndObject.id', $serviceAndObject->id);
        return response()->json($serviceAndObject);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ServiceAndObject $serviceAndObject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ServiceAndObject $serviceAndObject)
    {
        $serviceAndObject->delete();

        return response()->json($serviceAndObject);
    }
}

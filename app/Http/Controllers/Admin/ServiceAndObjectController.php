<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\ServiceAndObjectStoreRequest;
use App\Http\Requests\Admin\ServiceAndObjectUpdateRequest;
use App\Http\Resources\Admin\ServiceAndObjectCollection;
use App\Http\Resources\Admin\ServiceAndObjectResource;
use App\Models\Admin\ServiceAndObject;
use Illuminate\Http\Request;

class ServiceAndObjectController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\ServiceAndObjectCollection
     */
    public function index(Request $request)
    {
        $serviceAndObjects = ServiceAndObject::all();

        return new ServiceAndObjectCollection($serviceAndObjects);
    }

    /**
     * @param \App\Http\Requests\ServiceAndObjectStoreRequest $request
     * @return \App\Http\Resources\ServiceAndObjectResource
     */
    public function store(ServiceAndObjectStoreRequest $request)
    {
        $serviceAndObject = ServiceAndObject::create($request->validated());

        return new ServiceAndObjectResource($serviceAndObject);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ServiceAndObject $serviceAndObject
     * @return \App\Http\Resources\ServiceAndObjectResource
     */
    public function show(Request $request, ServiceAndObject $serviceAndObject)
    {
        return new ServiceAndObjectResource($serviceAndObject);
    }

    /**
     * @param \App\Http\Requests\ServiceAndObjectUpdateRequest $request
     * @param \App\Models\ServiceAndObject $serviceAndObject
     * @return \App\Http\Resources\ServiceAndObjectResource
     */
    public function update(ServiceAndObjectUpdateRequest $request, ServiceAndObject $serviceAndObject)
    {
        $serviceAndObject->update($request->validated());

        return new ServiceAndObjectResource($serviceAndObject);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ServiceAndObject $serviceAndObject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ServiceAndObject $serviceAndObject)
    {
        $serviceAndObject->delete();

        return response()->noContent();
    }
}

<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\ObjectTypeStoreRequest;
use App\Http\Requests\Admin\ObjectTypeUpdateRequest;
use App\Http\Resources\Admin\ObjectTypeCollection;
use App\Http\Resources\Admin\ObjectTypeResource;
use App\Models\Admin\ObjectType;
use Illuminate\Http\Request;

class ObjectTypeController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\ObjectTypeCollection
     */
    public function index(Request $request)
    {
        $objectTypes = ObjectType::all();

        return new ObjectTypeCollection($objectTypes);
    }

    /**
     * @param \App\Http\Requests\ObjectTypeStoreRequest $request
     * @return \App\Http\Resources\ObjectTypeResource
     */
    public function store(ObjectTypeStoreRequest $request)
    {
        $objectType = ObjectType::create($request->validated());

        return new ObjectTypeResource($objectType);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ObjectType $objectType
     * @return \App\Http\Resources\ObjectTypeResource
     */
    public function show(Request $request, ObjectType $objectType)
    {
        return new ObjectTypeResource($objectType);
    }

    /**
     * @param \App\Http\Requests\ObjectTypeUpdateRequest $request
     * @param \App\Models\ObjectType $objectType
     * @return \App\Http\Resources\ObjectTypeResource
     */
    public function update(ObjectTypeUpdateRequest $request, ObjectType $objectType)
    {
        $objectType->update($request->validated());

        return new ObjectTypeResource($objectType);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ObjectType $objectType
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ObjectType $objectType)
    {
        $objectType->delete();

        return response()->noContent();
    }
}

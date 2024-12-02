<?php

namespace App\Http\Controllers;

use App\Http\Requests\ObjectTypeStoreRequest;
use App\Http\Requests\ObjectTypeUpdateRequest;
use App\Http\Resources\ObjectTypeResource;
use App\Models\ObjectType;
use Illuminate\Http\Request;

class ObjectTypeController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return ObjectType[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $types = ObjectType::all();
        $array = [];
        foreach ($types as $object)
            array_push($array, new ObjectTypeResource($object));
        return $array;
    }

    /**
     * @param \App\Http\Requests\ObjectTypeStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ObjectTypeStoreRequest $request)
    {
        $objectType = ObjectType::create($request->validated());

        $request->session()->flash('objectType.id', $objectType->id);

        return response()->json($objectType);
    }

    /**
     * @param \App\Http\Requests\ObjectTypeUpdateRequest $request
     * @param \App\Models\ObjectType $objectType
     * @return \Illuminate\Http\Response
     */
    public function update(ObjectTypeUpdateRequest $request, ObjectType $objectType)
    {
        $objectType->update($request->validated());

        $request->session()->flash('objectType.id', $objectType->id);

        return response()->json($objectType);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ObjectType $objectType
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ObjectType $objectType)
    {
        $objectType->delete();

        return response()->json($objectType);
    }
}

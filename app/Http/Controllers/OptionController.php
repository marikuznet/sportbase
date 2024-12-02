<?php

namespace App\Http\Controllers;

use App\Http\Requests\OptionStoreRequest;
use App\Http\Requests\OptionUpdateRequest;
use App\Http\Resources\OptionCollection;
use App\Http\Resources\OptionResource;
use App\Models\Option;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function index(Request $request)
    {
        $options = Option::get();
        $array = [];
        foreach ($options as $option)
            array_push($array, new OptionResource($option));
        return $array;
    }
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function show(Request $request, $id)
    {
        $options = Option::where('infrastructure_id', $id)->get();
        $array = [];
        foreach ($options as $option)
        {
            array_push($array, ["option" => new OptionResource($option)]);
        }
        return $array;
    }

    /**
     * @param \App\Http\Requests\OptionStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(OptionStoreRequest $request)
    {
        $option = Option::create($request->validated());
        $request->session()->flash('option.id', $option->id);
        return response()->json($option);
    }

    /**
     * @param \App\Http\Requests\OptionUpdateRequest $request
     * @param \App\Models\Option $option
     * @return \Illuminate\Http\Response
     */
    public function update(OptionUpdateRequest $request, Option $option)
    {
        $option->update($request->validated());

        $request->session()->flash('option.id', $option->id);

        return response()->json($option);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Option $option
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Option $option)
    {
        $option->delete();

        return response()->json($option);
    }
}

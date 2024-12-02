<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\OptionStoreRequest;
use App\Http\Requests\Admin\OptionUpdateRequest;
use App\Http\Resources\Admin\OptionCollection;
use App\Http\Resources\Admin\OptionResource;
use App\Models\Admin\Option;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\OptionCollection
     */
    public function index(Request $request)
    {
        $options = Option::all();

        return new OptionCollection($options);
    }

    /**
     * @param \App\Http\Requests\OptionStoreRequest $request
     * @return \App\Http\Resources\OptionResource
     */
    public function store(OptionStoreRequest $request)
    {
        $option = Option::create($request->validated());

        return new OptionResource($option);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Option $option
     * @return \App\Http\Resources\OptionResource
     */
    public function show(Request $request, Option $option)
    {
        return new OptionResource($option);
    }

    /**
     * @param \App\Http\Requests\OptionUpdateRequest $request
     * @param \App\Models\Option $option
     * @return \App\Http\Resources\OptionResource
     */
    public function update(OptionUpdateRequest $request, Option $option)
    {
        $option->update($request->validated());

        return new OptionResource($option);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Option $option
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Option $option)
    {
        $option->delete();

        return response()->noContent();
    }
}

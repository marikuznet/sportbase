<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\InfrastructureStoreRequest;
use App\Http\Requests\Admin\InfrastructureUpdateRequest;
use App\Http\Resources\Admin\InfrastructureCollection;
use App\Http\Resources\Admin\InfrastructureResource;
use App\Models\Admin\Infrastructure;
use Illuminate\Http\Request;

class InfrastructureController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\InfrastructureCollection
     */
    public function index(Request $request)
    {
        $infrastructures = Infrastructure::all();

        return new InfrastructureCollection($infrastructures);
    }

    /**
     * @param \App\Http\Requests\InfrastructureStoreRequest $request
     * @return \App\Http\Resources\InfrastructureResource
     */
    public function store(InfrastructureStoreRequest $request)
    {
        $infrastructure = Infrastructure::create($request->validated());

        return new InfrastructureResource($infrastructure);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Infrastructure $infrastructure
     * @return \App\Http\Resources\InfrastructureResource
     */
    public function show(Request $request, Infrastructure $infrastructure)
    {
        return new InfrastructureResource($infrastructure);
    }

    /**
     * @param \App\Http\Requests\InfrastructureUpdateRequest $request
     * @param \App\Models\Infrastructure $infrastructure
     * @return \App\Http\Resources\InfrastructureResource
     */
    public function update(InfrastructureUpdateRequest $request, Infrastructure $infrastructure)
    {
        $infrastructure->update($request->validated());

        return new InfrastructureResource($infrastructure);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Infrastructure $infrastructure
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Infrastructure $infrastructure)
    {
        $infrastructure->delete();

        return response()->noContent();
    }
}

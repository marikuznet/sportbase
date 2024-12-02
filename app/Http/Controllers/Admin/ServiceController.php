<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\ServiceStoreRequest;
use App\Http\Requests\Admin\ServiceUpdateRequest;
use App\Http\Resources\Admin\ServiceCollection;
use App\Http\Resources\Admin\ServiceResource;
use App\Models\Admin\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\ServiceCollection
     */
    public function index(Request $request)
    {
        $services = Service::all();

        return new ServiceCollection($services);
    }

    /**
     * @param \App\Http\Requests\ServiceStoreRequest $request
     * @return \App\Http\Resources\ServiceResource
     */
    public function store(ServiceStoreRequest $request)
    {
        $service = Service::create($request->validated());

        return new ServiceResource($service);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Service $service
     * @return \App\Http\Resources\ServiceResource
     */
    public function show(Request $request, Service $service)
    {
        return new ServiceResource($service);
    }

    /**
     * @param \App\Http\Requests\ServiceUpdateRequest $request
     * @param \App\Models\Service $service
     * @return \App\Http\Resources\ServiceResource
     */
    public function update(ServiceUpdateRequest $request, Service $service)
    {
        $service->update($request->validated());

        return new ServiceResource($service);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Service $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Service $service)
    {
        $service->delete();

        return response()->noContent();
    }
}

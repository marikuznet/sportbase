<?php

namespace App\Http\Controllers;

use App\Http\Requests\InfrastructureStoreRequest;
use App\Http\Requests\InfrastructureUpdateRequest;
use App\Http\Resources\InfrastructureCollection;
use App\Http\Resources\InfrastructureResource;
use App\Models\Infrastructure;
use Illuminate\Http\Request;

class InfrastructureController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $infrastructures = Infrastructure::all();
        return new InfrastructureCollection($infrastructures);
    }

    public function getInfrastructuresInObjects()
    {
        $infrastructures = Infrastructure::whereHas('sportObjects', function ($q) {
            $q->verify()->visible();
        })->distinct('title')->pluck('title')->toArray();

        return $infrastructures;
    }

    /**
     * @param \App\Http\Requests\InfrastructureStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(InfrastructureStoreRequest $request)
    {
        $infrastructure = Infrastructure::create($request->validated());

        $request->session()->flash('infrastructure.id', $infrastructure->id);

        return response()->json($infrastructure);
    }

    /**
     * @param \App\Http\Requests\InfrastructureUpdateRequest $request
     * @param \App\Models\Infrastructure $infrastructure
     * @return \Illuminate\Http\Response
     */
    public function update(InfrastructureUpdateRequest $request, Infrastructure $infrastructure)
    {
        $infrastructure->update($request->validated());

        $request->session()->flash('infrastructure.id', $infrastructure->id);

        return response()->json($infrastructure);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Infrastructure $infrastructure
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Infrastructure $infrastructure)
    {
        $infrastructure->delete();

        return response()->json($infrastructure);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\SportObjectStoreRequest;
use App\Http\Requests\Admin\SportObjectUpdateRequest;
use App\Http\Resources\Admin\CustomSportObjectResource;
use App\Http\Resources\Admin\SportObjectAddressResource;
use App\Http\Resources\Admin\SportObjectCollection;
use App\Http\Resources\Admin\SportObjectResource;
use App\Models\SportObject;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class SportObjectController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $sportObjects = SportObject::query()->with(['advertisements' => function ($query) {
         /*   $query->where(function ($q){
                $q->whereNull('date_end')
                    ->orWhere('date_end', '<', now()->toDateString());
            })->where('paused', 0);*/
        }])->get();
        return CustomSportObjectResource::collection($sportObjects);
    }

    public function statistic()
    {
        $data = [
            'checkinSportObjectsCount' => SportObject::where('verify', '=', 0)->count(),
            'checkedSportObjectsCount' => SportObject::query()->where('verify', '=', 1)->count()
        ];
        return response($data, 200);
    }

    /**
     * @param SportObjectStoreRequest $request
     * @return SportObjectResource
     */
    public function store(SportObjectStoreRequest $request)
    {
        $sportObject = SportObject::create($request->validated());

        return new SportObjectResource($sportObject);
    }

    /**
     * @param Request $request
     * @param SportObject $sportObject
     * @return \App\Http\Resources\SportObjectResource|Application|Factory|View
     */
    public function show(SportObject $sportObject)
    {
        $object_data = json_encode(new SportObjectResource($sportObject));
        return view('adminPanel.sportObject.showObject', compact('object_data'));
    }

    /**
     * @param Request $request
     * @param SportObject $sportObject
     */
    public function showAdminObject($id)
    {
        return view('adminPanel.sportObject.admin_create_object', compact('id'));
        //return view('adminPanel.sportObject.editObject', compact('object_data'));
    }

    public function edit($id)
    {
        return view('adminPanel.sportObject.admin_create_object', compact('id'));
        //return view('adminPanel.sportObject.editObject', compact('object_data'));
    }

    public function getSportObjectId($id)
    {
        return new SportObjectResource(SportObject::query()->findOrFail($id));
    }

    /**
     * @param SportObjectUpdateRequest $request
     * @param SportObject $sportObject
     * @return SportObjectResource
     */
    public function update(SportObjectUpdateRequest $request, SportObject $sportObject)
    {
        $sportObject->update($request->validated());

        return new SportObjectResource($sportObject);
    }

    /**
     * @param Request $request
     * @param SportObject $sportObject
     * @return Response
     */
    public function destroy(Request $request, SportObject $sportObject)
    {
        $sportObject->delete();

        return response()->noContent();
    }

    public function getAddressesSportObjects()
    {
        $sportObjects = SportObject::query()->where('verify', 1)->get();
        return SportObjectAddressResource::collection($sportObjects);
    }
}

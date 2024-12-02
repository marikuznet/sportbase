<?php

namespace App\Http\Controllers\DirectApplications;

use App\Http\Controllers\Controller;
use App\Http\Resources\Profile\Direct\DirectRequestProfileCollection;
use App\Models\DirectApplications;
use Illuminate\Http\Request;

class DirectApplicationsController extends Controller
{
    public function getApplicationsForProfile(Request $request)
    {
        $filters = (object)[
            'limit' => $request->input('limit'),
            'page' => $request->input('page'),
            'status' => $request->input('status'),
        ];

        $directs = DirectApplications::hasUser()
            ->when($filters->status === 'active', function ($query) {
                $query->active();
            })
            ->when($filters->status === 'archive', function ($query) {
                $query->archive();
            })
            ->withFiltersToProfile((object)$request->input('filter'))
            ->orderByDesc('created_at')
            ->paginate($filters->limit, ['*'], 'page', $filters->page);

        return new DirectRequestProfileCollection($directs);
    }

    private function getIdsRelated($request)
    {
        $typeSportsIds = array_map(function ($item) {
            return $item['id'];
        }, $request->type_sports);
        $typeFoodsIds = array_map(function ($item) {
            return $item['id'];
        }, $request->typeFoods);
        $additionsIds = array_map(function ($item) {
            return $item['id'];
        }, $request->additionsTender);
        $infrastructuresIds = array_map(function ($item) {
            return $item['id'];
        }, $request->infrastructures);

        return new Request(['type_sports' => $typeSportsIds, 'typeFoods' => $typeFoodsIds,
            'additionsTender' => $additionsIds, 'infrastructures' => $infrastructuresIds]);
    }

    private function syncRelatedModels($direct, $request)
    {
        $direct->infrastructures()->sync($request->infrastructures);
        $direct->additions()->sync($request->additionsTender);
        $direct->foods()->sync($request->typeFoods);
        $direct->sports()->sync($request->type_sports);
    }

    public function store(Request $request)
    {
        $direct = DirectApplications::create($request->all());
        $dataIds = $this->getIdsRelated($request);
        $this->syncRelatedModels($direct, $dataIds);

        return response()->json(null, 200);
    }

    public function update(Request $request, $id)
    {
        $direct = DirectApplications::findOrFail($id);
        $direct->update($request->all());
        $dataIds = $this->getIdsRelated($request);
        $this->syncRelatedModels($direct, $dataIds);

        return response()->json(null, 200);
    }

    public function addDirectApplicationsArchive(Request $request)
    {
        $directApplication = DirectApplications::findOrFail($request->id);
        $directApplication->archive = $request->user_role;
        $directApplication->save();

        return $directApplication;
    }

    public function destroy($id)
    {
        DirectApplications::destroy($id);
        return response()->json(null, 200);
    }
}

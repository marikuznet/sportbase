<?php

namespace App\Http\Controllers\Tender;

use App\Http\Controllers\Controller;
use App\Http\Resources\Tender\ResponsesTenderResourse;
use App\Http\Resources\Tender\TenderResponseUserCollection;
use App\Http\Resources\Tender\TenderResponseUserResource;
use App\Models\Tender\ResponsesTender;
use App\Models\Tender\ResponsesTenderAndTenders;
use App\Models\Tender\Tender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResponsesTenderController extends Controller
{
    public function getResponses(Request $request)
    {
        $filters = (object)[
            'limit' => $request['limit'] ?? 10,
            'page' => $request['page'] ?? 1,
            'status' => $request['status'] ?? 'active',
            'filter' => (object)$request['filter']
        ];

        $group_responses = [];
        if ($filters->status === 'active') {
            $group_responses = Tender::with(['responses' => function ($query) use ($filters) {
                $query->active()->hasUser()->withFiltersToResponsesTender($filters->filter);
            }])->whereHas('responses', function ($q) use ($filters) {
                $q->active()->hasUser()->withFiltersToResponsesTender($filters->filter);
            })->orderByDesc('created_at');
        } elseif ($filters->status === 'archive') {
            $group_responses = Tender::with(['responses' => function ($query) use ($filters) {
                // $query->hasUser()->archive()->withFiltersToResponsesTender($filters->filter);
            }])->whereHas('responses', function ($q) use ($filters) {
                $q->hasUser()->archive()->withFiltersToResponsesTender($filters->filter);
            })->orderByDesc('created_at');
        }

        $responses = $group_responses->paginate($filters->limit, ['*'], 'page', $filters->page);
        return new TenderResponseUserCollection($responses);
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

    private function syncRelatedModels($responseTender, $request)
    {
        $responseTender->infrastructures()->sync($request->infrastructures);
        $responseTender->additions()->sync($request->additionsTender);
        $responseTender->foods()->sync($request->typeFoods);
        $responseTender->sports()->sync($request->type_sports);
    }

    public function store(Request $request)
    {
        $requestData = $request->only([
            'dateResponse', 'infoCompany_id', 'sportObject_id', 'city_id', 'colPeople',
            'startDate', 'endDate', 'spreadDate', 'priceForPerson', 'minPrice', 'accred',
            'createDate', 'user_id', 'comment'
        ]);

        $responseTender = ResponsesTender::create($requestData);
        $dataIds = $this->getIdsRelated($request);
        $this->syncRelatedModels($responseTender, $dataIds);

        $responseTender->tenders()->attach($request->tender_id);

        return response()->json($responseTender, 200);
    }

    public function update(Request $request)
    {
        $response = ResponsesTender::findOrFail($request->id);

        $requestData = $request->only([
            'dateResponse', 'infoCompany_id', 'sportObject_id', 'city_id', 'colPeople',
            'startDate', 'endDate', 'spreadDate', 'priceForPerson', 'minPrice', 'accred',
            'createDate', 'user_id', 'comment'
        ]);

        $response->update($requestData);
        $dataIds = $this->getIdsRelated($request);
        $this->syncRelatedModels($response, $dataIds);

        return response()->json($response);
    }

    public function delete(Request $request)
    {
        $response = ResponsesTender::query()->findOrFail($request['id']);
        if ($response) {
            $response->archive = Auth::user()->role;
            $response->save();
        }
        return response()->noContent();
    }
}

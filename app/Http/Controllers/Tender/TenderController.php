<?php

namespace App\Http\Controllers\Tender;

use App\Http\Controllers\Controller;
use App\Http\Resources\Tender\TenderCollection;
use App\Http\Resources\Tender\TenderPageCollection;
use App\Models\Tender\ResponsesTender;
use App\Models\Tender\Tender;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TenderController extends Controller
{
    public function index(Request $request)
    {
        $filters = (object) [
            'limit' => $request->input('limit', 10),
            'sort' => $request->input('sort', 'new:desc'),
            'page' => $request->input('page', 1),
        ];

        $tenders = Tender::query()
            ->with(['infoCompany', 'city', 'responses', 'deal'])
            ->active()
            ->withSort((object)$request->filter)
            ->withFilters((object)$request->filter)
            ->paginate($filters->limit, ['*'], 'page', $filters->page);

        return response(new TenderPageCollection($tenders), 200);
    }

    public function getMyTenders(Request $request): TenderCollection
    {
        $filters = (object) [
            'limit' => $request->input('limit'),
            'page' => $request->input('page'),
            'status' => $request->input('status'),
        ];

        $tenders = Tender::query()
            ->hasUser()
            ->when($filters->status, function ($query, $status) {
                if ($status === 'active') {
                    $query->active();
                } elseif ($status === 'archive') {
                    $query->archive();
                }
            })
            ->withFiltersToApplicationsTender((object)$request->filter)
            ->with(['infoCompany', 'city', 'responses', 'deal'])
            ->orderBy('id', 'desc')
            ->paginate($filters->limit, ['*'], 'page', $filters->page);

        return new TenderCollection($tenders);
    }

    public function addTenderArchive(Request $request)
    {
        $tender = Tender::find($request->id);

        if ($tender) {
            foreach ($tender->responses as $response) {
                if (!in_array($response->archive, [Tender::STATUS_REJECTED_CUSTOMER, Tender::STATUS_REJECTED_EXECUTOR])) {
                    $response->archive = $request->user_role;
                    $response->save();
                }
            }

            $tender->archive = $request->user_role;
            $tender->date_cancel = Carbon::now();
            $tender->save();
        }

        return response()->json($tender);
    }

    public function rejectAllResponses($tenderId): string
    {
        ResponsesTender::query()
            ->whereHas('tender', function ($query) use ($tenderId) {
                $query->where('id', $tenderId)->where('archive', 0);
            })
            ->update(['archive' => Auth::user()->role]);

        return "success";
    }

    private function extractIds(array $items): array
    {
        return array_column($items, 'id');
    }

    private function getIdsRelated(Request $request): array
    {
        return [
            'type_sports' => $this->extractIds($request->type_sports),
            'typeFoods' => $this->extractIds($request->typeFoods),
            'additionsTender' => $this->extractIds($request->additionsTender),
            'infrastructures' => $this->extractIds($request->infrastructures),
        ];
    }

    public function store(Request $request)
    {
        $requestData = $request->only([
            'infoCompany_id', 'city_id', 'colPeople', 'startDate',
            'endDate', 'spreadDate', 'priceForPerson', 'minPrice',
            'accred', 'createDate', 'user_id', 'comment',
        ]);

        $tender = Tender::create($requestData);
        $dataIds = $this->getIdsRelated($request);
        $this->syncRelatedModels($tender, $dataIds);

        return response()->json($tender, 200);
    }

    public function update(Request $request, $id)
    {
        $tender = Tender::findOrFail($id);

        $requestData = $request->only([
            'city_id', 'colPeople', 'startDate', 'endDate',
            'spreadDate', 'priceForPerson', 'minPrice',
            'accred', 'createDate', 'comment',
        ]);

        $tender->update($requestData);
        $dataIds = $this->getIdsRelated($request);
        $this->syncRelatedModels($tender, $dataIds);

        return response()->json($tender, 200);
    }

    private function syncRelatedModels(Tender $tender, array $dataIds)
    {
        $tender->infrastructures()->sync($dataIds['infrastructures']);
        $tender->additions()->sync($dataIds['additionsTender']);
        $tender->foods()->sync($dataIds['typeFoods']);
        $tender->sports()->sync($dataIds['type_sports']);
    }
}

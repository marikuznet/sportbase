<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\AdminTenderApplicationsResource;
use App\Http\Resources\Tender\TenderCollection;
use App\Http\Resources\Tender\TenderPageCollection;
use App\Http\Resources\Tender\TenderResource;
use App\Models\Tender\Tender;
use Illuminate\Http\Request;

class TenderController extends Controller
{
    public function index(Request $request)
    {
        $tenders = Tender::with('deal.responsesTender', 'deal.responsesTender.infoCompany')->get();
        return AdminTenderApplicationsResource::collection($tenders);
    }

    public function getTenderById($id)
    {
        $tender = Tender::query()->findOrFail($id);
        return response(new TenderResource($tender));
    }

    public function update(Request $request, $id)
    {
        $tender = Tender::findOrFail($id);

        $typeSportsIds = array_map(function ($item) {
            return $item['id'];
        }, $request->type_sports);
        $typeFoodsIds = array_map(function ($item) {
            return $item['id'];
        }, $request->typeFoods);
        $additionsIds = array_map(function ($item) {
            return $item['id'];
        }, $request->additionsTender);

        $tender->update([
            'infoCompany_id' => $request->get('infoCompany_id'),
            'infrastructures' => json_encode($request->get('infrastructures'), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            'city_id' => $request->get('city_id'),
            'colPeople' => $request->get('colPeople'),
            'startDate' => $request->get('startDate'),
            'endDate' => $request->get('endDate'),
            'spreadDate' => $request->get('spreadDate'),
            'priceForPerson' => $request->get('priceForPerson'),
            'minPrice' => $request->get('minPrice'),
            'accred' => $request->get('accred'),
            'createDate' => $request->get('createDate'),
            'comment' => $request->get('comment'),
        ]);

        $tender->additions()->sync($additionsIds);
        $tender->foods()->sync($typeFoodsIds);
        $tender->sports()->sync($typeSportsIds);

        return $request->all();
    }
}

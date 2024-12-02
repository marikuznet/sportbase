<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Deal\Deal;
use App\Models\DirectApplications;
use App\Models\Estimate;
use App\Models\Infrastructure;
use App\Models\Message;
use App\Models\Region;
use App\Models\Service;
use App\Models\SportObject;
use App\Models\SportType;
use App\Models\Tender\AdditionTender;
use App\Models\Tender\RequirementInfrastructures;
use App\Models\Tender\ResponsesTender;
use App\Models\Tender\Tender;
use App\Models\Tender\TypeFood;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FilterController extends Controller
{
    public function getFilters(): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $sportObjects = SportObject::query()->verify()->visible()->select(['id', 'title'])->get()->toArray();
        array_unshift($sportObjects, ['id' => null, 'title' => 'Любой']);

        $foods = TypeFood::query()->select(['id', 'title'])->get()->toArray();
        array_unshift($foods, ['id' => null, 'title' => 'Любое']);

        /*$services = Service::query()->whereHas('sportObject', function ($q) {
            $q->verify()->visible();
        })->select(['id', 'title'])->get()->toArray();*/
        $services = AdditionTender::query()->select(['id', 'title'])->get()->toArray();
        array_unshift($services, ['id' => null, 'title' => 'Любые']);

        /*$infrastructures = Infrastructure::query()->whereHas('sportObjects', function ($query) {
            $query->verify()->visible();
        })->distinct('title')->pluck('title')->toArray();*/

        $infrastructures = RequirementInfrastructures::query()->select(['id', 'title'])->get()->toArray();

        array_unshift($infrastructures, 'Любая');

        $data = [
            'object' => $sportObjects,
            'food' => $foods,
            'services' => $services,
            'infrastructures' => $infrastructures,
        ];
        return response($data, 200);
    }

    public function getFiltersForSportObjects()
    {
        $sports = SportType::query()->select(['id', 'title'])->orderBy('title')->get()->toArray();
        /*$infrastructures = Infrastructure::query()->whereHas('sportObjects', function ($query) {
            $query->verify()->visible();
        })->distinct('title')->pluck('title')->toArray();*/
        $infrastructures = RequirementInfrastructures::query()->distinct('title')->pluck('title')->toArray();
        $regions = Region::query()->select(['id', 'title'])->orderBy('title')->get()->toArray();
        $services = Service::query()->select(['id', 'title'])->get()->toArray();

        $data = [
            'sports' => $sports,
            'regions' => $regions,
            'services' => $services,
            'infrastructures' => $infrastructures,
        ];
        return response()->json($data);
    }

    public function getDataResponseRequest(): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $typeSports = SportType::query()->select(['id', 'title'])->get()->toArray();
        $cities = City::query()->select(['id', 'title'])->orderBy('title')->get()->toArray();
        /*$infrastructures = Infrastructure::query()->whereHas('sportObjects', function ($query) {
            $query->verify()->visible();
        })->distinct('title')->pluck('title')->toArray();*/
        $typeFoods = TypeFood::query()->select(['id', 'title'])->get()->toArray();
        $additions = AdditionTender::query()->select(['id', 'title'])->get()->toArray();

        $data = [
            'typeSports' => $typeSports,
            //'infrastructures' => $infrastructures,
            'cities' => $cities,
            'typeFoods' => $typeFoods,
            'additions' => $additions,
        ];
        return response($data, 200);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertisment\AdvertismentOrders;
use App\Models\Deal\Deal;
use App\Models\Estimate;
use App\Models\SportObject;
use App\Models\User;

class StatisticController extends Controller
{
    public function getStatisticByMain()
    {
        $data = [
            'customersCount' => User::where('role', '=', 2)->count(),
            'executorsCount' => User::where('role', '=', 3)->count(),
            'objectsCount' => SportObject::count(),
            'dealsCount' => Deal::hasSportObject()->count()
        ];
        return response($data, 200);
    }

    /**
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function getStatisticByUsers(): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $data = [
            'customersCount' => User::where('role', '=', 2)->count(),
            'executorsCount' => User::where('role', '=', 3)->count(),
            'verifyCustomersCount' => User::where([['status', '=', 10], ['role', '=', 2]])->count(),
            'verifyExecutorsCount' => User::where([['status', '=', 10], ['role', '=', 3]])->count(),
            'blockCustomersCount' => User::where([['block', '=', 1], ['role', '=', 2]])->count(),
            'blockExecutorsCount' => User::where([['block', '=', 1], ['role', '=', 3]])->count()
        ];
        return response($data, 200);
    }

    public function getStatisticByFinance()
    {
        $data = [
            'estimatesCount' => Estimate::query()->with('deal')->hasDeal()->hasRequest()->groupBy('deal_id')
                ->orderBy('deal_id', 'desc')->count(),
            'paymentAdvertisementCount' => AdvertismentOrders::count(),
            'paymentPerformers' => Estimate::query()
                ->where(function ($query) {
                    $query->where('status', 3)
                        ->orWhere('status', 5);
                })
                ->whereHas('deal', function ($query) {
                    $query->where('complete', 1)
                        ->orWhere('complete', 2);
                })
                ->get()
                ->count()
        ];
        return response($data, 200);
    }

    public function getStatisticByIncomeFinance()
    {
        //TODO: Здесь поправить статистику для финансов
        $data = [
            'all_money' => 0,
            'money_advertisements' => AdvertismentOrders::query()->sum('amount'),
            'money_deals' => 0,
            'paid_executor' => $this->getTotalBalance()
        ];
        return response()->json($data, 200);
    }

    public function getAllBalances()
    {
        $balances = Estimate::query()
            ->selectRaw('SUM(`estimates`.sum) AS `sum_user`, sport_objects.user_id')
            ->join('sport_objects', 'estimates.sportObject_id', '=', 'sport_objects.id')
            ->groupBy('sport_objects.user_id')
            ->get();

        return $balances;
    }

    public function getTotalBalance()
    {
        $allBalances = $this->getAllBalances();
        return $allBalances->sum('sum_user');
    }

}

<?php

namespace App\Http\Controllers;

use App\Http\Resources\Deal\OrderCollection;
use App\Http\Resources\UserEstimateCollection;
use App\Http\Resources\OrderUserCollection;
use App\Models\Deal\Deal;
use App\Models\Estimate;
use Illuminate\Http\Request;

class OrdersAndPaymentsController extends Controller
{
    public function getActiveOrders(Request $request)
    {
        $deals = Deal::query()->hasUser()
            ->withFilters((object)$request->filter)
            ->active()
            ->orderBy('created_at', 'desc')
            ->get();
        return response(new OrderUserCollection($deals), 200);
    }

    public function getFinishedOrders(Request $request)
    {
        $deals = Deal::query()->hasUser()
            ->withFilters((object)$request->filter)
            ->finish()
            ->orderBy('created_at', 'desc')
            ->get();
        return response(new OrderUserCollection($deals), 200);
    }

    public function getOrders(Request $request)
    {
        $filters = (object)[
            'status' => $request['status'] ?? 'orders',
            'limit' => $request['limit'] ?? 10,
            'page' => $request['page'] ?? 1,
        ];

        $deals = Deal::query()->hasUser()
            ->withFilters((object)$request->filter)
            ->orderBy('created_at', 'desc')
            ->paginate($filters->limit, ['*'], 'page', $filters->page);
        return response(new OrderCollection($deals), 200);
    }

    public function getEstimates(Request $request)
    {
        $filters = (object)[
            'status' => $request['status'] ?? 'orders',
            'limit' => $request['limit'] ?? 10,
            'page' => $request['page'] ?? 1,
        ];

        $estimate = Estimate::hasUser()->lastEstimate()->paginate($filters->limit, ['*'], 'page', $filters->page);
        return new UserEstimateCollection($estimate);
        //  $deals = $deals->withFilters((object)$request->filter)->paginate($filters->limit, ['*'], 'page', $filters->page);
        //return response(new OrderCollection($deals), 200);
    }

    public function getPayments(Request $request)
    {
        $filters = (object)[
            'status' => $request['status'] ?? 'orders',
            'limit' => $request['limit'] ?? 10,
            'page' => $request['page'] ?? 1,
        ];

        $payments = Estimate::all();

        return $payments;
    }
}

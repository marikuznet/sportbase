<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Resources\Admin\BillsResource;
use App\Http\Resources\Admin\Estimates\PaymentEstimatesCollection;
use App\Models\Estimate;
use Illuminate\Support\Facades\DB;

class EstimateController extends Controller
{
    public function index()
    {
        $estimates = Estimate::query()->hasRequest()->orderByDesc('created_at')->get();
        return BillsResource::collection($estimates);
    }

    public function getPayments()
    {
        $subQuery = Estimate::selectRaw('MAX(created_at) as latest_date, deal_id')
            ->groupBy('deal_id');

        $latestEstimates = Estimate::select('id', 'deal_id')
            ->whereIn(DB::raw('(created_at, deal_id)'), function ($query) use ($subQuery) {
                $query->select(DB::raw('created_at, deal_id'))
                    ->fromSub($subQuery, 'latest_estimates');
            });

        $payments = Estimate::with('deal')
            ->hasDeal()
            ->where('date_send_customer', '!=', null)
            ->whereNotIn('status', [0, Estimate::ESTIMATE_NOTIF_PAYMENT])
            ->whereIn('id', function ($query) use ($latestEstimates) {
                $query->select('id')
                    ->fromSub($latestEstimates, 'latest_estimates');
            })
            ->orderBy('created_at')
            ->get();

        $groupedPayments = $payments->groupBy('deal_id');

        $groupedPayments->each(function ($group) {
            $orderNumber = 1;

            foreach ($group as $estimate) {
                $estimate->order_number = $orderNumber++;
            }
        });
        $groupedPayments->transform(function ($group) {
            $maxOrderNumber = $group->max('order_number');
            return $group->filter(function ($estimate) use ($maxOrderNumber) {
                return $estimate->order_number === $maxOrderNumber;
            });
        });

        $payments = $groupedPayments->collapse()->sortByDesc('created_at')->values();
        return new PaymentEstimatesCollection($payments);
    }
}

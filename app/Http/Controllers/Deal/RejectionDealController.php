<?php

namespace App\Http\Controllers\Deal;

use App\Http\Controllers\Controller;
use App\Http\Resources\Deal\DealResource;
use App\Models\Deal\Deal;
use App\Models\Deal\RejectionDeal;
use App\Models\Tender\ResponsesTender;
use App\Models\Tender\Tender;
use Illuminate\Http\Request;

class RejectionDealController extends Controller
{
    public function index(Request $request)
    {
        $rejectionsDeal = RejectionDeal::all();
        return $rejectionsDeal;
    }

    public function store(Request $request)
    {
        $deal = Deal::create([
            'tender_id' => $request->tender_id,
            'responsesTender_id' => $request->responsesTender_id,
        ]);
        $response = ResponsesTender::find($request->responsesTender_id);
        $response->archive = 1;
        $response->save();

        $tender = Tender::find($request->tender_id);
        $tender->archive = 1;
        $tender->save();
        return response()->json('success', 200);
    }
}

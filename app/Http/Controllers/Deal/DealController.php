<?php

namespace App\Http\Controllers\Deal;

use App\Http\Controllers\Controller;
use App\Http\Resources\Deal\DealDirectResource;
use App\Http\Resources\Deal\DealResource;
use App\Models\Deal\Deal;
use App\Models\DirectApplications;
use App\Models\Tender\ResponsesTender;
use App\Models\Tender\Tender;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DealController extends Controller
{
    public function getDeal(Request $request, $id)
    {
        $deal = Deal::with('tender', 'direct')->find($id);
        if ($deal) {
            if ($deal->tender()->exists()) {
                return new DealResource($deal);
            } elseif ($deal->direct()->exists()) {
                return new DealDirectResource($deal);
            }
        }
        return response()->json(['error' => 'Deal not found'], 404);
    }

    public function getDealDirect(Request $request, $id)
    {
        $deal = Deal::where('directApplication_id', $id)->first();
        if ($deal) {
            return new DealResource($deal);
        }

        return response()->json(['error' => 'Deal not found'], 404);
    }

    public function getDealTender(Request $request, $id)
    {
        $deal = Deal::where('tender_id', $id)->first();
        if ($deal) {
            return new DealResource($deal);
        }

        return response()->json(['error' => 'Deal not found'], 404);
    }

    public function store(Request $request)
    {
        $deal = Deal::create([
            'tender_id' => $request->tender_id,
            'responsesTender_id' => $request->responsesTender_id,
            'accept_by_customer' => 1,
            'accept_customer_date' => Carbon::now(),
        ]);

        $response = ResponsesTender::find($request->responsesTender_id);
        $response->archive = ResponsesTender::STATUS_DEAL;
        $response->save();

        $response = Tender::find($request->tender_id);
        $response->archive = Tender::STATUS_DEAL;
        $response->save();

        return response()->json(['deal_id' => $deal->id]);
    }

    public function storeDirect(Request $request)
    {
        $deal = Deal::create([
            'directApplication_id' => $request->directApplication_id,
            'accept_by_customer' => 1,
            'accept_customer_date' => Carbon::now(),
        ]);

        $direct = DirectApplications::find($request->directApplication_id);
        $direct->archive = ResponsesTender::STATUS_DEAL;
        $direct->save();
        return response()->json(['deal_id' => $deal->id]);
    }

    public function reject(Request $request, $id)
    {
        $deal = Deal::find($id);
        $deal->rejectionsDeal = json_encode($request->rejectionsDeal);
        $deal->reason_canceled = $request->reason_cancelled;
        $deal->status = $request->status;
        $deal->save();

        $this->updateRelatedModelArchive($request, $deal);

        return response()->json('success');
    }

    private function updateRelatedModelArchive(Request $request, Deal $deal)
    {
        if ($request->idResponse !== false) {
            $model = $deal->responsesTender;
        } elseif ($request->idDirect !== false) {
            $model = $deal->direct;
        }

        if (isset($model)) {
            $model->archive = $request->status;
            $model->save();
        }
    }

   /* public function reject(Request $request, $id)
    {
        $deal = Deal::find($id);
        $deal->rejectionsDeal = json_encode($request->rejectionsDeal);
        $deal->status = $request->status;
        $deal->save();

        if ($request->idResponse != false) {
            $response = ResponsesTender::find($request->idResponse);
            $response->archive = $request->status;
            $response->save();
        } else if ($request->idDirect != false) {
            $direct = DirectApplications::find($request->idDirect);
            $direct->archive = $request->status;
            $direct->save();
        }
        return response()->json('success');
    }*/

    public function accept(Request $request, $id)
    {
        $deal = Deal::find($id);
        $deal->accept_by_executor = ($request->role == 3 ? 1 : 0);
        $deal->accept_by_customer = ($request->role == 2 ? 1 : 0);
        $deal->accept_executor_date = ($request->role == 3 ? Carbon::now() : null);
        $deal->accept_customer_date = ($request->role == 2 ? Carbon::now() : null);

        $deal->save();
        return response()->json('success');
    }

    public function dealGetPayment(Request $request, $id)
    {
        $deal = Deal::find($id);
        $deal->step = Deal::STATUS_GET_PAYMENT;
        $deal->save();
    }

    public function dealDone(Request $request, $id)
    {
        $deal = Deal::find($id);
        $deal->step = Deal::STATUS_DEAL_FINISH;
        $deal->save();

        if ($request['tender_id']) {
            $tender = Tender::find($request['tender_id']);
            $tender->archive = Tender::STATUS_COMPLETE;
            $tender->save();
        }
        if ($request['direct_id']) {
            $direct = DirectApplications::find($request['direct_id']);
            $direct->archive = Tender::STATUS_COMPLETE;
            $direct->save();
        }

        return $deal;
    }

    public function dealCompleteWithReview(Request $request, $id)
    {
        $status = null;
        $deal = Deal::find($id);
        if ($request['complete'] == 1) {
            $deal->complete = Deal::COMPLETE_SUCCESS;
            $status = DirectApplications::STATUS_COMPLETE;
        } else if ($request['complete'] == 2) {
            $deal->complete = Deal::COMPLETE_ARBITR;
            $status = DirectApplications::STATUS_COMPLETE_ARBITER;
        }

        if ($deal->directApplication_id) {
            $direct = DirectApplications::find($deal->directApplication_id);
            $direct->archive = $status;
            $direct->save();
        } else {
            $tender = Tender::find($deal->tender_id);
            $tender->archive = $status;
            $tender->save();
        }
        $deal->step = Deal::STATUS_REVIEW;
        $deal->save();
        return $deal;
    }

    public function connectArbitration(Request $request, $id)
    {
        $deal = Deal::find($id);
        if ($request->role == User::USER_ROLE_CUSTOMER)
            $deal->step = Deal::STATUS_ARBITR_CUSTOMER;
        else $deal->step = Deal::STATUS_ARBITR_EXECUTOR;
        $deal->save();
        return $deal;
    }
}

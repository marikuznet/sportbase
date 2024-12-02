<?php

namespace App\Http\Controllers\Estimate;

use App\Http\Controllers\Controller;
use App\Http\Resources\Deal\DealDirectResource;
use App\Http\Resources\Deal\DealResource;
use App\Http\Resources\EstimateResource;
use App\Http\Resources\Profile\UserEstimateCollection;
use App\Http\Resources\Profile\UserEstimateResource;
use App\Models\Deal\Deal;
use App\Models\Estimate;
use App\Models\rentAccommodation;
use App\Models\rentAddition;
use App\Models\rentSportObject;
use Carbon\Carbon;
use DateTime;
use http\Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class EstimateController extends Controller
{
    public function index(Request $request)
    {
        $estimates = Estimate::query()
            ->when($request['deal_id'], function ($q, $request) {
                $q->where('deal_id', '=', $request);
            })->get();
        return EstimateResource::collection($estimates);
    }

    public function getEstimateById($id): Response|EstimateResource
    {
        $estimate = Estimate::with(['rentSportObject', 'rentAccomodation', 'rentAddition'])->find($id);
        if ($estimate) {
            return new EstimateResource($estimate);
        }

        return response()->noContent();
    }

    public function getPayments(Request $request)
    {
        $filters = (object)[
            'limit' => $request['limit'],
            'page' => $request['page'],
            'status' => $request['status'],
        ];
        $estimates = Estimate::query()->where('date_send_customer', '!=', null)
            ->where('sum', '>', 0)
            ->hasDeal()->hasUser()
            ->orderBy('created_at', 'desc')
            ->paginate($filters->limit, ['*'], 'page', $filters->page);

        /* ->whereNotIn('status', [0, 1])->hasLastEstimate()*/

        return new UserEstimateCollection($estimates);
    }

    public function getPaymentsStatistic()
    {
        $estimates = Estimate::query()
            ->where('date_send_customer', '!=', null)
            ->where('sum', '>', 0)
            ->hasDeal()
            ->hasUser()
            ->orderBy('created_at', 'desc')
            ->get();

        $paymentEstimates = $estimates->where('status', 5);
        $waitingEstimates = $estimates->where('status', 3);

        $sumPaymentEstimates = $paymentEstimates->sum('sum');
        $sumWaitingEstimates = $waitingEstimates->sum('sum');

        return response()->json([
            'sumPaymentEstimates' => number_format($sumPaymentEstimates, 0, ',', ' '),
            'sumWaitingEstimates' => number_format($sumWaitingEstimates, 0, ',', ' ')
        ]);
    }


    public function notificationPayment($id, Request $request)
    {
        $estimate = Estimate::find($id);
        if ($estimate) {
            $filename = 'payment_doc.' . $request->file('file')->getClientOriginalExtension();
            $request['file']->storeAs('deal/' . $request['deal_id'], $filename, 'public');

            $estimate->status = Estimate::ESTIMATE_PAYMENT_EXECUTOR;
            $estimate->payment_doc = $filename;
            $estimate->date_payment_to_executor = Carbon::now();
            $estimate->save();

            return $estimate;
        }

        return response()->noContent();
    }

    public function store(Request $request)
    {
        $object = rentSportObject::create([
            'checkSport' => $request->object_checkSport,
            'price' => $request->object_price,
            'sum' => $request->object_sum,
            'start_date' => $request->object_start_date,
            'end_date' => $request->object_end_date,
            'time' => $request->object_time,
            'training' => $request->object_training,
            'trainingTime' => json_encode($request->object_trainingTime),
            'trainingTime_diff' => json_encode($request->object_trainingTime_diff),
        ]);
        $accommodation = rentAccommodation::create([
            'checkAccm' => $request->accommodation_checkAccm,
            'accommodations' => $request->accommodation_accommodations,
            'daysAccm' => $request->accommodation_daysAccm,
            'start_date' => $request->accommodation_start_date,
            'end_date' => $request->accommodation_end_date,
            'priceFood' => $request->accommodation_priceFood,
            'sumPriceFood' => $request->accommodation_sumPriceFood,
            'sumAccm' => $request->accommodation_sumAccm,
            'titlePriceFood' => $request->accommodation_titlePriceFood,
            'typePriceFood' => $request->accommodation_typePriceFood,
            'typeFood_id' => $request->accommodation_typeFood_id
        ]);
        $additional = rentAddition::create([
            'checkLaundry' => $request->additional_checkLaundry,
            'washingVolume' => $request->additional_washingVolume,
            'priceWashing' => $request->additional_priceWashing,
            'sumLaundry' => $request->additional_sumLaundry,
            'checkTransfer' => $request->additional_checkTransfer,
            'durationTransfer' => $request->additional_durationTransfer,
            'priceTransfer' => $request->additional_priceTransfer,
            'sumTransfer' => $request->additional_sumTransfer,
            'infrastructures' => json_encode($request->additional_infrastructures),
            'totalPrice' => $request->additional_totalPrice,
        ]);

        return Estimate::create([
            'sportObject_id' => $request->sportObject_id,
            'deal_id' => $request->deal_id,
            'payment_at_customer' => false,
            'replay_estimate' => false,
            'rentSportObject_id' => $object->id,
            'rentAccommodation_id' => $accommodation->id,
            'rentAddition_id' => $additional->id,
            'show_customer' => false,
            'sum' => $request->sum,
        ]);
    }

    public function update(Request $request)
    {
        $object = rentSportObject::find($request->object_id);
        $object->checkSport = $request->object_checkSport;
        $object->price = $request->object_price;
        $object->sum = $request->object_sum;
        $object->start_date = $request->object_start_date;
        $object->end_date = $request->object_end_date;
        $object->time = $request->object_time;
        $object->training = $request->object_training;
        $object->trainingTime = json_encode($request->object_trainingTime);
        $object->trainingTime_diff = json_encode($request->object_trainingTime_diff);
        $object->save();

        $accommodation = rentAccommodation::find($request->accommodation_id);
        $accommodation->checkAccm = $request->accommodation_checkAccm;
        $accommodation->accommodations = $request->accommodation_accommodations;
        $accommodation->daysAccm = $request->accommodation_daysAccm;
        $accommodation->start_date = $request->accommodation_start_date;
        $accommodation->end_date = $request->accommodation_end_date;
        $accommodation->priceFood = $request->accommodation_priceFood;
        $accommodation->sumPriceFood = $request->accommodation_sumPriceFood;
        $accommodation->sumAccm = $request->accommodation_sumAccm;
        $accommodation->titlePriceFood = $request->accommodation_titlePriceFood;
        $accommodation->typeFood_id = $request->accommodation_typeFood_id;
        $accommodation->save();

        $additional = rentAddition::find($request->additional_id);
        $additional->checkLaundry = $request->additional_checkLaundry;
        $additional->washingVolume = $request->additional_washingVolume;
        $additional->priceWashing = $request->additional_priceWashing;
        $additional->sumLaundry = $request->additional_sumLaundry;
        $additional->checkTransfer = $request->additional_checkTransfer;
        $additional->durationTransfer = $request->additional_durationTransfer;
        $additional->priceTransfer = $request->additional_priceTransfer;
        $additional->sumTransfer = $request->additional_sumTransfer;
        $additional->infrastructures = json_encode($request->additional_infrastructures);
        $additional->totalPrice = $request->additional_totalPrice;
        $additional->save();

        $deal = Deal::with('tender', 'direct')->find($request['deal_id']);
        if ($deal->tender()->exists()) {
            return new DealResource($deal);
        }
        if ($deal->direct()->exists()) {
            return new DealDirectResource($deal);
        }
        // return new DealResource(Deal::find($request['deal_id']));
    }

    public function showCustomer(Request $request, $id)
    {
        $estimate = Estimate::find($id);
        $estimate->show_customer = 1;
        $estimate->status = Estimate::ESTIMATE_NOTIF_PAYMENT;
        $estimate->date_send_customer = Carbon::now();
        $estimate->payment_overdue_date = $request->payment_overdue_date;
        $estimate->save();
        return $estimate;
    }

    public function confirmPayment($id)
    {
        $estimate = Estimate::find($id);
        $estimate->status = Estimate::ESTIMATE_CONFIRMATION;
        $estimate->payment_at_customer = 1;
        $estimate->date_payment = Carbon::now();
        $estimate->save();
        return $estimate;
    }

    public function confirmPaymentAdmin($id, $deal_id)
    {
        $estimate = Estimate::with(['rentSportObject', 'rentAccomodation', 'rentAddition'])->find($id);
        $deal = Deal::find($deal_id);

        if ($estimate) {
            $estimate->status = Estimate::ESTIMATE_PAYMENT;
            $estimate->payment_confirm_date = Carbon::now();
            $estimate->save();
        }

        if ($deal) {
            $completedDate = $this->getMaxDateEstimate($estimate);

            if ($completedDate) {
                $completedDateTime = Carbon::createFromFormat('Y-m-d', $completedDate)->setTime(18, 0, 0);
                $confirmedAt = $completedDateTime->copy()->addDays(7);

                $deal->step = Deal::STATUS_GET_PAYMENT;
                $deal->completed_at = $completedDateTime->toDateTimeString();
                $deal->confirmed_at = $confirmedAt->toDateTimeString();
                $deal->save();
            } else {
                Log::error("Invalid completed date format or null value for date: $completedDate");
            }
        }

        return $estimate;
    }

    public function getMaxDateEstimate($estimate)
    {
        $maxEndDateAddition = null;
        if ($estimate->rentAddition) {
            $array = json_decode($estimate->rentAddition->infrastructures, true);
            foreach ($array as $item) {
                $endDate = $item['end_date'];
                if ($maxEndDateAddition === null || $endDate > $maxEndDateAddition) {
                    $maxEndDateAddition = $endDate;
                }
            }
        }

        return $maxEndDateAddition;
    }

    public function uploadDocumentPayment(Request $request, $id, $estimateId)
    {
        $document = $request['file'];
        $filename = 'payment.' . $document->getClientOriginalExtension();

        $estimate = Estimate::find($estimateId);
        $estimate->documents = json_encode($filename);
        $estimate->date_payment = Carbon::now();
        $estimate->save();

        $document->storeAs('deal/' . $id, $filename, 'public');
        return response()->json('success');
    }

    /**
     * Show image by ID and name.
     *
     * @param int $id
     * @param string $name
     * @return Response|string
     */
    public function showImage($id, $name)
    {
        try {
            $file = Storage::disk('local')->get("public/deal/$id/$name");
            return response($file)->header('Content-Type', 'image/jpeg, image/jpg, image/png');
        } catch (FileNotFoundException $e) {
            return response('Image not found', 404);
        } catch (\Exception $e) {
            return response('Internal Server Error', 500);
        }
    }

    /**
     * Show invoice by deal ID and estimate ID.
     *
     * @param int $id_deal
     * @param int $id_estm
     * @return Response|string
     */
    public function showInvoice($id_deal, $id_estm)
    {
        try {
            $file = Storage::disk('local')->get("public/deal/$id_deal/$id_estm.pdf");
            return response($file)->header('Content-Type', 'application/pdf');
        } catch (FileNotFoundException $e) {
            return response('Invoice not found', 404);
        } catch (\Exception $e) {
            return response('Internal Server Error', 500);
        }
    }

    /**
     * Show payment invoice by deal ID and estimate ID.
     *
     * @param int $id_deal
     * @param int $id_estm
     * @return Response|string
     */
    public function showPaymentInvoice($id_deal, $id_estm)
    {
        try {
            $file = Storage::disk('local')->get("public/deal/$id_deal/payment_invoice_$id_estm.pdf");
            return response($file)->header('Content-Type', 'application/pdf');
        } catch (FileNotFoundException $e) {
            return response('Payment Invoice not found', 404);
        } catch (\Exception $e) {
            return response('Internal Server Error', 500);
        }
    }

}

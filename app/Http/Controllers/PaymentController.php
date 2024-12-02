<?php

namespace App\Http\Controllers;

use App\Enums\PaymentAdvertisementStatusEnum;
use App\Models\Advertisment\AdvertismentOrders;
use App\Models\PaymentTransaction;
use App\Models\SportObject;
use App\Service\PaymentService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use YooKassa\Client;
use YooKassa\Client\BaseClient;
use YooKassa\Model\Notification\NotificationCanceled;
use YooKassa\Model\Notification\NotificationSucceeded;
use YooKassa\Model\Notification\NotificationWaitingForCapture;
use YooKassa\Model\NotificationEventType;
use YooKassa\Model\PaymentStatus;

class PaymentController extends Controller
{
    public function index()
    {
        return view('payment.index');
    }

    /**
     * @param Request $request
     * @param PaymentService $service
     * // * @return string
     * @throws \YooKassa\Common\Exceptions\ApiException
     * @throws \YooKassa\Common\Exceptions\BadApiRequestException
     * @throws \YooKassa\Common\Exceptions\ExtensionNotFoundException
     * @throws \YooKassa\Common\Exceptions\ForbiddenException
     * @throws \YooKassa\Common\Exceptions\InternalServerError
     * @throws \YooKassa\Common\Exceptions\NotFoundException
     * @throws \YooKassa\Common\Exceptions\ResponseProcessingException
     * @throws \YooKassa\Common\Exceptions\TooManyRequestsException
     * @throws \YooKassa\Common\Exceptions\UnauthorizedException
     */
    public function create(Request $request, PaymentService $service)
    {
        $amount = (float)$request['amount'];
        $description = $request['description'];
        $ratesIds = [];

        $payment_transaction = PaymentTransaction::create([
            'amount' => $amount
        ]);

        foreach ($request['advertisements'] as $advertisement) {
            $transaction = AdvertismentOrders::create([
                'payment_transaction_id' => $payment_transaction->id,
                'dateStart' => Carbon::now(),
                'sportObject_id' => $request['sportObject_id'],
                'days' => $advertisement['price']['days'],
                'statusAdvertisment_id' => 1,
                'amount' => $advertisement['price']['allPrice'],
                'description' => $description,
            ]);
            $ratesIds[] = $advertisement['id'];
            $transaction->rateAdvertisment()->attach($advertisement['id']);
        }

        return $service->createPayment($amount, $description, [
            'transaction_id' => $payment_transaction->id,
            'sport_object_id' => $request['sportObject_id'],
            'rates' => json_encode($ratesIds),
        ]);
    }

    public function callback(Request $request)
    {
        $source = file_get_contents('php://input');
        $requestBody = json_decode($source, true);

        Log::info('$request');

        $notification = match ($requestBody['event']) {
            NotificationEventType::PAYMENT_SUCCEEDED => new NotificationSucceeded($requestBody),
            NotificationEventType::PAYMENT_CANCELED => new NotificationCanceled($requestBody),
            NotificationEventType::PAYMENT_WAITING_FOR_CAPTURE => new NotificationWaitingForCapture($requestBody),
            default => null,
        };

        if ($notification) {
            $payment = $notification->getObject();
            if (isset($payment->status)) {
                $metadata = (object)$payment->metadata;
                $transactionId = (int)$metadata->transaction_id;
                $transaction = PaymentTransaction::find($transactionId);

                if ($payment->status === 'succeeded') {
                    $ratesIds = json_decode($metadata->rates);
                    $sportObject = $transaction->advertisementOrder->first()->sportObject;

                    foreach ($ratesIds as $rateId) {
                        if ($rateId == 1) {
                            $sportObject->hasHighlightion = 1;
                        } elseif ($rateId == 2) {
                            $sportObject->hasPromotion = 1;
                        } elseif ($rateId == 3) {
                            $sportObject->hasVIP = 1;
                        }
                    }

                    $sportObject->save();
                    $transaction->status = PaymentStatus::SUCCEEDED;
                    $transaction->save();
                } elseif ($payment->status === 'canceled') {
                    $transaction->status = PaymentStatus::CANCELED;
                    $transaction->save();
                } elseif ($payment->status === 'waiting_for_capture') {
                    $transaction->status = PaymentStatus::WAITING_FOR_CAPTURE;
                    $transaction->payment_id = $payment->id;
                    $transaction->payment_at = Carbon::now();
                    $transaction->save();

                    $client = new Client();
                    $client->setAuth(config('services.yookassa.shop_id'), config('services.yookassa.secret_key'));

                    $captureResponse = $client->capturePayment(
                        [
                            'amount' => [
                                'value' => $payment->amount['value'],
                                'currency' => $payment->amount['currency'],
                            ],
                        ],
                        $payment->id,
                        uniqid('', true)
                    );

                    if ($captureResponse->getStatus() === 'succeeded') {
                        $transaction->status = PaymentStatus::SUCCEEDED;
                        $transaction->save();

                        $ratesIds = json_decode($metadata->rates);
                        $sportObject = $transaction->advertisementOrder->first()->sportObject;

                        foreach ($transaction->advertisementOrder as $item) {
                            $days = $item->days;
                            $dateStart = $item->dateStart;
                            $item->date_end = Carbon::parse($dateStart)->addDays($days);
                            $item->save();
                        }

                        foreach ($ratesIds as $rateId) {
                            if ($rateId == 1) {
                                $sportObject->hasHighlightion = 1;
                            } elseif ($rateId == 2) {
                                $sportObject->hasPromotion = 1;
                            } elseif ($rateId == 3) {
                                $sportObject->hasVIP = 1;
                            }
                        }
                        $sportObject->save();
                    }
                }
            }
        }
    }
}

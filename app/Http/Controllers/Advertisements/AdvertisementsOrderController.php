<?php

namespace App\Http\Controllers\Advertisements;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\Estimates\PaymentAdvertisementCollection;
use App\Http\Resources\AdvertisementAndTariffs\AdvertisementCollection;
use App\Models\Advertisment\AdvertismentOrders;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use YooKassa\Model\PaymentStatus;

class AdvertisementsOrderController extends Controller
{
    public function getAdvertisements()
    {
        $advertisements = AdvertismentOrders::with('rateAdvertisment', 'paymentTransaction')
            ->whereHas('paymentTransaction', function ($q) {
                $q->where('status', PaymentStatus::SUCCEEDED);
            })->orderBy('id', 'desc')->get();
        return new AdvertisementCollection($advertisements);
    }

    public function getPaymentAdvertisements(): PaymentAdvertisementCollection
    {
        $advertisements = AdvertismentOrders::with('rateAdvertisment')->orderBy('id', 'desc')->get();
        return new PaymentAdvertisementCollection($advertisements);
    }

    public function stopAdvertisement(Request $request, $id)
    {
        $advertisement = AdvertismentOrders::find($id);
        $advertisement->pause((int)$request['days']);
    }

    public function resumeAdvertisement($id)
    {
        $advertisement = AdvertismentOrders::find($id);
        $advertisement->resume();
    }
}

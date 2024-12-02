<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\PaymentDetailsStoreRequest;
use App\Http\Resources\Profile\PaymentDetailsCollection;
use App\Http\Resources\Profile\PaymentDetailsResourse;
use App\Models\Profile\PaymentDetails;
use App\Models\Profile\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentDetailsController extends Controller
{
    public function index(Request $request)
    {
        $user_id = $request['user_id'];
        $payments = PaymentDetails::query()->with('address')
            ->when($user_id, function ($q, $user_id) {
                $q->where('user_id', $user_id);
            })->get();
        return new PaymentDetailsCollection($payments);
    }

    public function getByUser()
    {
        $payment = PaymentDetails::query()->where('user_id', Auth::user()->id)->first();
        if ($payment)
            return new PaymentDetailsResourse($payment);
        else return new PaymentDetailsResourse(new PaymentDetails());
    }

    /**
     * @param \App\Http\Requests\Profile\PaymentDetailsStoreRequest $request
     * @param PaymentDetails $paymentDetails
     * @return \Illuminate\Http\Response
     */
    public function update(PaymentDetailsStoreRequest $request, PaymentDetails $paymentDetails)
    {
        $address = null;
        if ($request->city_id != null) {
            $address = Address::updateOrCreate([
                'id' => $request->get('address_id')
            ], [
                'city_id' => $request->city_id,
                'postIndex' => $request->postIndex,
                'address' => $request->address,
                'longtitude' => null,
                'latitude' => null,
            ]);
        }

        if ($address != null)
            $address_id = $address->id;
        else $address_id = null;

        $newPaymentDetails = PaymentDetails::updateOrCreate(
            [
                'user_id' => $request->get('user_id'),
            ], [
            'legal_name' => $request->get('legal_name'),
            'title' => $request->get('title'),
            'tin' => $request->get('tin'),
            'numKpp' => $request->get('numKpp'),
            'bic' => $request->get('bic'),
            'requisites' => $request->get('requisites'),
            'kc' => $request->get('kc'),
            'okpo' => $request->get('okpo'),
            'okato' => $request->get('okato'),
            'orgn' => $request->get('orgn'),
            'address_id' => $address_id,
        ]);
        return $newPaymentDetails;
    }
}

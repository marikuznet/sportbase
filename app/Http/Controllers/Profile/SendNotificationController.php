<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\SendNotificationStoreRequest;
use App\Http\Resources\Profile\SendNotificationCollection;
use App\Models\Profile\SendNotifEmail;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SendNotificationController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return SendNotificationCollection
     */
    public function index(Request $request)
    {
        $send = SendNotifEmail::where('user_id', Auth::user()->id)->get();
        return new SendNotificationCollection($send);
    }

    /**
     * @param \App\Http\Requests\Profile\SendNotificationStoreRequest $request
     * @return \Illuminate\Http\Request
     */
    public function store(SendNotificationStoreRequest $request)
    {
        $notife = SendNotifEmail::create($request->validated());
        $request->session()->flash('sendNotifeEmail.id', $notife->id);
        return response()->json($notife);
    }

    public function destroy(){
        SendNotifEmail::query()->where('user_id', Auth::user()->id)->delete();
    }
}

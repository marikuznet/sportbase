<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deal\Deal;
use Illuminate\Http\Request;

class DealController extends Controller
{
    public function index(Request $request)
    {
        $deals = Deal::query()->hasSportObject()->orderByDesc('id')->get();
        return \App\Http\Resources\Admin\Deal\DealResource::collection($deals);
    }
}

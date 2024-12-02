<?php

namespace App\Http\Controllers\Tender;

use App\Http\Controllers\Controller;
use App\Http\Resources\Tender\ResponsesAndTendersResource;
use App\Models\Tender\ResponsesTenderAndTenders;
use Illuminate\Http\Request;

class ResponsesAndTenderController extends Controller
{
    public function index(Request $request)
    {
        $responses = ResponsesTenderAndTenders::all();

        return ResponsesAndTendersResource::collection($responses);
    }
    public function getResponsesByTender(Request $request, $id)
    {
        $responses = ResponsesTenderAndTenders::query()->where('tender_id', $id)->get();

        return ResponsesAndTendersResource::collection($responses);
    }
}

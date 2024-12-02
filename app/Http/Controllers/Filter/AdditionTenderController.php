<?php

namespace App\Http\Controllers\Filter;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Tender\AdditionTender;
use Illuminate\Http\Request;

class AdditionTenderController extends Controller
{
    public function index(Request $request)
    {
        $additionTender = AdditionTender::get()->all();
        if ($additionTender) return response()->json($additionTender);
    }
}

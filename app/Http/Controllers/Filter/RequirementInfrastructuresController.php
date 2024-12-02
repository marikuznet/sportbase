<?php

namespace App\Http\Controllers\Filter;

use App\Http\Controllers\Controller;
use App\Models\Infrastructure;
use App\Models\Tender\RequirementInfrastructures;
use Illuminate\Http\Request;

class RequirementInfrastructuresController extends Controller
{
    public function index(Request $request)
    {
        /* $infrastructures = Infrastructure::query()
             ->with('sportObjects')->whereHas('sportObjects', function ($query) {
                 $query->verify()->visible();
             })
             ->select('id', 'title')
             ->groupBy('title')
             ->get();
         if ($infrastructures) return response()->json($infrastructures);*/
        $infrastructures = RequirementInfrastructures::get()->all();
        if ($infrastructures) return response()->json(['data' => $infrastructures]);
    }
}

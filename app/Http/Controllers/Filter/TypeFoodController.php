<?php

namespace App\Http\Controllers\Filter;

use App\Http\Controllers\Controller;
use App\Models\Tender\TypeFood;
use Illuminate\Http\Request;

class TypeFoodController extends Controller
{
    public function index(Request $request)
    {
        $typeFoods = TypeFood::get()->all();
        if ($typeFoods) return response()->json($typeFoods);
    }
}

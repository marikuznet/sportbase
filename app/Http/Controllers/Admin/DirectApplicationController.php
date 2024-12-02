<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\AdminDirectApplicationsResource;
use App\Http\Resources\Tender\DirectApplicationResource;
use App\Models\DirectApplications;
use Illuminate\Http\Request;

class DirectApplicationController extends Controller
{
    public function index(Request $request)
    {
        $directs = DirectApplications::all();
        return response(AdminDirectApplicationsResource::collection($directs));
    }
    public function getDirectById($id)
    {
        $direct = DirectApplications::query()->findOrFail($id);
        return response(new DirectApplicationResource($direct));
    }
}

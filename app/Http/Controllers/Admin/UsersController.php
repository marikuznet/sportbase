<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\UsersCollection;
use App\Http\Resources\Admin\UsersResource;
use App\Http\Resources\InfoCompanyCollection;
use App\Models\Profile\InfoCompany;
use App\Models\Profile\PaymentDetails;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::select(['block', 'created_at', 'email', 'id', 'phone', 'role', 'status'])->get();
        return new UsersCollection($users);
    }

    public function getUser()
    {
        $user_id = Auth::id();
        return response(User::find($user_id)->only(['name', 'email', 'phone', 'role', 'status', 'block']), 200);
    }

    public function getUserInfo()
    {
        $user_id = Auth::id();
        $companies = InfoCompany::query()->where('user_id', '=', $user_id)->get();
        return response(new InfoCompanyCollection($companies), 200);
    }


    public function getCurrentUser()
    {
        $user = User::query()->with('notifications')
            ->where('id', '=', Auth::id())
            ->select('id', 'name', 'email', 'phone', 'role', 'status', 'block')
            ->get()->first();
        return response(new UsersResource($user), 200);

        return response()->json(User::query()->with('notifications')
            ->where('id', '=', Auth::id())
            ->select('id', 'name', 'email', 'phone', 'role', 'status', 'block')
            ->get()->first());
    }

    public function getCustomers()
    {
        $customers = User::where('role', 2)->get();
        return response()->json($customers);
    }

    public function getExecutors()
    {
        $executors = User::select('users.*')->where('role', 3)->get();
        return response()->json($executors);
    }

    public function showProfile(User $user)
    {
        $user_data = json_encode(new UsersResource($user));
        return view('adminPanel.users.profileAndSettings', compact('user_data'));
    }

    public function updateStatus(Request $request)
    {
        $user = User::find($request['id']);
        $user->status = $request->status;
        $user->save();
    }

    public function setBlock(Request $request)
    {
        $user = User::find($request['id']);
        $user->block = $request->block;
        $user->save();
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->status = User::STATUS_DELETED;
        $user->save();
    }
}

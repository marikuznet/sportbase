<?php

namespace App\Http\Controllers\Profile;

use App\Http\Requests\InfoCompanyStoreRequest;
use App\Http\Requests\InfoCompanyUpdateRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserEstimateCollection;
use App\Http\Resources\InfoCompanyResource;
use App\Http\Resources\Profile\AddressResourse;
use App\Models\Estimate;
use App\Models\Profile\InfoCompany;
use App\Models\User;
use App\Models\Profile\Address;
use http\Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InfoCompanyController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $info = InfoCompany::get();
        return response()->json($info);
    }

    public function uploadImageLogo(Request $request, $idUser)
    {
        $logo = $request['file'];
        if (!Storage::exists('logos/' . $idUser)) {
            Storage::makeDirectory('logos/' . $idUser);
        }

        $filename = 'logo.' . $logo->getClientOriginalExtension();
        $img = $logo->storeAs('logos/' . $idUser, $filename, 'public');
        return $filename;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param $id
     * @return InfoCompanyResource
     */
    public function getInfo()
    {
        $info = InfoCompany::where('user_id', Auth::id())->first();
        if ($info) return new InfoCompanyResource($info);
    }

    public function getStatusVerify(Request $request, $id)
    {
        $user = User::find($id);
        if ($user) return $user['status'];
    }

    /**
     * @param \App\Http\Requests\CityStoreRequest $request
     * @return \App\Http\Resources\Profile\AddressResourse
     */
    public function getAddress($id)
    {
        $address = Address::find($id);
        if ($address) return new AddressResourse($address);
    }

    /**
     * @return int
     */
    public function getBalance()
    {
        $estimates = Estimate::query()->selectRaw('SUM(`estimates`.sum) AS `sum_user`, (SELECT sport_objects.user_id
        FROM sport_objects WHERE estimates.sportObject_id = sport_objects.id GROUP BY `sport_objects`.`user_id`) AS `user_id`')
            ->groupBy('user_id')
            ->where('status', '=', 5)
            ->get();
        $estimates = $estimates->where('user_id', '=', Auth::id())->first();
        if (!$estimates) {
            return 0;
            throw new \Exception('Estimates not found for this user');
        }

        return response()->json($estimates->sum_user);
    }

    function showLogo($id, $name)
    {
        try {
            $path = "public/logos/$id/$name";

            if (Storage::disk('local')->exists($path)) {
                $file = Storage::disk('local')->get($path);

                return (new Response($file, 200))
                    ->header('Content-Type', 'image/jpeg');
            } else {
                return response()->file(public_path('images/default/user.png'));
            }
        } catch (Exception $e) {
            return "/images/common/icons/general/content-loader.gif";
        } catch (FileNotFoundException $e) {
        }
    }

    /**
     * @param \App\Http\Requests\Profile\InfoCompanyStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
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

        $info = InfoCompany::updateOrCreate([
            'user_id' => $request['user_id']
        ], [
            'typePerson' => $request->get('typePerson'),
            'user_id' => $request->get('user_id'),
            'title' => $request->get('title'),
            'image' => json_encode($request->get('image')),
            'phoneCompany' => json_encode($request->get('phoneCompany')),
            'quantityEmployees' => $request->get('quantityEmployees'),
            'emailCompany' => $request->get('emailCompany'),
            'site' => $request->get('site'),
            'description' => $request->get('description'),

            'address_id' => $address_id,

            'facebook' => $request['facebook'],
            'twitter' => $request['twitter'],
            'linkedIn' => $request['linkedIn'],
            'telegram' => $request['telegram'],
            'slack' => $request['slack'],
            'instagram' => $request['instagram'],

            'surname' => $request['surname'],
            'name' => $request['name'],
            'patronymic' => $request->get('patronymic'),
            'position_id' => $request->get('position_id'),
            'email' => $request->get('email'),
            'phone' => json_encode($request->get('phone')),
        ]);
        $info->save();
        return \response()->json("success", 200);
    }

    /**
     * @param \App\Http\Requests\InfoCompanyUpdateRequest $request
     * @param \App\Models\Profile\InfoCompany $info
     * @return \Illuminate\Http\Response
     */
    public function update(InfoCompanyUpdateRequest $request, InfoCompany $info)
    {
        return $request->all();

        $info->update($request->validated());

        $request->session()->flash('sportObject.id', $info->id);

        return response()->json($info);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Profile\InfoCompany $info
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $info = InfoCompany::find($id);
        if (is_null($info)) {
            return response()->json(['message' => 'Delete error! Wrong id!']);
        }
        $info->delete();
        $message = "Successfully deleted";
        return response()->json(['infoCompany' => $info, 'message' => $message]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Resources\SportObjectCollection;
use App\Http\Resources\SportObjectResource;
use App\Models\AccomodationType;
use App\Models\AccomodationTypeAndPricing;
use App\Models\AccomodationTypeAndPricingAndObject;
use App\Models\Infrastructure;
use App\Models\InfrastructureAndObject;
use App\Models\Option;
use App\Models\rentAccommodation;
use App\Models\rentAddition;
use App\Models\rentSportObject;
use App\Models\SportObject;
use App\Models\User;
use Carbon\Carbon;
use http\Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class SportObjectController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return SportObjectCollection|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response
     * @var array $sportObjects
     */
    public function index(Request $request)
    {
        $sportObjects = SportObject::with(['infrastructures', 'city', 'pricing'])->whereHas('pricing')
            ->verify()->visible()->orderByDesc('id');//orderByDesc('hasVIP');

        $sportObjects = $sportObjects->withFilters((object)$request->filter)->paginate($request->total);
        return response(new SportObjectCollection($sportObjects));
    }

    public function getSportObjectsWithoutPage()
    {
        $sportObjects = SportObject::with(['infrastructures', 'city', 'pricing'])
            ->verify()->visible()->get();

        return SportObjectResource::collection($sportObjects);
    }

    public function getSimilarSportObjects(Request $request)
    {
        $sportObjects = SportObject::verify()->visible()->get();

        return SportObjectResource::collection($sportObjects);
    }

    public function getPopularSportObjects(Request $request)
    {
        $sportObjects = SportObject::verify()->visible()->withSportTypes($request->data)->withCount('deals')
            ->orderByDesc('deals_count')
            ->take(10)
            ->get();

        return SportObjectResource::collection($sportObjects);
    }

    public function getFavourites(Request $request)
    {
        $sportObjects = SportObject::with(['infrastructures', 'city', 'pricing'])->whereHas('pricing')
            ->where([['verify', 1], ['visible', 1]])->orderByDesc('hasVIP')->get();
        return response(SportObjectResource::collection($sportObjects), 200);
    }

    public function getSportObjectsByUser(Request $request): SportObjectCollection
    {
        $filters = (object)[
            'limit' => $request['limit'],
            'page' => $request['page'],
        ];
        $user = User::find(Auth::id());
        $sport_objects = $user->sportObjects()
            ->with(['advertisements' => function ($query) {
                $query->orderBy('date_end', 'desc');
            }])
            ->withSearch((object)$request->filter)
            ->paginate($filters->limit, ['*'], 'page', $filters->page);
        return new SportObjectCollection($sport_objects);
    }

    public function getSportObjectsByUserId($id)
    {
        return response(["data" => SportObject::where('user_id', '=', $id)->get()], 200);
    }

    /**
     * @param \App\Http\Requests\SportObjectStoreRequest $request
     * @return int
     */
    public function store(Request $request)
    {
        $request->merge([
            'image' => json_encode($request->image),
        ]);
        $sportObject = SportObject::create([
            'title' => $request['title'],
            'objectType_id' => $request['objectType_id'],
            'image' => $request['image'],
            'description' => $request['description'],
            'sportType_id' => $request['sportType_id'],
            'accomodationConditionAndPricing_id' => $request['accomodationConditionAndPricing_id'],
            'city_id' => $request['city_id'],
            'address' => $request['address'],
            'postIndex' => $request['postIndex'],
            'latitude' => $request['latitude'],
            'longtitude' => $request['longtitude'],
            'user_id' => Auth::id(),
        ]);
        $pricingIds = [];
        foreach ($request->typeLiving as $accommodation) {
            $item = AccomodationTypeAndPricing::create([
                'accomodationType_id' => $accommodation['idAccType'],
                'description' => $accommodation['description'],
                'price' => json_encode($accommodation['price']),
            ]);
            $pricingIds[] = $item->id;
        }
        $sportObject->pricing()->sync($pricingIds);


        foreach ($request->infrastructures as $infrastructure) {
            $item = Infrastructure::create([
                'title' => $infrastructure['title'],
                'image' => json_encode(['image' => $infrastructure['imageInfr']]),
            ]);
            $sportObject->infrastructures()->attach($item->id);

            foreach ($infrastructure['options'] as $option) {
                if (!is_null($option['title'])) {
                    Option::create([
                        'title' => $option['title'],
                        'infrastructure_id' => $item->id,
                    ]);
                }
            }
        }
        $sportObject->services()->sync($request->services);
        $sportObject->sports()->sync($request->sports);

        return $sportObject->id;
    }

    public function show(SportObject $sportObject)
    {
        if (!$sportObject->verify && !$sportObject->visible) return response()->noContent();
        $object_data = json_encode(new SportObjectResource($sportObject));
        return view('viewObject', compact('object_data'));
    }

    /**
     * @param SportObject $sportObject
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showEdit(SportObject $sportObject)
    {
        $object_data = json_encode(new SportObjectResource($sportObject));
        return view('stages.editObject', compact('object_data'));
    }

    public function update(Request $request): Response
    {
        $object_id = $request['id'];
        $sport_object = SportObject::findOrFail($object_id);
        $infrastructures = $request['infrastructures'];
        $living_request = $request['typeLiving'];
        $images = $request['storageImages'];

        $sport_object->update(['title' => $request['title'], 'objectType_id' => $request['objectType_id'],
            'image' => $images, 'description' => $request['description'], 'address' => $request['address'],
            'postIndex' => (int)$request['postIndex'], 'latitude' => $request['latitude'],
            'longtitude' => $request['longtitude']]);
        $sport_object->save();

        $sport_object->services()->sync($request->services);
        $sport_object->sports()->sync($request->sports);

        $included = $request['included'];
        $new_array = array_filter($included, function ($element) {
            return !empty($element['title']);
        });

        $accommodationConditionAndPricing = $sport_object->accomodationConditionAndPricing;
        $accommodationConditionAndPricing->description = $request['pricing_description'];
        $accommodationConditionAndPricing->save();

        $includedInAccommodationPricing = $accommodationConditionAndPricing->includedInAccomodationPricing;
        $includedInAccommodationPricing->title = json_encode(array_values($new_array));
        $includedInAccommodationPricing->save();

        foreach ($living_request as $living) {
            if (gettype($living['title']) !== 'string')
                $type = AccomodationType::query()->where('title', '=', end($living['title']))->first();
            else $type = AccomodationType::query()->where('title', '=', $living['title'])->first();

            $accm = AccomodationTypeAndPricing::query()->updateOrCreate(['id' => $living['id']], [
                'accomodationType_id' => $type['id'],
                'description' => $living['description'],
                'price' => json_encode($living['price']),
            ]);
            if (count(AccomodationTypeAndPricingAndObject::query()->where('accomodationType_id', '=', $accm->id)->get()) < 1)
                AccomodationTypeAndPricingAndObject::query()->create(['accomodationType_id' => $accm->id, 'sportObject_id' => $object_id]);
        }


        $array_infr = array_map(function ($f) {
            return $f['id'];
        }, $infrastructures);

        InfrastructureAndObject::where('sportObject_id', $object_id)
            ->whereNotIn('infrastructure_id', $array_infr)
            ->delete();

        $sport_object->infrastructures()->whereNotIn('id', $array_infr)->detach();

        foreach ($infrastructures as $in_infrastructure) {
            $infrastructure = Infrastructure::updateOrCreate(['id' => $in_infrastructure['id']], [
                'title' => $in_infrastructure['title'],
                'image' => json_encode(['image' => $in_infrastructure['imageInfr']])
            ]);

            $array_options = array_map(function ($f) {
                return $f['id'];
            }, $in_infrastructure['options']);

            $new_options = array_filter($in_infrastructure['options'], static function ($var) {
                return $var['title'] !== null;
            });

            $infrastructure->options()->whereNotIn('id', $array_options)->delete();

            foreach ($new_options as $option) {
                Option::updateOrCreate(['id' => $option['id']], [
                    'title' => $option['title'],
                    'infrastructure_id' => $infrastructure->id
                ]);
            }

            if (count(InfrastructureAndObject::where('infrastructure_id', $infrastructure->id)
                    ->where('sportObject_id', $object_id)
                    ->get()) < 1) {
                InfrastructureAndObject::create([
                    'infrastructure_id' => $infrastructure->id,
                    'sportObject_id' => $object_id
                ]);
            }
        }
        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SportObject $sportObject
     * @return string
     */
    public function destroy($id)
    {
        $sportObject = SportObject::findOrFail($id);

        $sportObject->deals()->each(function ($deal) {
            $deal->estimates()->delete();
            $deal->reviews()->delete();
            $deal->delete();
        });

        $sportObject->responsesTender()->each(function ($response) {
            $response->infrastructures()->detach();
            $response->sports()->detach();
            $response->additions()->detach();
            $response->foods()->detach();
            $response->delete();
        });

        $sportObject->directApplications()->each(function ($direct) {
            $direct->infrastructures()->detach();
            $direct->sports()->detach();
            $direct->additions()->detach();
            $direct->foods()->detach();
            $direct->delete();
        });

        $sportObject->services()->detach();
        $sportObject->sports()->detach();
        $sportObject->pricing()->detach();

        $sportObject->advertisements()->each(function ($advertisement) {
            $advertisement->rateAdvertisment()->detach();
            $advertisement->delete();
        });

        $infrastructures = InfrastructureAndObject::where('sportObject_id', $sportObject->id)->get();

        foreach ($infrastructures as $infrastructure) {
            if($infrastructure->options) {
                $infrastructure->options->delete();
            }
            $infrastructure->delete();
        }

        if ($sportObject->accomodationConditionAndPricing) {
            $includedInAccomodationPricing = $sportObject->accomodationConditionAndPricing->includedInAccomodationPricing;
            if ($includedInAccomodationPricing) {
                $sportObject->accomodationConditionAndPricing->includedInAccomodationPricing()->delete();
            }
        }

        $sportObject->delete();

        $imagePath = Storage::path("/public/objects/{$id}");
        if (is_dir($imagePath)) {
            File::deleteDirectory($imagePath);
        }

        return "success";
    }



    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SportObject $sportObject
     * @return \Illuminate\Http\JsonResponse
     */
    public function showOrHidden(Request $request, $id)
    {
        $sportObject = SportObject::find($id);
        $sportObject->visible = $request->visible;
        $sportObject->save();
        return response()->json('success');
    }

    public function verifyObject($id)
    {
        $sportObject = SportObject::find($id);
        $sportObject->verify = 1;
        $sportObject->save();

        return response()->json('success');
    }

    public function clearPausedAdvertisement(SportObject $sportObject)
    {
        foreach ($sportObject->advertisements as $advertisement) {
            $paymentStatus = $advertisement->paymentTransaction->status;
            if ($paymentStatus == 'succeeded' && $advertisement->paused) {
                $pauseUntil = Carbon::parse($advertisement->paused_at);
                $remainingTime = now()->diffInMinutes($pauseUntil);
                $advertisement->date_end = $advertisement->date_end->addMinutes($remainingTime);
                $advertisement->paused_at = null;
                $advertisement->update([
                    'paused' => false,
                    'pause_until' => null,
                ]);
                $advertisement->save();
            }
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getFile(Request $request)
    {
        return $request['file'];
    }

    /**
     * @param Request $request
     * @return string
     */
    public function uploadImages(Request $request): string
    {
        $filename = uniqid() . '.jpg';
        if (!$request['edit']) $request['file']->storeAs('objects/origin', $filename, 'public');
        else $request['file']->storeAs('objects/' . $request['id'], $filename, 'public');

        return $filename;
    }

    public function moveImage(Request $request, $idObject, $id)
    {
        if (!Storage::exists($idObject)) {
            Storage::makeDirectory($idObject);
        }
        Storage::move('public/objects/origin/' . '' . $id . '' . '.jpg', 'public/objects/' . $idObject . '/' . '' . $id . '' . '.jpg');
        Storage::deleteDirectory($idObject);
        return \response()->noContent();
    }

    public function removeImage(Request $request)
    {
        $image_path = null;
        if ($request['edit']) $image_path = Storage::path('/public/objects/' . $request['object_id'] . '/' . $request['image']);
        else $image_path = Storage::path('/public/objects/') . 'origin/' . $request['image'];

        File::delete($image_path);
        return response()->json($image_path);
    }

    public function uploadImagesInfrastruct(Request $request)
    {
        $filename = uniqid() . '.jpg';
        $img = $request['file']->storeAs('infrastruct/origin', $filename, 'public');
        return $filename;
    }

    function showImageObject($id, $name)
    {
        try {
            $file = Storage::disk('local')->get("public/objects/$id/$name");
            return (new Response($file, 200))
                ->header('Content-Type', 'image/jpeg, image/jpg');
        } catch (Exception $e) {
            return "/images/common/icons/general/content-loader.gif";
        } catch (FileNotFoundException $e) {
            return $this->showImageTempObject($name);
        }
    }

    function showImageTempObject($name)
    {
        try {
            $file = Storage::disk('local')->get("public/objects/origin/$name");
            return (new Response($file, 200))
                ->header('Content-Type', 'image/jpeg, image/jpg');
        } catch (Exception $e) {
            return "/images/common/icons/general/content-loader.gif";
        } catch (FileNotFoundException $e) {
            return $e;
        }
    }

    function showImageInfarstruct($name)
    {
        try {
            $file = Storage::disk('local')->get("/public/infrastruct/origin/$name");
            return (new Response($file, 200))
                ->header('Content-Type', 'image/jpeg');
        } catch (Exception $e) {
            return "/images/common/icons/general/content-loader.gif";
        } catch (FileNotFoundException $e) {
        }
    }

    public function getAddress(Request $request)
    {
        $response = Http::get("https://geocode-maps.yandex.ru/1.x/?apikey=${request['api']}&geocode=${request['long']},{$request['lat']}");
        $xml = simplexml_load_string($response);
        return json_encode($xml);
    }

    public function getCoords(Request $request)
    {
        return Http::get("https://geocode-maps.yandex.ru/1.x/?apikey=a5dcb900-70e8-4ce9-9128-481140e584c3&format=json&geocode=${request['address']}");
    }
}

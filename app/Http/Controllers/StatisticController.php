<?php

namespace App\Http\Controllers;

use App\Models\Deal\Deal;
use App\Models\DirectApplications;
use App\Models\Estimate;
use App\Models\Infrastructure;
use App\Models\Message;
use App\Models\Service;
use App\Models\SportObject;
use App\Models\Tender\RequirementInfrastructures;
use App\Models\Tender\ResponsesTender;
use App\Models\Tender\Tender;
use App\Models\Tender\TypeFood;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{
    public function __construct()
    {

    }

    public function getStatisticsBySportObjects()
    {
        $data = [
            'activeSportObjectsCount' => SportObject::where([['verify', 1], ['visible', 1]])->with('pricing')->whereHas('pricing')->count(),
            'nonactiveSportObjectsCount' => SportObject::query()->where('verify', 0)
                ->orWhere('visible', 0)->count(),
            'mySportObjectsCount' => SportObject::where([["user_id", "=", Auth::id()]])->get()->count(),
            'allSportObjectsCount' => SportObject::count()
        ];
        return response($data, 200);

    }

    public function getMyStatisticsByTenders()
    {
        $responsesActive = Tender::query()->with(['deal', 'responses'])->doesntHave('deal')->has('responses')
            ->whereHas('responses', function ($query) {
                $query->where('user_id', '=', Auth::id())->where('archive', '=', 0);
            })->where('archive', '=', 0)->orWhere('archive', 1)
            ->get();

        $data = [
            'activeTendersCount' => Tender::query()->hasUser()->active()->count(),
            'archiveTendersCount' => Tender::query()->hasUser()->archive()->count(),
            'allTendersCount' => Tender::count(),
            'myResponsesTenderCount' => $responsesActive->count()
        ];
        return response($data, 200);
    }

    public function getStatisticsByResponsesTender()
    {
        $data = [
            'activeCount' => ResponsesTender::query()->with('tender')
                ->active()
                ->hasUser()
                ->whereHas('tender')
                ->count(),
            'archiveCount' => ResponsesTender::query()->with('tender')
                ->archive()
                ->hasUser()
                ->whereHas('tender')
                ->count(),
        ];
        return response($data);
    }

    public function getStatisticsByTenders()
    {
        $responsesActive = Tender::active()->with(['deal', 'responses'])
            ->doesntHave('deal')
            ->has('responses')
            ->whereHas('responses', function ($query) {
                $query->where('user_id', Auth::id())->groupBy('user_id')->where('archive', 0);
            })
            ->where(function ($query) {
                $query->where('archive', 0)->orWhere('archive', 1);
            })
            ->withCount(['responses as responses_count' => function ($query) {
                $query->where('user_id', Auth::id())->groupBy('user_id');
            }])
            ->get();

        $data = [
            'activeTendersCount' => Tender::query()->active()->count(),
            'archiveTendersCount' => Tender::query()->archive()->count(),
            'allTendersCount' => Tender::count(),
            'myResponsesTenderCount' => $responsesActive->count(),
            'myTendersCount' => Tender::query()->active()->where('user_id', Auth::id())->count()
        ];
        return response($data, 200);
    }

    public function getStatisticsByDirect()
    {
        $data = [
            'activeCount' => DirectApplications::hasUser()->active()->count(),
            'archiveCount' => DirectApplications::hasUser()->archive()->count(),
        ];
        return response($data, 200);
    }

    public function getStatisticsForOrders()
    {
        $data = [
            'activeOrdersCount' => Deal::hasUser()->active()->count() + Deal::hasUser()->finish()->count(),
            'estimatesCount' => Estimate::query()->where('date_send_customer', '!=', null)
                ->where('sum', '>', 0)
                ->hasDeal()->hasUser()//->hasLastEstimate()
                ->count(),
            'paymentsCount' => Estimate::query()->where('date_send_customer', '!=', null)
                ->where('sum', '>', 0)
                ->hasDeal()->hasUser()
                ->where(function ($query) {
                    $query->where('status', 3)
                        ->orWhere('status', 5);
                })
                /*->where('date_send_customer', '!=', null)
                ->where('sum', '>', 0)
                ->where(function ($query) {
                    $query->where('status', 3)
                        ->orWhere('status', 5);
                })
                ->whereHas('sportObject', function ($query) {
                    $query->where('user_id', Auth::id());
                })*/
                ->count(),
            // ->hasLastEstimate()
        ];
        return response($data, 200);
    }

    public function getStatisticByMessages()
    {
        $unreadIds = Message::query()->select(DB::raw('count(`from`) as messages_count'))
            ->where('to', Auth::id())
            ->where('read', false)
            ->groupBy('from')
            ->get();

        $data = ['count_messages' => count($unreadIds) > 0 ? $unreadIds->pluck('messages_count')[0] : 0];
        return response($data, 200);
    }
}

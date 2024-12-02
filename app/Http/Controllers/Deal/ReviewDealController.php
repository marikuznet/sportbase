<?php

namespace App\Http\Controllers\Deal;

use App\Http\Controllers\Controller;
use App\Http\Resources\Deal\DealCollection;
use App\Http\Resources\Deal\DealResource;
use App\Http\Resources\Deal\ReviewDealCollection;
use App\Http\Resources\Deal\ReviewDealResource;
use App\Http\Resources\ReviewsCollection;
use App\Models\Deal\Deal;
use App\Models\Deal\ReviewDeal;
use App\Models\DirectApplications;
use App\Models\Tender\ResponsesTender;
use App\Models\Tender\Tender;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewDealController extends Controller
{
    /*public function __construct()
    {
        $this->middleware('auth');
    }*/

    public function index(Request $request)
    {
        /*if ($request->total) {
            $filters = (object)[
                'sort' => $request['sort'],
                'idObject' => $request['idObject']
            ];
            $reviews = ReviewDeal::sortReviews($filters)->paginate($request->total);
        } else $reviews = ReviewDeal::all();
        return ReviewDealResource::collection($reviews);*/
    }

    public function getPaginatedReviews(Request $request, $id)
    {
        $filters = (object)[
            'status' => $request['status'] ?? 'executor',
            'limit' => $request['limit'] ?? 10,
            'page' => $request['page'] ?? 1,
            'filter' => (object)$request['filter']
        ];

        $reviews = ReviewDeal::query()
            ->where('status', ReviewDeal::STATUS_APPROVED)
            ->reviewsForSportObject($id)
            ->sortReviews($filters)
            ->paginate($filters->limit, ['*'], 'page', $filters->page);

        return new ReviewsCollection($reviews);
    }

    public function store(Request $request)
    {
        $review = ReviewDeal::updateOrCreate([
            'deal_id' => $request->deal_id
        ], [
            'user_id' => $request->user_id,
            'infrastructure' => $request->infrastructure,
            'sport_object' => $request->sport_object,
            'food' => $request->food,
            'territory' => $request->territory,
            'place' => $request->place,
            'price' => $request->price,
            'text' => $request->text,
            'status' => 0,
        ]);

        $deal = Deal::find($request->deal_id);
        $deal->complete = ReviewDeal::STATUS_APPROVED;
        $deal->save();

        return $review;
    }

    public function verify($id)
    {
        $review = $this->findReviewDeal($id);
        $review->update(['status' => ReviewDeal::STATUS_APPROVED]);

        return new ReviewDealResource($review);
    }

    public function refused($id, Request $request)
    {
        $review = $this->findReviewDeal($id);
        $review->update(['status' => ReviewDeal::STATUS_REJECTED,
            'reasonDeleted' => $request["reasonDeleted"]]);

        return new ReviewDealResource($review);
    }

    public function destroy($id)
    {
        $review = $this->findReviewDeal($id);
        $review->delete();

        return response()->noContent();
    }

    public function getReviews(Request $request)
    {
        $filters = (object)[
            'status' => $request['status'] ?? 'executor',
            'limit' => $request['limit'] ?? 10,
            'page' => $request['page'] ?? 1,
            'filter' => (object)$request['filter']
        ];
        $status = $filters->status;

        $deals = Deal::query()
            ->where(function ($query) {
                $query->has('responsesTender.sportObject')
                    ->orHas('direct.sportObject');
            })
            ->whereIn('complete', [1, 2])
            ->when($status === 'executor', function ($query) {
                $query->where(function ($query) {
                    $query->whereHas('responsesTender.user', function ($q) {
                        $q->where('user_id', Auth::id());
                    })->orWhereHas('direct.sportObject.user', function ($q) {
                        $q->where('user_id', Auth::id());
                    });
                })
                    ->whereHas('reviews', function ($query) {
                        $query->where('status', ReviewDeal::STATUS_APPROVED);
                    });
            })
            ->when($status === 'customer', function ($query) {
                $query->where(function ($query) {
                    $query->whereHas('tender.user', function ($q) {
                        $q->where('user_id', Auth::id());
                    })->orWhereHas('direct.user', function ($q) {
                        $q->where('user_id', Auth::id());
                    });
                });
            })
            ->withFilters($filters->filter)
            ->orderBy('id', 'desc')
            ->paginate($filters->limit, ['*'], 'page', $filters->page);
        return new \App\Http\Resources\Deal\ReviewsCollection($deals);
    }

    private function findReviewDeal($id)
    {
        try {
            return ReviewDeal::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            abort(404, 'Review not found.');
        }
    }
}

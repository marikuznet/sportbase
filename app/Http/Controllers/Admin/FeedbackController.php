<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\FeedbackStoreRequest;
use App\Http\Requests\Admin\FeedbackUpdateRequest;
use App\Http\Resources\Admin\CooperationFeedbackCollection;
use App\Http\Resources\FeedbackResource;
use App\Models\Admin\Feedback;
use App\Models\Deal\ReviewDeal;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    /**
     *  Display a listing of feedbacks with pagination.
     *
     * @param \Illuminate\Http\Request $request
     * @return CooperationFeedbackCollection
     */
    public function index(Request $request)
    {
        $feedback = ReviewDeal::all();
        return new CooperationFeedbackCollection($feedback);
    }

    /**
     * Store a newly created feedback.
     *
     * @param \App\Http\Requests\Admin\FeedbackStoreRequest $request
     * @return FeedbackResource
     */
    public function store(FeedbackStoreRequest $request)
    {
        $feedback = Feedback::create($request->validated());

        return new FeedbackResource($feedback);
    }

    /**
     * Display the specified feedback.
     *
     * @param \App\Models\Admin\Feedback $feedback
     * @return FeedbackResource
     */
    public function show(Feedback $feedback)
    {
        return new FeedbackResource($feedback);
    }

    /**
     * Update the specified feedback.
     *
     * @param \App\Http\Requests\Admin\FeedbackUpdateRequest $request
     * @param \App\Models\Admin\Feedback $feedback
     * @return FeedbackResource
     */
    public function update(FeedbackUpdateRequest $request, Feedback $feedback)
    {
        $feedback->update($request->validated());

        return new FeedbackResource($feedback);
    }

    /**
     * Remove the specified feedback from storage.
     *
     * @param \App\Models\Admin\Feedback $feedback
     * @return \Illuminate\Http\Response
     */
    public function destroy(Feedback $feedback)
    {
        $feedback->delete();

        return response()->noContent();
    }
}

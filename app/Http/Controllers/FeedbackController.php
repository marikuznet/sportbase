<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeedbackStoreRequest;
use App\Http\Requests\FeedbackUpdateRequest;
use App\Http\Resources\FeedbackCollection;
use App\Http\Resources\FeedbackResource;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\FeedbackCollection
     */
    public function index(Request $request)
    {
        $feedback = Feedback::all();
        return new FeedbackCollection($feedback);
    }

    /**
     * @param \App\Http\Requests\FeedbackStoreRequest $request
     * @return \App\Http\Resources\FeedbackResource
     */
    public function store(FeedbackStoreRequest $request)
    {
        $feedback = Feedback::create($request->validated());

        return new FeedbackResource($feedback);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Feedback $feedback
     * @return \App\Http\Resources\FeedbackResource
     */
    public function show(Request $request, Feedback $feedback)
    {
        return new FeedbackResource($feedback);
    }

    /**
     * @param \App\Http\Requests\FeedbackUpdateRequest $request
     * @param \App\Models\Feedback $feedback
     * @return \App\Http\Resources\FeedbackResource
     */
    public function update(FeedbackUpdateRequest $request, Feedback $feedback)
    {
        $feedback->update($request->validated());

        return new FeedbackResource($feedback);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Feedback $feedback
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Feedback $feedback)
    {
        $feedback->delete();

        return response()->noContent();
    }
}

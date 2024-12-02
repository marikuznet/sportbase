<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Resources\Admin\MessagesArbitrCollection;
use App\Http\Resources\Admin\MessagesArbitrResource;
use App\Models\Admin\City;
use App\Models\MessageArbitr;
use Illuminate\Http\Request;

class MessagesArbitrController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return MessagesArbitrCollection
     */
    public function index(Request $request)
    {
        $messages = MessageArbitr::all();
        return new MessagesArbitrCollection($messages);
    }

    /**
     * @return MessagesArbitrResource
     */
    public function store(Request $request)
    {
        return MessageArbitr::create([
            'deal_id'=> $request['deal_id'],
            'user_id' => $request['user_id'],
            'message' => $request['message'],
        ]);
    }
}

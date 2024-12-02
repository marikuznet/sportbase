<?php

namespace App\Http\Controllers;

use App\Http\Resources\NewsCollection;
use App\Http\Resources\NewsResource;
use App\Models\Advertisment\AdvertismentOrders;
use App\Models\News;
use App\Models\User;
use Carbon\Carbon;
use http\Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use League\Event\Event;

class CooperationController extends Controller
{
    public function mail(Request $request)
    {
        $data = $request;
        Mail::send('emails.cooperation', ['cooperation' => $data],
            function ($message) use ($request) {
                $message->to('info@sportbaza.org');
                $message->subject('Возможности сотрудничества');
            }
        );
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Resources\NewsCollection;
use App\Http\Resources\NewsResource;
use App\Models\Advertisment\AdvertismentOrders;
use App\Models\News;
use Carbon\Carbon;
use http\Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use League\Event\Event;

class TaskController extends Controller
{
    public function watchAdvertisements() {
        $now = now();
        $pausedAdvertisements = AdvertismentOrders::where('paused', true)->get();

        foreach ($pausedAdvertisements as $advertisement) {
            $pauseUntil = Carbon::parse($advertisement->pause_until);

            if ($advertisement->paused && $now >= $pauseUntil) {
                $remainingTime = $advertisement->date_end->diffInMinutes($pauseUntil);
                $remainingEndDate = $now->addMinutes($remainingTime);
                $advertisement->update([
                    'date_end' => $remainingEndDate,
                    'paused' => false,
                    'paused_at' => null,
                    'pause_until' => null,
                ]);
                $advertisement->save();
            }
        }
    }
}

<?php

namespace App\Console\Commands;

use App\Models\Advertisment\AdvertismentOrders;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ChangePausedAdvertisement extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'watch-paused:advertisement';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Watch paused advertisements and resume if pause duration is over';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $now = now();
            $pausedAdvertisements = AdvertismentOrders::query()
                ->with('paymentTransaction')
                ->where('paused', true)
                ->whereHas('paymentTransaction', function ($query) {
                    $query->where('status', 'succeeded');
                })->get();

            foreach ($pausedAdvertisements as $advertisement) {
                $pauseUntil = Carbon::parse($advertisement->pause_until);

                if ($advertisement->paused && $now >= $pauseUntil) {
                    $newEndDate = $advertisement->date_end->addMinutes($now->diffInMinutes($pauseUntil));

                    $advertisement->update([
                        'date_end' => $newEndDate,
                        'paused' => false,
                        'paused_at' => null,
                        'pause_until' => null,
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::error('An error occurred while processing paused advertisements: ' . $e->getMessage());
        }
    }
}

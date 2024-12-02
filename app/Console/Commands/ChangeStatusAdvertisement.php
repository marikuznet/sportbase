<?php

namespace App\Console\Commands;

use App\Models\Advertisment\AdvertismentOrders;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ChangeStatusAdvertisement extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'change-status:advertisement';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'change status in advertisement';

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
                ->whereHas('paymentTransaction', function ($query) {
                    $query->where('status', 'succeeded');
                })->get();

            foreach ($pausedAdvertisements as $advertisement) {
                $dateEnd = Carbon::parse($advertisement->date_end);

                if ($advertisement->paused == 0 && $now >= $dateEnd) {
                    $advertisement->update([
                        'statusAdvertisment_id' => 3,
                        'paused_at' => null,
                    ]);
                    $advertisement->save();
                }
            }
        }catch (\Exception $e) {
            Log::error('An error occurred while processing paused advertisements: ' . $e->getMessage());
        }
    }
}

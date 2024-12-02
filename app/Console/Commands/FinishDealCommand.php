<?php

namespace App\Console\Commands;

use App\Models\Deal\Deal;
use App\Models\DirectApplications;
use App\Models\Tender\Tender;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class FinishDealCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'watch-confirmed:deal';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Finish deal after due time';

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
            $finishedDeals = Deal::query()->where('confirmed_at', '!=', null)
                ->whereNotIn('status', [Deal::STATUS_ARBITR_CUSTOMER, Deal::STATUS_ARBITR_EXECUTOR])->get();

            foreach ($finishedDeals as $finishedDeal) {
                $confirmedAt = Carbon::parse($finishedDeal->confirmed_at);

                if ($now >= $confirmedAt) {
                    $finishedDeal->step = Deal::STATUS_DEAL_FINISH;
                    $finishedDeal->save();

                    if ($finishedDeal['tender_id'] && $finishedDeal['responsesTender_id']) {
                        $tender = Tender::find($finishedDeal['tender_id']);
                        $tender->archive = Tender::STATUS_COMPLETE;
                        $tender->save();
                    }
                    if ($finishedDeal['directApplication_id']){
                        $direct = DirectApplications::find($finishedDeal['directApplication_id']);
                        $direct->archive = DirectApplications::STATUS_COMPLETE;
                        $direct->save();
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('An error occurred while processing finished deal: ' . $e->getMessage());
        }
    }
}

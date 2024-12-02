<?php

namespace App\Console;

use App\Console\Commands\ChangePausedAdvertisement;
use App\Console\Commands\ChangeStatusAdvertisement;
use App\Console\Commands\FinishDealCommand;
use App\Models\Advertisment\AdvertismentOrders;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        ChangeStatusAdvertisement::class,
        ChangePausedAdvertisement::class,
        FinishDealCommand::class
    ];

    protected function scheduleTimezone()
    {
        return 'Europe/Moscow';
    }

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('change-status:advertisement')->timezone('Europe/Moscow')
            ->everyMinute()->withoutOverlapping();
        $schedule->command('watch-paused:advertisement')->everyMinute()->withoutOverlapping();
        $schedule->command('watch-confirmed:deal')->everyMinute()->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}

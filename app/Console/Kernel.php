<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\UpdateCurrencyRates;
use App\Jobs\ClearCurrencyData;
use App\Interfaces\ScrapperInterface;
class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $scrapperInterface = app(ScrapperInterface::class);
        $schedule->job(new UpdateCurrencyRates($scrapperInterface))->cron('*/7 * * * *');
        $schedule->job(new ClearCurrencyData)->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\UpdateCurrencyRates;
use App\Interfaces\ScrapperInterface;
class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $scrapperInterface = app(ScrapperInterface::class);
        $schedule->job(new UpdateCurrencyRates($scrapperInterface))->everySevenMinutes();
        $schedule->job(new ClearCurrencyRates)->everyMinute();
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

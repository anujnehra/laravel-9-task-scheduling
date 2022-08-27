<?php

namespace App\Console;

use App\Console\Commands\ActivityApiCron;
use App\Console\Commands\ActivityCsvCron;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by application.
     *
     * @var array
     */
    protected $commands = [
        ActivityApiCron::class,
        ActivityCsvCron::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule): void
    {
        //task 1
        $schedule->command('activity_api:cron')->everyMinute();
        //task 2
        $schedule->command('activity_csv:cron')->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
        require base_path('routes/console.php');
    }
}

<?php

namespace App\Console;

use App\Console\Commands\ReleaseExpiredStock;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Register the commands for the application.
     */
    protected $commands = [
        ReleaseExpiredStock::class,
    ];

    /**
     * Schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        // Runs every 1 minute
        $schedule->command('stock:release')->everyMinute();
    }

    /**
     * Load commands.
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

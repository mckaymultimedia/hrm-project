<?php

namespace App\Console;

use App\Models\Employee;
use App\Models\PerformanceReview;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('inspire')->hourly();
        $schedule->command('performance:review')->monthly();
    }
    

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected $commands = [
        Commands\PerformanceReviewCommand::class,

    ];
}

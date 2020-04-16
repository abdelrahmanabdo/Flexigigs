<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\DeadlineChecker;
use App\Console\Commands\AprovalChecker;
use App\Console\Commands\PaymentChecker;
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        DeadlineChecker::class,
        AprovalChecker::class,
        // PaymentChecker::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {   
         $schedule->command('DeadlineChecker:run')
                  ->everyMinute()
                  ->withoutOverlapping();

        $schedule->command('AprovalChecker:run')
                  ->everyMinute()
                  ->withoutOverlapping();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}

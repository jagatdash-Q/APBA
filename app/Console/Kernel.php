<?php

namespace App\Console;

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
        Commands\CheckSubscription::class,
        Commands\CheckNomination::class,
        Commands\CheckSurveyCertification::class,
        Commands\CheckEventRegistration::class,
        Commands\ElectionReminder::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        // $schedule->command('check-subscription:cron')->everyMinute();
        // $schedule->command('check-nomination:cron')->everyMinute();
        // $schedule->command('election-reminder:cron')->hourly();
        // $schedule->command('check-survey-certification:cron')->everyMinute();
        // $schedule->command('check-event-registration:cron')->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}

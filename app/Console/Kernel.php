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
        Commands\DailyCron::class,
        Commands\DailySales::class,
        Commands\EndFreetrial::class,
        Commands\ExpireDate::class,
        Commands\SmsReport::class,
        Commands\PaymentNotification::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        // $schedule->command('daily:cron')
        //          ->everyMinute(); 
        $schedule->command('daily:sales')
                 ->dailyAt('00:00');
        $schedule->command('end:freetrial')->dailyAt('00:20');
        $schedule->command('expire:date')->dailyAt('00:40');                           
        $schedule->command('sms:report')->dailyAt('08:00'); 
        $schedule->command('payment:notification')->dailyAt('09:00'); 
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

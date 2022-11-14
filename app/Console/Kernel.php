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
        'App\Console\Commands\ScanRunningServers',
        'App\Console\Commands\StopUnusedMeeting'
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
        $schedule->command('cronjob:scanrunningservers')->everyMinute();
		$schedule->command('cronjob:stopunusedmeeting')->dailyAt('23:00');
		
		//$schedule->command('cronjob:stopunusedmeeting')->weeklyOn(7,'10:15');
		//$schedule->command('cronjob:stopunusedmeeting')->weeklyOn(7,'12:15');
		//$schedule->command('cronjob:stopunusedmeeting')->weeklyOn(7,'16:15');
		//$schedule->command('cronjob:stopunusedmeeting')->weeklyOn(7,'17:55');
		
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

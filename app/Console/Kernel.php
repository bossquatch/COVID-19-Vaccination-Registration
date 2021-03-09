<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\RunSchedulingCommands;
use App\Console\Commands\LotSync;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\BoardCommand::class,
        \App\Console\Commands\JudgeCommand::class,
        \App\Console\Commands\ParoleCommand::class,
        \App\Console\Commands\PostEventCommand::class,
        \App\Console\Commands\RunSchedulingCommands::class,
        \App\Console\Commands\LotSync::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('horizon:snapshot')
			->everyFiveMinutes()
			->onOneServer()
			->withoutOverlapping();
        $schedule->command(RunSchedulingCommands::class)
			->everyFiveMinutes()
			->onOneServer()
			->withoutOverlapping();
        $schedule->command(LotSync::class)
			->daily()
			->onOneServer()
			->withoutOverlapping();
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

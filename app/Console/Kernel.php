<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Symfony\Component\Process\Process;

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
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            dump(config('app.auto_scheduling'));
            if (config('app.auto_scheduling')) {
                $board = new Process(['php', 'artisan', 'scheduling:board']);
                $judge = new Process(['php', 'artisan', 'scheduling:judge']);
                $parole = new Process(['php', 'artisan', 'scheduling:parole']);

                // Run all scheduling processes asynchronously
                $board->start();
                $judge->start();
                $parole->start();

                // OPTIONAL: run somthing else while the processes are going

                // Then we wait for the sub-processes to finish.
                while ($board->isRunning() || $judge->isRunning() || $parole->isRunning()){
                    sleep(1);
                }

                // Finally we return.
                return true;
            }
        })->everyFifteenMinutes();
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

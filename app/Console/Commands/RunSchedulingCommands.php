<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;

class RunSchedulingCommands extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scheduling:fire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run all scheduling commands asynchronously';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
    	Log::alert('Running auto scheduling processes.');

        $this->info('Booting up...');
        if (config('app.auto_scheduling')) {
            $this->info('Starting auto-scheduling');
            $board = new Process(['php', 'artisan', 'scheduling:board']);
            $judge = new Process(['php', 'artisan', 'scheduling:judge']);
            $parole = new Process(['php', 'artisan', 'scheduling:parole']);
            $post_process = new Process(['php', 'artisan', 'scheduling:postprocess']);

            // Run all scheduling processes asynchronously
            $this->info('Beginning processes...');
            $board->start();
            $judge->start();
            $parole->start();
            $post_process->start();

            // OPTIONAL: run somthing else while the processes are going

            // Then we wait for the sub-processes to finish.
            $this->info('Waiting for all processes to complete...');
            while ($board->isRunning() || $judge->isRunning() || $parole->isRunning() || $post_process->isRunning()){
                sleep(1);
            }

            $this->info('Auto-scheduling complete!');

            Log::alert('Auto scheduling complete.');

            // Finally we return.
            return true;
        } else {
            $this->info('Auto-scheduling is not set up.');
            Log::alert('No auto scheduling tasks to run.');
            return true;
        }
    }
}

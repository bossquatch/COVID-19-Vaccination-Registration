<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\Scheduling\Judge;

class JudgeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scheduling:judge';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the scheduling judge (send auto messages to who possible, set others to manual callback)';

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
        $this->info('Running judge...');

        Judge::run();

        $this->info('Judge complete!');
    }
}

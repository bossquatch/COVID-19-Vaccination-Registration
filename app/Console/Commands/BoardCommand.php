<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\Scheduling\Board;

class BoardCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scheduling:board';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the scheduling board (stage invitations)';

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
        $this->info('Running board...');

        Board::run();

        $this->info('Board complete!');
    }
}

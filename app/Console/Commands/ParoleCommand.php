<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\Scheduling\Parole;

class ParoleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scheduling:parole';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the scheduling parole (expire old invitations)';

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
        $this->info('Running parole...');

        Parole::run();

        $this->info('Parole complete!');
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\Scheduling\PostEvent;

class PostEventCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scheduling:postprocess';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $this->info('Running post scheduling process procedures...');

        PostEvent::run();

        $this->info('Post scheduling process procedures complete!');
    }
}

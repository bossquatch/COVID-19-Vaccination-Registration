<?php

namespace App\Console\Commands;

use App\Http\Controllers\AnalyticsController;
use Illuminate\Console\Command;

class RunAnalytics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'analytics:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This simply updates the cache with current analytics';

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
        $controller = new AnalyticsController();
        $controller->index();
        return 0;
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\Moderna\LotSync as ModernaExpiry;

class LotSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lot:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync lot numbers with the Moderna Expiry.';

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
        $this->info('Starting sync...');

        if(ModernaExpiry::run()) {
            $this->info('Sync completed.');
        } else {
            $this->error('Sync failed!');
        }
    }
}

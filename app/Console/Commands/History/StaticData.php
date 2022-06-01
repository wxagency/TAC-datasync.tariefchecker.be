<?php

namespace App\Console\Commands\History;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Session;

use DateTime;

class StaticData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'staticdata:backup';

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
     * @return mixed
     */
    public function handle()
    {
        $this->info("Supplier data backup started");
        $this->call('supplier:backup');
        $this->info("Supplier data backup ended");
        $this->info("Static Residential data backup started");
        $this->call('SResidential:backup');
        $this->info("Static Residential data backup ended");
        $this->info("Static professional data started");
        $this->call('SProfessional:backup');
        $this->info("pack data started");
        $this->call('SPack:backup');
        $this->info("Sync static data completed");
    }
}

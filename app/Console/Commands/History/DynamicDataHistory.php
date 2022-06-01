<?php

namespace App\Console\Commands\History;

use Illuminate\Console\Command;

class DynamicDataHistory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'DynamicData:backup';

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
        $this->info("Dynamic data sync started");
        $this->call('DynamicResidential:backup');
        $this->call('DynamicProfessional:backup');
        // $this->call('Tax:backup');
        // $this->call('Netcost:backup');
        $this->info('Dynamic Data Saved');
    }
}

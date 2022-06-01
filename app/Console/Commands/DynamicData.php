<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DynamicData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dynamicdata:update';

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
        try {
            $this->call('residentialdata:import');
            $this->call('professionaldata:import');
            // $this->call('tax:import');
            // $this->call('netcoste:update');
            // $this->call('netcostg:update');
            $this->info('Data Saved');
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
}

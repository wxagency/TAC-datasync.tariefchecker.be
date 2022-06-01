<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Session;
use App\Models\StaticElecticResidential;
use App\Models\StaticGasResidential;
use App\Models\StaticElectricProfessional;
use App\Models\StaticGasProfessional;
use App\Models\PostalcodeElectricity;
use App\Models\PostalcodeGas;
use App\Models\StaticPackResidential;
use App\Models\StaticPackProfessional;
use Carbon\Carbon;

class StaticData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'staticdata:update';

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
        $this->info('data storing started');
        $this->call('dgo:sync');
        $this->call('supplierdata:store');
        $this->call('staticdata-residential:import');
        $this->call('staticdata-professional:import');
        $this->call('packs:import');
        $this->info('Data Saved');
      } catch (Exception $ex) {
          return $ex->getMessage();
      }      
    }
}

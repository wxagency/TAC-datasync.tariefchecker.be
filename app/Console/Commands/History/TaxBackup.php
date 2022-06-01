<?php

namespace App\Console\Commands\History;

use Illuminate\Console\Command;
use App\Models\History\TaxElectricity;
use App\Models\History\TaxGas;

use App\Models\TaxElectricity as TE;
use App\Models\TaxGas as TG;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use DateTime;

class TaxBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Tax:backup';

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
            $this->_taxElectricity();
            $this->_taxGas();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Backup of electricity Tax.
     *
     * @return void
     */
    private function _taxElectricity()
    {
        $taxElectricity = TE::all();
        
        if ( Session::get('backup-date')) {
            $backup = Session::get('backup-date');
        } else {
            $backup = Carbon::now();
            Session::put('backup' , $backup) ;
        }

        foreach ($taxElectricity as $taxE) {
            TaxElectricity :: Create(                 
                [
                '_id' => $taxE->_id,
                'backupdate' =>$backup,
                'date' => $taxE->date,
                'valid_from' => $taxE->valid_from,
                'valid_till' => $taxE->valid_till,
                'dgo' => $taxE->dgo,
                'dgo_electrabelname' => $taxE->dgo_electrabelname,
                'fuel' => $taxE->fuel,
                'segment' => $taxE->segment,
                'VL' => $taxE->VL,
                'WA'=>$taxE->WA,
                'BR' => $taxE->BR,
                'volume_lower' => $taxE->volume_lower,
                'volume_upper' => $taxE->volume_upper,
                'energy_contribution' => $taxE->energy_contribution,
                'federal_contribution'=>$taxE->federal_contribution,
                'connection_fee' => $taxE->connection_fee,
                'contribution_public_services' => $taxE->contribution_public_services,
                'fixed_tax_first_res' => $taxE->fixed_tax_first_res,
                'fixed_tax_not_first_res' => $taxE->fixed_tax_not_first_res
                ]
             );
        }
        $this->info('Tax of electricity backup completed.');
        return $backup;
    }

    /**
     * Backup of gas Tax.
     *
     * @return void
     */
    private function _taxGas()
    {
        $taxGas = TG::all();
        
        if ( Session::get('backup-date')) {
            $backup = Session::get('backup-date');
        } else {
            $backup = Carbon::now();
            Session::put('backup' , $backup) ;
        }

        foreach ($taxGas as $taxG) {
            TaxGas :: Create(                 
                [
                '_id' => $taxG->_id,
                'backupdate' => $backup,
                'date' => $taxG->date,
                'valid_from' => $taxG->valid_from,
                'valid_till' => $taxG->valid_till,
                'dgo' => $taxG->dgo,
                'dgo_electrabelname' => $taxG->dgo_electrabelname,
                'fuel' => $taxG->fuel,
                'segment' => $taxG->segment,
                'VL' => $taxG->VL,
                'WA'=>$taxG->WA,
                'BR' => $taxG->BR,
                'volume_lower' => $taxG->volume_lower,
                'volume_upper' => $taxG->volume_upper,
                'energy_contribution' => $taxG->energy_contribution,
                'federal_contribution'=>$taxG->federal_contribution,
                'contribution_protected_customers' => $taxG->contribution_protected_customers,
                'connection_fee' => $taxG->connection_fee,
                'contribution_public_services' => $taxG->contribution_public_services,
                'fixed_tax' => $taxG->fixed_tax,
                ]
             );
        }
        $this->info('Tax of gas backup completed.');
    }
}

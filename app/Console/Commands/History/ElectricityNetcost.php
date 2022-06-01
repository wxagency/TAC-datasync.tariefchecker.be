<?php

namespace App\Console\Commands\History;

use Illuminate\Console\Command;
use App\Models\Netcostes as NCE;

use App\Models\History\Netcostes;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use DateTime;

class ElectricityNetcost extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ENetcost:backup';

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
            $this->_netcostE();
        } catch (\exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Backup of Netcost Electricity.
     *
     * @return void
     */
    private function _netcostE()
    {
        $netcostE = NCE::all();

        if ( Session::get('backup-date')) {
            $backup = Session::get('backup-date');
        } else {
            $backup = Carbon::now();
            Session::put('backup' , $backup) ;
        }

        foreach ($netcostE as $netE) {
            Netcostes :: Create(                 
                [
                '_id' =>  $netE->_id,
                'backupdate' =>$backup,
                'date' => $netE->date,
                'valid_from' => $netE->valid_from,
                'valid_till' => $netE->valid_till,
                'dgo' => $netE->dgo,
                'dgo_electrabelname' => $netE->dgo_electrabelname,
                'fuel' => $netE->fuel,
                'segment' => $netE->segment,
                'VL' => $netE->VL,
                'WA'=>$netE->WA,
                'BR' => $netE->BR,
                'volume_lower' => $netE->volume_lower,
                'volume_upper' => $netE->volume_upper,
                'price_single' => $netE->price_single,
                'price_day' => $netE->price_day,
                'price_night' => $netE->price_night,
                'price_excl_night'=>$netE->price_excl_night,
                'reading_meter' => $netE->reading_meter,
                'prosumers' => $netE->prosumers,
                'transport' => $netE->transport,
                ]
             );
        }
        $this->info('Netcost of electricity backup completed.');
    }
}

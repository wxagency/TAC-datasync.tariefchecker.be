<?php

namespace App\Console\Commands\History;

use Illuminate\Console\Command;
use App\Models\Netcostgs as NCG;

use App\Models\History\Netcostgs;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use DateTime;

class GasNetcost extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'GNetcost:backup';

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
            $this->_netcostG();
        } catch (\exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Backup of Netcost Gas.
     *
     * @return void
     */
    private function _netcostG()
    {
        $netcostG = NCG::all();

        if ( Session::get('backup-date')) {
            $backup = Session::get('backup-date');
        } else {
            $backup = Carbon::now();
            Session::put('backup' , $backup) ;
        }

        foreach ($netcostG as $netG) {
            Netcostgs :: Create(                 
                [
                '_id' => $netG->_id,
                'backupdate' =>$backup,
                'date' => $netG->date,
                'valid_from' => $netG->valid_from,
                'valid_till' => $netG->valid_till,
                'dgo' => $netG->dgo,
                'dgo_electrabelname' => $netG->dgo_electrabelname,
                'fuel' => $netG->fuel,
                'segment' => $netG->segment,
                'VL' => $netG->VL,
                'WA'=>$netG->WA,
                'BR' => $netG->BR,
                'volume_lower' => $netG->volume_lower,
                'volume_upper' => $netG->volume_upper,
                'fixed_term' => $netG->fixed_term,
                'variable_term' => $netG->variable_term,
                'reading_meter_yearly' => $netG->reading_meter_yearly,
                'reading_meter_monthly'=>$netG->reading_meter_monthly,
                'reading_meter' => $netG->reading_meter,
                'transport' => $netG->transport,
                ]
             );
        }
        $this->info('Netcost of Gas backup completed');
    }
}

<?php

namespace App\Console\Commands\History;

use Illuminate\Console\Command;
use App\Models\DynamicElectricResidential as DER;
use App\Models\DynamicGasResidential as DGR;

use App\Models\History\DynamicElectricResidential;
use App\Models\History\DynamicGasResidential;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use DateTime;

class DynamicResidential extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'DynamicResidential:backup';

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
            $this->info('backup Dyn ElEK ') ;
            $this->_dynElectricR();
            $this->_dynGasR();
        } catch (\Exception $e) {
            $this->info('Exception Dyn ElEK '.$e->getMessage()) ;
        }
    }

    private function _dynElectricR()
    {
        $electricR = DER::all();

        if (Session::get('backup-date')) {
            $backup = Session::get('backup-date');
        } else {
            $backup = Carbon::now();
            Session::put('backup', $backup);
        }

        foreach ($electricR as $electric) {
            DynamicElectricResidential::Create(
                [
                    '_id' =>  $electric->_id,
                    'backupdate' => $backup,
                    'product_id' => $electric->product_id,
                    'date' => $electric->date,
                    'valid_from' => $electric->valid_from,
                    'valid_till' => $electric->valid_till,
                    'supplier' => $electric->supplier,
                    'product' => $electric->product,
                    'fuel' => $electric->fuel,
                    'duration' => $electric->duration,
                    'fixed_indexed' => $electric->fixed_indexed,
                    'customer_segment' => $electric->customer_segment,
                    'VL' => $electric->VL,
                    'WA' => $electric->WA,
                    'BR' => $electric->BR,
                    'volume_lower' => $electric->volume_lower,
                    'volume_upper' => $electric->volume_upper,
                    'price_single' => $electric->price_single,
                    'price_day' => $electric->price_day,
                    'price_night' => $electric->price_night,
                    'price_excl_night' => $electric->price_excl_night,
                    'ff_single' => $electric->ff_single,
                    'ff_day_night' => $electric->ff_day_night,
                    'ff_excl_night' => $electric->ff_excl_night,
                    'gsc_vl' => $electric->gsc_vl,
                    'wkc_vl' => $electric->wkc_vl,
                    'gsc_wa' => $electric->gsc_wa,
                    'gsc_br' => $electric->gsc_br,
                    'prices_url_nl' => $electric->prices_url_nl,
                    'prices_url_fr' => $electric->prices_url_fr,
                    'index_name' => $electric->index_name,
                    'index_value' => $electric->index_value,
                    'coeff_single' => $electric->coeff_single,
                    'term_single' => $electric->term_single,
                    'coeff_day' => $electric->coeff_day,
                    'term_day' => $electric->term_day,
                    'coeff_night' => $electric->coeff_night,
                    'term_night' => $electric->term_night,
                    'coeff_excl' => $electric->coeff_excl,
                    'term_excl' => $electric->term_excl,
                ]
            );
        }
        $this->info('Dynamic Electric Residential history saved');
    }

    private function _dynGasR()
    {
        $gasR = DGR::all();

        if (Session::get('backup-date')) {
            $backup = Session::get('backup-date');
        } else {
            $backup = Carbon::now();
            Session::put('backup', $backup);
        }

        foreach ($gasR as $gas) {
            DynamicGasResidential::Create(
                [
                    '_id' => $gas->_id,
                    'backupdate' => $backup,
                    'product_id' => $gas->product_id,
                    'date' => $gas->date,
                    'valid_from' => $gas->valid_from,
                    'valid_till' => $gas->valid_till,
                    'supplier' => $gas->supplier,
                    'product' => $gas->product,
                    'fuel' => $gas->fuel,
                    'duration' => $gas->duration,
                    'fixed_indexed' => $gas->fixed_indexed,
                    'segment' => $gas->segment,
                    'VL' => $gas->VL,
                    'WA' => $gas->WA,
                    'BR' => $gas->BR,
                    'volume_lower' => $gas->volume_lower,
                    'volume_upper' => $gas->volume_upper,
                    'price_gas' => $gas->price_gas,
                    'ff' => $gas->ff,
                    'prices_url_nl' => $gas->prices_url_nl,
                    'prices_url_fr' => $gas->prices_url_fr,
                    'index_name' => $gas->index_name,
                    'index_value' => $gas->index_value,
                    'coeff' => $gas->coeff,
                    'term' => $gas->term,
                ]
            );
        }
        $this->info('Gas residential back uped');
    }
}

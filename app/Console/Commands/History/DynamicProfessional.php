<?php

namespace App\Console\Commands\History;

use Illuminate\Console\Command;
use App\Models\DynamicElectricProfessional as DEP;
use App\Models\DynamicGasProfessional as DGP;

use App\Models\History\DynamicElectricProfessional;
use App\Models\History\DynamicGasProfessional;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use DateTime;

class DynamicProfessional extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'DynamicProfessional:backup';

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
            $this->_dynElectricP();
            $this->__dynGasP();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function _dynElectricP()
    {
        $electricPro = DEP::all();

        if (Session::get('backup-date')) {
            $backup = Session::get('backup-date');
        } else {
            $backup = Carbon::now();
            Session::put('backup', $backup);
        }

        foreach ($electricPro as $pro) {
            DynamicElectricProfessional::Create(
                [
                    '_id' =>  $pro->_id,
                    'backupdate' => $backup,
                    'product_id' => $pro->product_id,
                    'date' => $pro->date,
                    'valid_from' => $pro->valid_from,
                    'valid_till' => $pro->valid_till,
                    'supplier' => $pro->supplier,
                    'product' => $pro->product,
                    'fuel' => $pro->fuel,
                    'duration' => $pro->duration,
                    'fixed_indexed' => $pro->fixed_indexed,
                    'customer_segment' => $pro->customer_segment,
                    'VL' => $pro->VL,
                    'WA' => $pro->WA,
                    'BR' => $pro->BR,
                    'volume_lower' => $pro->volume_lower,
                    'volume_upper' => $pro->volume_upper,
                    'price_single' => $pro->price_single,
                    'price_day' => $pro->price_day,
                    'price_night' => $pro->price_night,
                    'price_excl_night' => $pro->price_excl_night,
                    'ff_single' => $pro->ff_single,
                    'ff_day_night' => $pro->ff_day_night,
                    'ff_excl_night' => $pro->ff_excl_night,
                    'gsc_vl' => $pro->gsc_vl,
                    'wkc_vl' => $pro->wkc_vl,
                    'gsc_wa' => $pro->gsc_wa,
                    'gsc_br' => $pro->gsc_br,
                    'prices_url_nl' => $pro->prices_url_nl,
                    'prices_url_fr' => $pro->prices_url_fr,
                    'index_name' => $pro->index_name,
                    'index_value' => $pro->index_value,
                    'coeff_single' => $pro->coeff_single,
                    'term_single' => $pro->term_single,
                    'coeff_day' => $pro->coeff_day,
                    'term_day' => $pro->term_day,
                    'coeff_night' => $pro->coeff_night,
                    'term_night' => $pro->term_night,
                    'coeff_excl' => $pro->coeff_excl,
                    'term_excl' => $pro->term_excl,
                ]
            );
        }
        $this->info('Electricity professional back uped');
    }

    private function __dynGasP()
    {
        $gasPro = DGP::all();

        if (Session::get('backup-date')) {
            $backup = Session::get('backup-date');
        } else {
            $backup = Carbon::now();
            Session::put('backup', $backup);
        }

        foreach ($gasPro as $gasP) {
            DynamicGasProfessional::Create(
                [
                    '_id' => $gasP->_id,
                    'backupdate' => $backup,
                    'product_id' => $gasP->product_id,
                    'date' => $gasP->date,
                    'valid_from' => $gasP->valid_from,
                    'valid_till' => $gasP->valid_till,
                    'supplier' => $gasP->supplier,
                    'product' => $gasP->product,
                    'fuel' => $gasP->fuel,
                    'duration' => $gasP->duration,
                    'fixed_indexed' => $gasP->fixed_indexed,
                    'segment' => $gasP->segment,
                    'VL' => $gasP->VL,
                    'WA' => $gasP->WA,
                    'BR' => $gasP->BR,
                    'volume_lower' => $gasP->volume_lower,
                    'volume_upper' => $gasP->volume_upper,
                    'price_gas' => $gasP->price_gas,
                    'ff' => $gasP->ff,
                    'prices_url_nl' => $gasP->prices_url_nl,
                    'prices_url_fr' => $gasP->prices_url_fr,
                    'index_name' => $gasP->index_name,
                    'index_value' => $gasP->index_value,
                    'coeff' => $gasP->coeff,
                    'term' => $gasP->term,
                ]
            );
        }
        $this->info('Gas professional back uped');
    }
}

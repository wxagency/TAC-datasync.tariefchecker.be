<?php

namespace App\Console\Commands\History;

use Illuminate\Console\Command;
use App\Models\StaticElecticResidential as SER;
use App\Models\StaticGasResidential as SGR;

use App\Models\History\StaticElecticResidential;
use App\Models\History\StaticGasResidential;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use DateTime;

class StaticResidential extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SResidential:backup';

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
            $this->info('Backup started for electricity');
            $this->_staticResidentialE();
            $this->_staticResidentialG();
            $this->info('Backup  ended');
        } catch (\Exception $e) {
            $this->info('Exception in static Elek: '. $e->getMessage()) ;
        }
    }
    /**
     * Backup Residential data Electricity.
     *
     * @return void
     */
    private function _staticResidentialE()
    {
        $staticResidentialE = SER::all();

        if (Session::get('backup-date')) {
            $backup = Session::get('backup-date');
        } else {
            $backup = Carbon::now();
            Session::put('backup', $backup);
        }

        foreach ($staticResidentialE as $electricResident) {

            StaticElecticResidential::Create(
                [
                    '_id' => $electricResident->_id,
                    'product_id' => $electricResident->product_id,
                    'backup_date' => $backup,
                    'acticve' => $electricResident->acticve,
                    'partner' => $electricResident->partner,
                    'supplier' => $electricResident->supplier,
                    'product_name_NL' => $electricResident->product_name_NL,
                    'product_name_FR' => $electricResident->product_name_FR,
                    'fuel' => $electricResident->fuel,
                    'duration' => $electricResident->duration,
                    'fixed_indiable' => $electricResident->fixed_indiable,
                    'green_percentage' => $electricResident->green_percentage,
                    'origin' => $electricResident->origin,
                    'segment' => $electricResident->segment,
                    'VL' => $electricResident->VL,
                    'NA' => $electricResident->NA,
                    'BR' => $electricResident->BR,
                    'service_level_payment' => $electricResident->service_level_payment,
                    'service_level_invoicing' => $electricResident->service_level_invoicing,
                    'service_level_contact' => $electricResident->service_level_contact,
                    'FF_pro_rata' => $electricResident->FF_pro_rata,
                    'inv_period' => $electricResident->inv_period,
                    'customer_condition' => $electricResident->customer_condition,
                    'subscribe_url_NL' => $electricResident->subscribe_url_NL,
                    'info_NL' => $electricResident->info_NL,
                    'tariff_description_NL' => $electricResident->tariff_description_NL,
                    'terms_NL' => $electricResident->terms_NL,
                    'subscribe_url_FR' => $electricResident->subscribe_url_FR,
                    'info_FR' => $electricResident->info_FR,
                    'tariff_description_FR' => $electricResident->tariff_description_FR,
                    'terms_FR' => $electricResident->terms_FR,
                ]

            );
        }


        $this->info('Static Electricity Residential Backup completed');
    }
    /**
     * Backup Residential data Gas.
     *
     * @return void
     */
    private function _staticResidentialG()
    {
        $staticGasR = SGR::all();

        if (Session::get('backup-date')) {
            $backup = Session::get('backup-date');
        } else {
            $backup = Carbon::now();
            Session::put('backup', $backup);
        }

        foreach ($staticGasR as $gasResident) {
            StaticGasResidential::Create(
                [
                    '_id' => $gasResident->_id,
                    'product_id' => $gasResident->product_id,
                    'backupdate' => $backup,
                    'acticve' => $gasResident->acticve,
                    'partner' => $gasResident->partner,
                    'supplier' => $gasResident->supplier,
                    'product_name_NL' => $gasResident->product_name_NL,
                    'product_name_FR' => $gasResident->product_name_FR,
                    'fuel' => $gasResident->fuel,
                    'duration' => $gasResident->duration,
                    'fixed_indiable' => $gasResident->fixed_indiable,
                    'green_percentage' => $gasResident->green_percentage,
                    'origin' => $gasResident->origin,
                    'segment' => $gasResident->segment,
                    'VL' => $gasResident->VL,
                    'NA' => $gasResident->NA,
                    'BR' => $gasResident->BR,
                    'service_level_payment' => $gasResident->service_level_payment,
                    'service_level_invoicing' => $gasResident->service_level_invoicing,
                    'service_level_contact' => $gasResident->service_level_contact,
                    'FF_pro_rata' => $gasResident->FF_pro_rata,
                    'inv_period' => $gasResident->inv_period,
                    'customer_condition' => $gasResident->customer_condition,
                    'subscribe_url_NL' => $gasResident->subscribe_url_NL,
                    'info_NL' => $gasResident->info_NL,
                    'tariff_description_NL' => $gasResident->tariff_description_NL,
                    'terms_NL' => $gasResident->terms_NL,
                    'subscribe_url_FR' => $gasResident->subscribe_url_FR,
                    'info_FR' => $gasResident->info_FR,
                    'tariff_description_FR' => $gasResident->tariff_description_FR,
                    'terms_FR' => $gasResident->terms_FR,
                ]

            );
        }
        $this->info('Static Gas Residential Backup completed');
    }
}

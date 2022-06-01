<?php

namespace App\Console\Commands\History;

use App\Models\StaticElectricProfessional as SEP;
use App\Models\StaticGasProfessional as SGP;

use App\Models\History\StaticElectricProfessional;
use App\Models\History\StaticGasProfessional;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use DateTime;

use Illuminate\Console\Command;

class StaticProfessional extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'SProfessional:backup';

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
      $this->_staticProfessionalE();
      $this->_staticProfessionalG();
    } catch (\Exception $e) {
      return $e->getMessage();
    }
  }

  /**
   * Backup Professional data Electricity.
   *
   * @return void
   */

  private function _staticProfessionalE()
  {
    $staticElectricityP = SEP::all();

    if (Session::get('backup-date')) {
      $backup = Session::get('backup-date');
    } else {
      $backup = Carbon::now();
      Session::put('backup', $backup);
    }

    foreach ($staticElectricityP as $electricityP) {
      StaticElectricProfessional::Create(                 
        [
        '_id' => $electricityP->_id,
        'product_id' => $electricityP->product_id,
        'backupdate' =>$backup,
        'acticve' => $electricityP->acticve,
        'partner' => $electricityP->partner,
        'supplier' => $electricityP->supplier,
        'product_name_NL' => $electricityP->product_name_NL,
        'product_name_FR' => $electricityP->product_name_FR,
        'fuel' => $electricityP->fuel,
        'duration' => $electricityP->duration,
        'fixed_indiable' => $electricityP->fixed_indiable,
        'green_percentage' => $electricityP->green_percentage,
        'origin' => $electricityP->origin,
        'segment' => $electricityP->segment,
        'VL' => $electricityP->VL, 
        'WA' => $electricityP->WA,
        'BR' => $electricityP->BR,
        'service_level_payment' => $electricityP->service_level_payment,
        'service_level_invoicing' => $electricityP->service_level_invoicing,
        'service_level_contact' => $electricityP->service_level_contact,
        'FF_pro_rata' => $electricityP->FF_pro_rata,
        'inv_period' => $electricityP->inv_period,
        'customer_condition' => $electricityP->customer_condition,
        'subscribe_url_NL' => $electricityP->subscribe_url_NL,
        'info_NL' => $electricityP->info_NL,
        'tariff_description_NL' => $electricityP->tariff_description_NL,
        'terms_NL' => $electricityP->terms_NL,
        'subscribe_url_FR' => $electricityP->subscribe_url_FR,
        'info_FR' => $electricityP->info_FR,
        'tariff_description_FR' => $electricityP->tariff_description_FR,
        'terms_FR' => $electricityP->terms_FR,
        ]

    );
  }
    $this->info("Backup Static Electric Professional data");
  }

  /**
   * Backup Professional data Gas.
   *
   * @return void
   */
  private function _staticProfessionalG()
  {
    $staticGasP = SGP::all();

    if (Session::get('backup-date')) {
      $backup = Session::get('backup-date');
    } else {
      $backup = Carbon::now();
      Session::put('backup', $backup);
    }

    foreach ($staticGasP as $gasP) {
      StaticGasProfessional::Create(                 
        [
        '_id' => $gasP->_id,
        'product_id' => $gasP->product_id,
        'backupdate' =>$backup,
        'acticve' => $gasP->acticve,
        'partner' => $gasP->partner,
        'supplier' => $gasP->supplier,
        'product_name_NL' => $gasP->product_name_NL,
        'product_name_FR' => $gasP->product_name_FR,
        'fuel' => $gasP->fuel,
        'duration' => $gasP->duration,
        'fixed_indiable' => $gasP->fixed_indiable,
        'segment' => $gasP->segment,
        'VL' => $gasP->VL,
        'WA' => $gasP->WA,
        'BR' => $gasP->BR,
        'service_level_payment' => $gasP->service_level_payment,
        'service_level_invoicing' => $gasP->service_level_invoicing,
        'service_level_contact' => $gasP->service_level_contact,
        'FF_pro_rata' => $gasP->FF_pro_rata,
        'inv_period' => $gasP->inv_period,
        'customer_condition' => $gasP->customer_condition,
        'subscribe_url_NL' => $gasP->subscribe_url_NL,
        'info_NL' => $gasP->info_NL,
        'tariff_description_NL' => $gasP->tariff_description_NL,
        'terms_NL' => $gasP->terms_NL,
        'subscribe_url_FR' => $gasP->subscribe_url_FR,
        'info_FR' => $gasP->info_FR,
        'tariff_description_FR' => $gasP->tariff_description_FR,
        'terms_FR' => $gasP->terms_FR,
        ]

     );
    }
  }
}

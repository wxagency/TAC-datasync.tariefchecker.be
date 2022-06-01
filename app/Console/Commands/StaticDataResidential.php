<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\StaticElecticResidential;
use App\Models\StaticGasResidential;
use Carbon\Carbon;
use Session;

class StaticDataResidential extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'staticdata-residential:import';

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
      $this->alert('Fetching residential data from Airtable : ' . Carbon::now());
      $this->_electricityResidential();
      $this->_gasResidential();
      $this->comment('Completed at : ' . Carbon::now());
    } catch (Exception $ex) {
      return $ex->getMessage();
    }
  }

  private function _electricityResidential()
  {
    Session::put('offset', '0');
    StaticElecticResidential::truncate();
    while (Session::get('offset') != 'stop') {

      try {
        $client = new \GuzzleHttp\Client();
        $request = $client->get('https://api.airtable.com/v0/applSCRl4UvL2haqK/Stat%20data%20-%20E%20RES', [
          'headers' => [
            'Accept' => 'application/json',
            'Content-type' => 'application/json',
            'Authorization' => 'Bearer keySZo45QUBRPLwjL'
          ]
        ]);
      } catch (\Exception $e) {
        return $e->getCode();
      }

      $response = $request->getBody()->getContents();
      $json = json_decode($response, true);

      if (isset($json['offset'])) {
        Session::put('offset', $json['offset']);
      } else {
        Session::put('offset', 'stop');
      }
      foreach ($json['records'] as $static_elec_daata) {
        if (!empty($static_elec_daata['fields']['PROD ID'])) {
          if (isset($static_elec_daata['id'])) {
            $recordId = $static_elec_daata['id'];
          } else {
            $recordId = NULL;
          }
          if (isset($static_elec_daata['fields']['PROD ID'])) {
            $proid = $static_elec_daata['fields']['PROD ID'];
          } else {
            $proid = "";
          }

          if (isset($static_elec_daata['fields']['active'])) {
            $active = $static_elec_daata['fields']['active'];
          } else {
            $active = "";
          }

          if (isset($static_elec_daata['fields']['partner'])) {
            $partner = $static_elec_daata['fields']['partner'];
          } else {
            $partner = "";
          }

          if (isset($static_elec_daata['fields']['Supplier'])) {
            $Supplier = $static_elec_daata['fields']['Supplier'];
            $request = $client->get('https://api.airtable.com/v0/applSCRl4UvL2haqK/Stat%20data%20-%20E%20RES/' . $Supplier[0], [
              'headers' => [
                'Accept' => 'application/json',
                'Content-type' => 'application/json',
                'Authorization' => 'Bearer keySZo45QUBRPLwjL'
              ]

            ]);

            $response = $request->getBody()->getContents();
            $json = json_decode($response, true);
            $supply = $json['fields']['Commercial Name'];
          } else {
            $Supplier = "";
          }

          if (isset($static_elec_daata['fields']['Product Name NL'])) {
            $product_name_NL = $static_elec_daata['fields']['Product Name NL'];
          } else {
            $product_name_NL = "";
          }

          if (isset($static_elec_daata['fields']['Product Name FR'])) {
            $product_name_FR = $static_elec_daata['fields']['Product Name FR'];
          } else {
            $product_name_FR = "";
          }

          if (isset($static_elec_daata['fields']['Fuel'])) {
            $fuel = $static_elec_daata['fields']['Fuel'];
          } else {
            $fuel = "";
          }

          if (isset($static_elec_daata['fields']['Duration'])) {
            $duration = $static_elec_daata['fields']['Duration'];
          } else {
            $duration = "0";
          }

          if (isset($static_elec_daata['fields']['Price Type'])) {
            $fixed_indiable = $static_elec_daata['fields']['Price Type'];
          } else {
            $fixed_indiable = "";
          }

          if (isset($static_elec_daata['fields']['Green Percentage'])) {
            $green_percentage = $static_elec_daata['fields']['Green Percentage'];
          } else {
            $green_percentage = "";
          }

          if (isset($static_elec_daata['fields']['Origin'])) {
            $origin = $static_elec_daata['fields']['Origin'];
          } else {
            $origin = "";
          }

          if (isset($static_elec_daata['fields']['Segment'])) {
            $segment = $static_elec_daata['fields']['Segment'];
          } else {
            $segment = "";
          }

          if (isset($static_elec_daata['fields']['VL'])) {
            $vl = $static_elec_daata['fields']['VL'];
          } else {
            $vl = "";
          }

          if (isset($static_elec_daata['fields']['WA'])) {
            $wa = $static_elec_daata['fields']['WA'];
          } else {
            $wa = "";
          }

          if (isset($static_elec_daata['fields']['BR'])) {
            $br = $static_elec_daata['fields']['BR'];
          } else {
            $br = "";
          }

          if (isset($static_elec_daata['fields']['Servicelevel Payment'])) {
            $ser_pay = $static_elec_daata['fields']['Servicelevel Payment'];
          } else {
            $ser_pay = "";
          }

          if (isset($static_elec_daata['fields']['Servicelevel Invoicing'])) {
            $ser_inv = $static_elec_daata['fields']['Servicelevel Invoicing'];
          } else {
            $ser_inv = "";
          }

          if (isset($static_elec_daata['fields']['Servicelevel Invoicing'])) {
            $ser_inv = $static_elec_daata['fields']['Servicelevel Invoicing'];
          } else {
            $ser_inv = "";
          }

          if (isset($static_elec_daata['fields']['Servicelevel Contact'])) {
            $ser_contact = $static_elec_daata['fields']['Servicelevel Contact'];
          } else {
            $ser_contact = "";
          }

          if (isset($static_elec_daata['fields']['FF pro rata?'])) {
            $ff_pro_rata = $static_elec_daata['fields']['FF pro rata?'];
          } else {
            $ff_pro_rata = "";
          }

          if (isset($static_elec_daata['fields']['Inv period'])) {
            $inv_period = $static_elec_daata['fields']['Inv period'];
          } else {
            $inv_period = "0";
          }

          if (isset($static_elec_daata['fields']['Customer condition'])) {
            $cust_condition = $static_elec_daata['fields']['Customer condition'];
          } else {
            $cust_condition = "";
          }

          if (isset($static_elec_daata['fields']['Subscribe URL NL'])) {
            $sub_url_NL = $static_elec_daata['fields']['Subscribe URL NL'];
          } else {
            $sub_url_NL = "";
          }

          if (isset($static_elec_daata['fields']['Descr_Long_NL'])) {
            $info_NL = $static_elec_daata['fields']['Descr_Long_NL'];
          } else {
            $info_NL = "";
          }

          if (isset($static_elec_daata['fields']['Terms NL'])) {
            $terms_NL = $static_elec_daata['fields']['Terms NL'];
          } else {
            $terms_NL = "";
          }

          if (isset($static_elec_daata['fields']['Subscribe URL FR'])) {
            $sub_url_FR = $static_elec_daata['fields']['Subscribe URL FR'];
          } else {
            $sub_url_FR = "";
          }
          if (isset($static_elec_daata['fields']['Descr_Long_FR'])) {
            $info_FR = $static_elec_daata['fields']['Descr_Long_FR'];
          } else {
            $info_FR = "";
          }
          if (isset($static_elec_daata['fields']['Descr_Short_FR'])) {
            $Tariff_Description_FR = $static_elec_daata['fields']['Descr_Short_FR'];
          } else {
            $Tariff_Description_FR = "";
          }
          if (isset($static_elec_daata['fields']['Descr_Short_NL'])) {
            $Tariff_Description_NL = $static_elec_daata['fields']['Descr_Short_NL'];
          } else {
            $Tariff_Description_NL = "";
          }
          if (isset($static_elec_daata['fields']['Terms FR'])) {
            $Terms_FR = $static_elec_daata['fields']['Terms FR'];
          } else {
            $Terms_FR = "";
          }



          StaticElecticResidential::Create(
            ['product_id' => $proid,
              '_id' => $recordId,
              'acticve' => $active,
              'partner' => $partner,
              'supplier' => $supply,
              'product_name_NL' => $product_name_NL,
              'product_name_FR' => $product_name_FR,
              'fuel' => $fuel,
              'duration' => $duration,
              'fixed_indiable' => $fixed_indiable,
              'green_percentage' => $green_percentage,
              'origin' => $origin,
              'segment' => $segment,
              'VL' => $vl,
              'NA' => $wa,
              'BR' => $br,
              'service_level_payment' => $ser_pay,
              'service_level_invoicing' => $ser_inv,
              'service_level_contact' => $ser_contact,
              'FF_pro_rata' => $ff_pro_rata,
              'inv_period' => $inv_period,
              'customer_condition' => $cust_condition,
              'subscribe_url_NL' => $sub_url_NL,
              'info_NL' => $info_NL,
              'tariff_description_NL' => $Tariff_Description_NL,
              'terms_NL' => $terms_NL,
              'subscribe_url_FR' => $sub_url_FR,
              'info_FR' => $info_FR,
              'tariff_description_FR' => $Tariff_Description_FR,
              'terms_FR' => $Terms_FR,
            ]
          );
        }
      }
    }
  }

  private function _gasResidential()
  {
    Session::put('offset', '0');
    StaticGasResidential::truncate();
    while (Session::get('offset') != 'stop') {

      try {
        $client = new \GuzzleHttp\Client();
        $request = $client->get('https://api.airtable.com/v0/applSCRl4UvL2haqK/Stat%20data%20-%20G%20RES', [
          'headers' => [
            'Accept' => 'application/json',
            'Content-type' => 'application/json',
            'Authorization' => 'Bearer keySZo45QUBRPLwjL'
          ]
        ]);
      } catch (\Exception $e) {
        return $e->getCode();
      }

      $response = $request->getBody()->getContents();
      $json = json_decode($response, true);

      if (isset($json['offset'])) {
        Session::put('offset', $json['offset']);
      } else {
        Session::put('offset', 'stop');
      }

      foreach ($json['records'] as $static_daata) {
        if (!empty($static_daata['fields']['PROD ID'])) {
          if (isset($static_daata['id'])) {
            $recordId = $static_daata['id'];
          } else {
            $recordId = NULL;
          }

          if (isset($static_daata['fields']['PROD ID'])) {
            $proid = $static_daata['fields']['PROD ID'];
          } else {
            $proid = "";
          }

          if (isset($static_daata['fields']['active'])) {
            $active = $static_daata['fields']['active'];
          } else {
            $active = "";
          }

          if (isset($static_daata['fields']['partner'])) {
            $partner = $static_daata['fields']['partner'];
          } else {
            $partner = "";
          }

          if (isset($static_daata['fields']['Supplier'])) {
            $Supplier = $static_daata['fields']['Supplier'];
            $request = $client->get('https://api.airtable.com/v0/applSCRl4UvL2haqK/Stat%20data%20-%20G%20RES/' . $Supplier[0], [
              'headers' => [
                'Accept' => 'application/json',
                'Content-type' => 'application/json',
                'Authorization' => 'Bearer keySZo45QUBRPLwjL'
              ]

            ]);

            $response = $request->getBody()->getContents();
            $json = json_decode($response, true);
            $supply = $json['fields']['Commercial Name'];
          } else {
            $Supplier = "";
          }

          if (isset($static_daata['fields']['Product Name NL'])) {
            $product_name_NL = $static_daata['fields']['Product Name NL'];
          } else {
            $product_name_NL = "";
          }

          if (isset($static_daata['fields']['Product Name FR'])) {
            $product_name_FR = $static_daata['fields']['Product Name FR'];
          } else {
            $product_name_FR = "";
          }

          if (isset($static_daata['fields']['Fuel'])) {
            $fuel = $static_daata['fields']['Fuel'];
          } else {
            $fuel = "";
          }

          if (isset($static_daata['fields']['Duration'])) {
            $duration = $static_daata['fields']['Duration'];
          } else {
            $duration = "0";
          }

          if (isset($static_daata['fields']['Price Type'])) {
            $fixed_indiable = $static_daata['fields']['Price Type'];
          } else {
            $fixed_indiable = "";
          }

          if (isset($static_daata['fields']['Segment'])) {
            $segment = $static_daata['fields']['Segment'];
          } else {
            $segment = "";
          }

          if (isset($static_daata['fields']['VL'])) {
            $vl = $static_daata['fields']['VL'];
          } else {
            $vl = "";
          }

          if (isset($static_daata['fields']['WA'])) {
            $wa = $static_daata['fields']['WA'];
          } else {
            $wa = "";
          }

          if (isset($static_daata['fields']['BR'])) {
            $br = $static_daata['fields']['BR'];
          } else {
            $br = "";
          }

          if (isset($static_daata['fields']['Servicelevel Payment'])) {
            $ser_pay = $static_daata['fields']['Servicelevel Payment'];
          } else {
            $ser_pay = "";
          }

          if (isset($static_daata['fields']['Servicelevel Invoicing'])) {
            $ser_inv = $static_daata['fields']['Servicelevel Invoicing'];
          } else {
            $ser_inv = "";
          }

          if (isset($static_daata['fields']['Servicelevel Invoicing'])) {
            $ser_inv = $static_daata['fields']['Servicelevel Invoicing'];
          } else {
            $ser_inv = "";
          }

          if (isset($static_daata['fields']['Servicelevel Contact'])) {
            $ser_contact = $static_daata['fields']['Servicelevel Contact'];
          } else {
            $ser_contact = "";
          }

          if (isset($static_daata['fields']['FF pro rata?'])) {
            $ff_pro_rata = $static_daata['fields']['FF pro rata?'];
          } else {
            $ff_pro_rata = "";
          }

          if (isset($static_daata['fields']['Inv period'])) {
            $inv_period = $static_daata['fields']['Inv period'];
          } else {
            $inv_period = "0";
          }

          if (isset($static_daata['fields']['Customer condition'])) {
            $cust_condition = $static_daata['fields']['Customer condition'];
          } else {
            $cust_condition = "";
          }

          if (isset($static_daata['fields']['Subscribe URL NL'])) {
            $sub_url_NL = $static_daata['fields']['Subscribe URL NL'];
          } else {
            $sub_url_NL = "";
          }

          if (isset($static_daata['fields']['Descr_Long_NL'])) {
            $info_NL = $static_daata['fields']['Descr_Long_NL'];
          } else {
            $info_NL = "";
          }

          if (isset($static_daata['fields']['Descr_Short_NL'])) {
            $Tariff_Description_NL = $static_daata['fields']['Descr_Short_NL'];
          } else {
            $Tariff_Description_NL = "";
          }

          if (isset($static_daata['fields']['Terms NL'])) {
            $terms_NL = $static_daata['fields']['Terms NL'];
          } else {
            $terms_NL = "";
          }

          if (isset($static_daata['fields']['Subscribe URL FR'])) {
            $sub_url_FR = $static_daata['fields']['Subscribe URL FR'];
          } else {
            $sub_url_FR = "";
          }
          if (isset($static_daata['fields']['Descr_Long_FR'])) {
            $info_FR = $static_daata['fields']['Descr_Long_FR'];
          } else {
            $info_FR = "";
          }
          if (isset($static_daata['fields']['Descr_Short_FR'])) {
            $Tariff_Description_FR = $static_daata['fields']['Descr_Short_FR'];
          } else {
            $Tariff_Description_FR = "";
          }
          if (isset($static_daata['fields']['Terms FR'])) {
            $Terms_FR = $static_daata['fields']['Terms FR'];
          } else {
            $Terms_FR = "";
          }




          StaticGasResidential::Create(
            ['product_id' => $proid,
              '_id' => $recordId,
              'acticve' => $active,
              'partner' => $partner,
              'supplier' => $supply,
              'product_name_NL' => $product_name_NL,
              'product_name_FR' => $product_name_FR,
              'fuel' => $fuel,
              'duration' => $duration,
              'fixed_indiable' => $fixed_indiable,
              'segment' => $segment,
              'VL' => $vl,
              'NA' => $wa,
              'BR' => $br,
              'service_level_payment' => $ser_pay,
              'service_level_invoicing' => $ser_inv,
              'service_level_contact' => $ser_contact,
              'FF_pro_rata' => $ff_pro_rata,
              'inv_period' => $inv_period,
              'customer_condition' => $cust_condition,
              'subscribe_url_NL' => $sub_url_NL,
              'info_NL' => $info_NL,
              'tariff_description_NL' => $Tariff_Description_NL,
              'terms_NL' => $terms_NL,
              'subscribe_url_FR' => $sub_url_FR,
              'info_FR' => $info_FR,
              'tariff_description_FR' => $Tariff_Description_FR,
              'terms_FR' => $Terms_FR,
            ]
          );
        }
      }
    }
  }
}

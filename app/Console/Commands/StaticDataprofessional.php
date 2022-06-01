<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\StaticElectricProfessional;
use App\Models\StaticGasProfessional;
use Session;
use Carbon\Carbon;


class StaticDataprofessional extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'staticdata-professional:import';

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
      $this->alert('Fetching professional data from Airtable : ' . Carbon::now());
      $this->_electricityProfessional();
      $this->_gasProfessional();
      $this->comment('Completed at : ' . Carbon::now());
    } catch (Exception $ex) {
      return $ex->getMessage();
    }
  }

  private function _electricityProfessional()
  {
    Session::put('offset', '0');
    StaticElectricProfessional::truncate();
    while (Session::get('offset') != 'stop') {

      try {
        $client = new \GuzzleHttp\Client();
        $request = $client->get('https://api.airtable.com/v0/applSCRl4UvL2haqK/Stat%20data%20-%20E%20PRO', [
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

      foreach ($json['records'] as $static_pro) {
        if (!empty($static_pro['fields']['PROD ID'])) {
          if (isset($static_pro['id'])) {
            $recordId = $static_pro['id'];
          } else {
            $recordId = NULL;
          }
          if (isset($static_pro['fields']['PROD ID'])) {
            $proid = $static_pro['fields']['PROD ID'];
          } else {
            $proid = "";
          }

          if (isset($static_pro['fields']['Active'])) {
            $active = $static_pro['fields']['Active'];
          } else {
            $active = "";
          }

          if (isset($static_pro['fields']['Partner'])) {
            $partner = $static_pro['fields']['Partner'];
          } else {
            $partner = "";
          }

          if (isset($static_pro['fields']['Supplier'])) {
            $Supplier = $static_pro['fields']['Supplier'];
            $request = $client->get('https://api.airtable.com/v0/applSCRl4UvL2haqK/Stat%20data%20-%20E%20PRO/' . $Supplier[0], [
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

          if (isset($static_pro['fields']['Product Name NL'])) {
            $product_name_NL = $static_pro['fields']['Product Name NL'];
          } else {
            $product_name_NL = "";
          }

          if (isset($static_pro['fields']['Product Name FR'])) {
            $product_name_FR = $static_pro['fields']['Product Name FR'];
          } else {
            $product_name_FR = "";
          }

          if (isset($static_pro['fields']['Fuel'])) {
            $fuel = $static_pro['fields']['Fuel'];
          } else {
            $fuel = "";
          }

          if (isset($static_pro['fields']['Duration'])) {
            $duration = $static_pro['fields']['Duration'];
          } else {
            $duration = "0";
          }

          if (isset($static_pro['fields']['Price Type'])) {
            $fixed_indiable = $static_pro['fields']['Price Type'];
          } else {
            $fixed_indiable = "";
          }

          if (isset($static_pro['fields']['Green Percentage'])) {
            $green_percentage = $static_pro['fields']['Green Percentage'];
          } else {
            $green_percentage = "";
          }

          if (isset($static_pro['fields']['Origin'])) {
            $origin = $static_pro['fields']['Origin'];
          } else {
            $origin = "";
          }

          if (isset($static_pro['fields']['Segment'])) {
            $segment = $static_pro['fields']['Segment'];
          } else {
            $segment = "";
          }

          if (isset($static_pro['fields']['VL'])) {
            $vl = $static_pro['fields']['VL'];
          } else {
            $vl = "";
          }

          if (isset($static_pro['fields']['WA'])) {
            $wa = $static_pro['fields']['WA'];
          } else {
            $wa = "";
          }

          if (isset($static_pro['fields']['BR'])) {
            $br = $static_pro['fields']['BR'];
          } else {
            $br = "";
          }

          if (isset($static_pro['fields']['Servicelevel Payment'])) {
            $ser_pay = $static_pro['fields']['Servicelevel Payment'];
          } else {
            $ser_pay = "";
          }

          if (isset($static_pro['fields']['Servicelevel Invoicing'])) {
            $ser_inv = $static_pro['fields']['Servicelevel Invoicing'];
          } else {
            $ser_inv = "";
          }

          if (isset($static_pro['fields']['Servicelevel Invoicing'])) {
            $ser_inv = $static_pro['fields']['Servicelevel Invoicing'];
          } else {
            $ser_inv = "";
          }

          if (isset($static_pro['fields']['Servicelevel Contact'])) {
            $ser_contact = $static_pro['fields']['Servicelevel Contact'];
          } else {
            $ser_contact = "";
          }

          if (isset($static_pro['fields']['FF pro rata?'])) {
            $ff_pro_rata = $static_pro['fields']['FF pro rata?'];
          } else {
            $ff_pro_rata = "";
          }

          if (isset($static_pro['fields']['Inv period'])) {
            $inv_period = $static_pro['fields']['Inv period'];
          } else {
            $inv_period = "0";
          }

          if (isset($static_pro['fields']['Customer condition'])) {
            $cust_condition = $static_pro['fields']['Customer condition'];
          } else {
            $cust_condition = "";
          }

          if (isset($static_pro['fields']['Subscribe URL NL'])) {
            $sub_url_NL = $static_pro['fields']['Subscribe URL NL'];
          } else {
            $sub_url_NL = "";
          }

          if (isset($static_pro['fields']['Descr_Long_NL'])) {
            $info_NL = $static_pro['fields']['Descr_Long_NL'];
          } else {
            $info_NL = "";
          }
          if (isset($static_pro['fields']['Descr_Short_NL'])) {
            $Tariff_Description_NL = $static_pro['fields']['Descr_Short_NL'];
          } else {
            $Tariff_Description_NL = "";
          }

          if (isset($static_pro['fields']['Terms NL'])) {
            $terms_NL = $static_pro['fields']['Terms NL'];
          } else {
            $terms_NL = "";
          }

          if (isset($static_pro['fields']['Subscribe URL FR'])) {
            $sub_url_FR = $static_pro['fields']['Subscribe URL FR'];
          } else {
            $sub_url_FR = "";
          }
          if (isset($static_pro['fields']['Descr_Long_FR'])) {
            $info_FR = $static_pro['fields']['Descr_Long_FR'];
          } else {
            $info_FR = "";
          }
          if (isset($static_pro['fields']['Descr_Short_FR'])) {
            $Tariff_Description_FR = $static_pro['fields']['Descr_Short_FR'];
          } else {
            $Tariff_Description_FR = "";
          }
          if (isset($static_pro['fields']['Terms FR'])) {
            $Terms_FR = $static_pro['fields']['Terms FR'];
          } else {
            $Terms_FR = "";
          }


          StaticElectricProfessional::Create(
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
              'WA' => $wa,
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
              'terms_FR' => $Terms_FR
            ]
          );
        }
      }
    }
  }

  private function _gasProfessional()
  {
    Session::put('offset', '0');
    StaticGasProfessional::truncate();
    while (Session::get('offset') != 'stop') {


      try {
        $client = new \GuzzleHttp\Client();
        $request = $client->get('https://api.airtable.com/v0/applSCRl4UvL2haqK/Stat%20data%20-%20G%20PRO', [
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

      foreach ($json['records'] as $static_pro) {
        if (!empty($static_pro['fields']['PROD ID'])) {
          if (isset($static_pro['id'])) {
            $recordId = $static_pro['id'];
          } else {
            $recordId = NULL;
          }
          if (isset($static_pro['fields']['PROD ID'])) {
            $proid = $static_pro['fields']['PROD ID'];
          } else {
            $proid = "";
          }

          if (isset($static_pro['fields']['Active'])) {
            $active = $static_pro['fields']['Active'];
          } else {
            $active = "";
          }

          if (isset($static_pro['fields']['Partner'])) {
            $partner = $static_pro['fields']['Partner'];
          } else {
            $partner = "";
          }

          if (isset($static_pro['fields']['Supplier'])) {
            $Supplier = $static_pro['fields']['Supplier'];
            $request = $client->get('https://api.airtable.com/v0/applSCRl4UvL2haqK/Stat%20data%20-%20G%20PRO/' . $Supplier[0], [
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

          if (isset($static_pro['fields']['Product Name NL'])) {
            $product_name_NL = $static_pro['fields']['Product Name NL'];
          } else {
            $product_name_NL = "";
          }

          if (isset($static_pro['fields']['Product Name FR'])) {
            $product_name_FR = $static_pro['fields']['Product Name FR'];
          } else {
            $product_name_FR = "";
          }

          if (isset($static_pro['fields']['Fuel'])) {
            $fuel = $static_pro['fields']['Fuel'];
          } else {
            $fuel = "";
          }

          if (isset($static_pro['fields']['Duration'])) {
            $duration = $static_pro['fields']['Duration'];
          } else {
            $duration = "0";
          }

          if (isset($static_pro['fields']['Price Type'])) {
            $fixed_indiable = $static_pro['fields']['Price Type'];
          } else {
            $fixed_indiable = "";
          }

          if (isset($static_pro['fields']['Segment'])) {
            $segment = $static_pro['fields']['Segment'];
          } else {
            $segment = "";
          }

          if (isset($static_pro['fields']['VL'])) {
            $vl = $static_pro['fields']['VL'];
          } else {
            $vl = "";
          }

          if (isset($static_pro['fields']['WA'])) {
            $wa = $static_pro['fields']['WA'];
          } else {
            $wa = "";
          }

          if (isset($static_pro['fields']['BR'])) {
            $br = $static_pro['fields']['BR'];
          } else {
            $br = "";
          }

          if (isset($static_pro['fields']['Servicelevel Payment'])) {
            $ser_pay = $static_pro['fields']['Servicelevel Payment'];
          } else {
            $ser_pay = "";
          }

          if (isset($static_pro['fields']['Servicelevel Invoicing'])) {
            $ser_inv = $static_pro['fields']['Servicelevel Invoicing'];
          } else {
            $ser_inv = "";
          }

          if (isset($static_pro['fields']['Servicelevel Invoicing'])) {
            $ser_inv = $static_pro['fields']['Servicelevel Invoicing'];
          } else {
            $ser_inv = "";
          }

          if (isset($static_pro['fields']['Servicelevel Contact'])) {
            $ser_contact = $static_pro['fields']['Servicelevel Contact'];
          } else {
            $ser_contact = "";
          }

          if (isset($static_pro['fields']['FF pro rata?'])) {
            $ff_pro_rata = $static_pro['fields']['FF pro rata?'];
          } else {
            $ff_pro_rata = "";
          }

          if (isset($static_pro['fields']['Inv period'])) {
            $inv_period = $static_pro['fields']['Inv period'];
          } else {
            $inv_period = "0";
          }

          if (isset($static_pro['fields']['Customer condition'])) {
            $cust_condition = $static_pro['fields']['Customer condition'];
          } else {
            $cust_condition = "";
          }

          if (isset($static_pro['fields']['Subscribe URL NL'])) {
            $sub_url_NL = $static_pro['fields']['Subscribe URL NL'];
          } else {
            $sub_url_NL = "";
          }

          if (isset($static_pro['fields']['Descr_Long_NL'])) {
            $info_NL = $static_pro['fields']['Descr_Long_NL'];
          } else {
            $info_NL = "";
          }
          if (isset($static_pro['fields']['Descr_Short_NL'])) {
            $Tariff_Description_NL = $static_pro['fields']['Descr_Short_NL'];
          } else {
            $Tariff_Description_NL = "";
          }

          if (isset($static_pro['fields']['Terms NL'])) {
            $terms_NL = $static_pro['fields']['Terms NL'];
          } else {
            $terms_NL = "";
          }

          if (isset($static_pro['fields']['Subscribe URL FR'])) {
            $sub_url_FR = $static_pro['fields']['Subscribe URL FR'];
          } else {
            $sub_url_FR = "";
          }
          if (isset($static_pro['fields']['Descr_Long_FR'])) {
            $info_FR = $static_pro['fields']['Descr_Long_FR'];
          } else {
            $info_FR = "";
          }
          if (isset($static_pro['fields']['Descr_Short_FR'])) {
            $Tariff_Description_FR = $static_pro['fields']['Descr_Short_FR'];
          } else {
            $Tariff_Description_FR = "";
          }
          if (isset($static_pro['fields']['Terms FR'])) {
            $Terms_FR = $static_pro['fields']['Terms FR'];
          } else {
            $Terms_FR = "";
          }


          StaticGasProfessional::Create(
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
              'WA' => $wa,
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
              'terms_FR' => $Terms_FR
            ]
          );
        }
      }
    }
  }
}

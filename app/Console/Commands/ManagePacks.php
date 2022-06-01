<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\StaticPackResidential;
use App\Models\StaticPackProfessional;
use Carbon\Carbon;
use Session;

class ManagePacks extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'packs:import';

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
      $this->alert('Fetching Packs from Airtable : ' . Carbon::now());
      $this->_packResidential();
      $this->_packProfessional();
      $this->comment('Completed at : ' . Carbon::now());
    } catch (Exception $ex) {
      return $ex->getMessage();
    }
  }

  private function _packResidential()
  {
    Session::put('offset', '0');
    StaticPackResidential::truncate();
    while (Session::get('offset') != 'stop') {

      try {
        $client = new \GuzzleHttp\Client();
        $query['pageSize'] = 100;
        $query['offset'] = Session::get('offset');
        $request = $client->get('https://api.airtable.com/v0/applSCRl4UvL2haqK/Stat%20data%20-%20Packs%20RES', [
          'headers' => [
            'Accept' => 'application/json',
            'Content-type' => 'application/json',
            'Authorization' => 'Bearer keySZo45QUBRPLwjL'
          ],
          'query' => $query

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

      foreach ($json['records'] as $pack_res) {
        if (!empty($pack_res['fields']['PACK ID'])) {
          if (isset($pack_res['id'])) {
            $recordId = $pack_res['id'];
          } else {
            $recordId = NULL;
          }

          if (isset($pack_res['fields']['PACK ID'])) {
            $pack_id = $pack_res['fields']['PACK ID'];
          } else {
            $pack_id = "";
          }

          if (isset($pack_res['fields']['Pack Name NL'])) {
            $pack_name_nl = $pack_res['fields']['Pack Name NL'];
          } else {
            $pack_name_nl = "";
          }

          if (isset($pack_res['fields']['PACK NAME FR'])) {
            $pack_name_fr = $pack_res['fields']['PACK NAME FR'];
          } else {
            $pack_name_fr = "";
          }

          if (isset($pack_res['fields']['Active'])) {
            $Active = $pack_res['fields']['Active'];
          } else {
            $Active = "";
          }

          if (isset($pack_res['fields']['Partner'])) {
            $Partner = $pack_res['fields']['Partner'];
          } else {
            $Partner = "";
          }

          if (isset($pack_res['fields']['PROD ID E'])) {
            $pro_id_e = $pack_res['fields']['PROD ID E'];
            $request = $client->get('https://api.airtable.com/v0/applSCRl4UvL2haqK/Stat%20data%20-%20Packs%20RES/' . $pro_id_e[0], [
              'headers' => [
                'Accept' => 'application/json',
                'Content-type' => 'application/json',
                'Authorization' => 'Bearer keySZo45QUBRPLwjL'
              ]

            ]);

            $response = $request->getBody()->getContents();
            $json = json_decode($response, true);
            $product_e = $json['fields']['PROD ID'];
          } else {
            $pro_id_e = "";
          }

          if (isset($pack_res['fields']['PROD ID G'])) {
            $pro_id_g = $pack_res['fields']['PROD ID G'];
            $request = $client->get('https://api.airtable.com/v0/applSCRl4UvL2haqK/Stat%20data%20-%20Packs%20RES/' . $pro_id_g[0], [
              'headers' => [
                'Accept' => 'application/json',
                'Content-type' => 'application/json',
                'Authorization' => 'Bearer keySZo45QUBRPLwjL'
              ]

            ]);

            $response = $request->getBody()->getContents();
            $json = json_decode($response, true);
            $product_g = $json['fields']['PROD ID'];
          } else {
            $pro_id_g = "";
          }
          if (isset($pack_res['fields']['URL NL'])) {
            $url_nl = $pack_res['fields']['URL NL'];
          } else {
            $url_nl = "";
          }


          if (isset($pack_res['fields']['Descr_Long_NL'])) {
            $info_nl = $pack_res['fields']['Descr_Long_NL'];
          } else {
            $info_nl = "";
          }
          if (isset($pack_res['fields']['Descr_Short_NL'])) {
            $Tariff_Description_NL = $pack_res['fields']['Descr_Short_NL'];
          } else {
            $Tariff_Description_NL = "";
          }

          if (isset($pack_res['fields']['URL FR'])) {
            $url_fr = $pack_res['fields']['URL FR'];
          } else {
            $url_fr = "";
          }

          if (isset($pack_res['fields']['Descr_Long_FR'])) {
            $info_fr = $pack_res['fields']['Descr_Long_FR'];
          } else {
            $info_fr = "0";
          }

          if (isset($pack_res['fields']['Descr_Short_FR'])) {
            $Tariff_Description_FR = $pack_res['fields']['Descr_Short_FR'];
          } else {
            $Tariff_Description_FR = "";
          }

          if (isset($pack_res['fields']['check elek'])) {
            $check_elec = $pack_res['fields']['check elek'];
          } else {
            $check_elec = "";
          }

          if (isset($pack_res['fields']['check gas'])) {
            $check_gas = $pack_res['fields']['check gas'];
          } else {
            $check_gas = "";
          }
          
          StaticPackResidential::create(
            ['pack_id' => $pack_id,
              '_id' => $recordId,
              'pack_name_NL' => $pack_name_nl,
              'pack_name_FR' => $pack_name_fr,
              'active' => $Active,
              'partner' => $Partner,
              'pro_id_E' => $product_e,
              'pro_id_G' => $product_g,
              'URL_NL' => $url_nl,
              'info_NL' => $info_nl,
              'tariff_description_NL' => $Tariff_Description_NL,
              'URL_FR' => $url_fr,
              'info_FR' => $info_fr,
              'tariff_description_FR' => $Tariff_Description_FR,
              'check_elec' => $check_elec,
              'check_gas' => $check_gas,
            ]
          );
        }
      }
    }
  }

  private function _packProfessional()
  {
    Session::put('offset', '0');
    StaticPackProfessional::truncate();
    while (Session::get('offset') != 'stop') {

      try {
        $client = new \GuzzleHttp\Client();
        $query['pageSize'] = 100;
        $query['offset'] = Session::get('offset');
        $request = $client->get('https://api.airtable.com/v0/applSCRl4UvL2haqK/Stat%20data%20-%20Packs%20PRO', [
          'headers' => [
            'Accept' => 'application/json',
            'Content-type' => 'application/json',
            'Authorization' => 'Bearer keySZo45QUBRPLwjL'
          ],
          'query' => $query

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

      foreach ($json['records'] as $packPro) {
        if (!empty($packPro['fields']['PACK ID'])) {
          if (isset($packPro['id'])) {
            $recordId = $packPro['id'];
          } else {
            $recordId = NULL;
          }
          if (isset($packPro['fields']['PACK ID'])) {
            $pack_id = $packPro['fields']['PACK ID'];
          } else {
            $pack_id = "";
          }

          if (isset($packPro['fields']['PACK NAME NL'])) {
            $pack_name_nl = $packPro['fields']['PACK NAME NL'];
          } else {
            $pack_name_nl = "";
          }

          if (isset($packPro['fields']['PACK NAME FR'])) {
            $pack_name_fr = $packPro['fields']['PACK NAME FR'];
          } else {
            $pack_name_fr = "";
          }

          if (isset($packPro['fields']['Active'])) {
            $Active = $packPro['fields']['Active'];
          } else {
            $Active = "";
          }

          if (isset($packPro['fields']['Partner'])) {
            $Partner = $packPro['fields']['Partner'];
          } else {
            $Partner = "";
          }

          if (isset($packPro['fields']['PROD ID E'])) {
            $pro_id_e = $packPro['fields']['PROD ID E'];
            $request = $client->get('https://api.airtable.com/v0/applSCRl4UvL2haqK/Stat%20data%20-%20Packs%20PRO/' . $pro_id_e[0], [
              'headers' => [
                'Accept' => 'application/json',
                'Content-type' => 'application/json',
                'Authorization' => 'Bearer keySZo45QUBRPLwjL'
              ]

            ]);

            $response = $request->getBody()->getContents();
            $json = json_decode($response, true);
            $product_e = $json['fields']['PROD ID'];
          } else {
            $pro_id_e = "";
          }

          if (isset($packPro['fields']['PROD ID G'])) {
            $pro_id_g = $packPro['fields']['PROD ID G'];
            $request = $client->get('https://api.airtable.com/v0/applSCRl4UvL2haqK/Stat%20data%20-%20Packs%20PRO/' . $pro_id_g[0], [
              'headers' => [
                'Accept' => 'application/json',
                'Content-type' => 'application/json',
                'Authorization' => 'Bearer keySZo45QUBRPLwjL'
              ]

            ]);

            $response = $request->getBody()->getContents();
            $json = json_decode($response, true);
            $product_g = $json['fields']['PROD ID'];
          } else {
            $pro_id_g = "";
          }
          if (isset($packPro['fields']['URL NL'])) {
            $url_nl = $packPro['fields']['URL NL'];
          } else {
            $url_nl = "";
          }
          if (isset($packPro['fields']['Descr_Long_NL'])) {
            $info_nl = $packPro['fields']['Descr_Long_NL'];
          } else {
            $info_nl = "";
          }
          if (isset($packPro['fields']['Descr_Short_NL'])) {
            $Tariff_Description_NL = $packPro['fields']['Descr_Short_NL'];
          } else {
            $Tariff_Description_NL = "";
          }
          if (isset($packPro['fields']['URL FR'])) {
            $url_fr = $packPro['fields']['URL FR'];
          } else {
            $url_fr = "";
          }
          if (isset($packPro['fields']['Descr_Long_FR'])) {
            $info_fr = $packPro['fields']['Descr_Long_FR'];
          } else {
            $info_fr = "0";
          }
          if (isset($packPro['fields']['Descr_Short_FR'])) {
            $Tariff_Description_FR = $packPro['fields']['Descr_Short_FR'];
          } else {
            $Tariff_Description_FR = "";
          }
          if (isset($packPro['fields']['check E'])) {
            $check_elec = $packPro['fields']['check E'];
          } else {
            $check_elec = "";
          }

          if (isset($packPro['fields']['check G'])) {
            $check_gas = $packPro['fields']['check G'];
          } else {
            $check_gas = "";
          }
          
          StaticPackProfessional::create(
            ['pack_id' => $pack_id,
              '_id' => $recordId,
              'pack_name_NL' => $pack_name_nl,
              'pack_name_FR' => $pack_name_fr,
              'active' => $Active,
              'partner' => $Partner,
              'pro_id_E' => $product_e,
              'pro_id_G' => $product_g,
              'URL_NL' => $url_nl,
              'info_NL' => $info_nl,
              'tariff_description_NL' => $Tariff_Description_NL,
              'URL_FR' => $url_fr,
              'info_FR' => $info_fr,
              'tariff_description_FR' => $Tariff_Description_FR,
              'check_elec' => $check_elec,
              'check_gas' => $check_gas,
            ]
          );
        }
      }
    }
  }
}

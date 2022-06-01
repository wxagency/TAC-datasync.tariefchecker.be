<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PostalcodeElectricity;
use App\Models\PostalcodeGas;
use Carbon\Carbon;
use Session;

class PostalCode extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'postalcode:import';

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
      $this->alert('Fetching postalcodes from Airtable : ' . Carbon::now());
      $this->_managePostalcodeElectricity();
      $this->_managePostalcodeGas();
      $this->comment('Completed at : ' . Carbon::now());
    } catch (Exception $ex) {
      return $ex->getMessage();
    }
  }

  private function _managePostalcodeElectricity()
  {
    PostalcodeElectricity::truncate();
    Session::put('offset', '0');

    while (Session::get('offset') != 'stop') {

      try {
        $client = new \GuzzleHttp\Client();
        $query['pageSize'] = 100;
        $query['offset'] = Session::get('offset');
        $request = $client->get('https://api.airtable.com/v0/applSCRl4UvL2haqK/Postal%20Code%20-%20DGO%20-%20E', [
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

      foreach ($json['records'] as $post_elec) {
        if (!empty($post_elec['fields']['netadmin_zip'])) {
          if (isset($post_elec['id'])) {
            $recordId = $post_elec['id'];
          } else {
            $recordId = NULL;
          }
          if (isset($post_elec['fields']['distributor_id'])) {
            $distributor_id = $post_elec['fields']['distributor_id'];
          } else {
            $distributor_id = "";
          }

          if (isset($post_elec['fields']['netadmin_zip'])) {
            $netadmin_zip = $post_elec['fields']['netadmin_zip'];
          } else {
            $netadmin_zip = "";
          }

          if (isset($post_elec['fields']['netadmin_city'])) {
            $netadmin_city = $post_elec['fields']['netadmin_city'];
          } else {
            $netadmin_city = "";
          }

          if (isset($post_elec['fields']['netadmin_city'])) {
            $netadmin_city = $post_elec['fields']['netadmin_city'];
          } else {
            $netadmin_city = "";
          }

          if (isset($post_elec['fields']['netadmin_subcity'])) {
            $netadmin_subcity = $post_elec['fields']['netadmin_subcity'];
          } else {
            $netadmin_subcity = "";
          }

          if (isset($post_elec['fields']['product'])) {
            $product = $post_elec['fields']['product'];
          } else {
            $product = "";
          }

          if (isset($post_elec['fields']['Grid_operational'])) {
            $Grid_operational = $post_elec['fields']['Grid_operational'];
          } else {
            $Grid_operational = "";
          }
          if (isset($post_elec['fields']['gas_H_L'])) {
            $gas_H_L = $post_elec['fields']['gas_H_L'];
          } else {
            $gas_H_L = "";
          }


          if (isset($post_elec['fields']['DGO'])) {
            $DGO = $post_elec['fields']['DGO'];
          } else {
            $DGO = "";
          }

          if (isset($post_elec['fields']['netadmin_website'])) {
            $netadmin_website = $post_elec['fields']['netadmin_website'];
          } else {
            $netadmin_website = "0";
          }

          if (isset($post_elec['fields']['TNB'])) {
            $TNB = $post_elec['fields']['TNB'];
          } else {
            $TNB = "";
          }

          if (isset($post_elec['fields']['REGION'])) {
            $region = $post_elec['fields']['REGION'];
          } else {
            $region = "";
          }

          if (isset($post_elec['fields']['language_code'])) {
            $language_code = $post_elec['fields']['language_code'];
          } else {
            $language_code = "";
          }

          PostalcodeElectricity::create(
            [
              '_id' => $recordId,
              'distribution_id' => $distributor_id,
              'netadmin_zip' => $netadmin_zip,
              'netadmin_city' => $netadmin_city,
              'netadmin_subcity' => $netadmin_subcity,
              'product' => $product,
              'grid_operational' => $Grid_operational,
              'gas_H_L' => $gas_H_L,
              'DNB' => $DGO,
              'netadmin_website' => $netadmin_website,
              'TNB' => $TNB,
              'language_code' => $language_code,
              'region' => $region,

            ]
          );
        }
      }
    }
  }

  private function _managePostalcodeGas()
  {
    PostalcodeGas::truncate();
    Session::put('offset', '0');

    while (Session::get('offset') != 'stop') {

      try {
        $client = new \GuzzleHttp\Client();
        $query['pageSize'] = 100;
        $query['offset'] = Session::get('offset');
        $request = $client->get('https://api.airtable.com/v0/applSCRl4UvL2haqK/Postal%20Code%20-%20DGO%20-%20G', [
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

      foreach ($json['records'] as $post_elec) {
        if (!empty($post_elec['fields']['netadmin_zip'])) {
          if (isset($post_elec['id'])) {
            $recordId = $post_elec['id'];
          } else {
            $recordId = NULL;
          }
          if (isset($post_elec['fields']['distributor_id'])) {
            $distributor_id = $post_elec['fields']['distributor_id'];
          } else {
            $distributor_id = "";
          }

          if (isset($post_elec['fields']['netadmin_zip'])) {
            $netadmin_zip = $post_elec['fields']['netadmin_zip'];
          } else {
            $netadmin_zip = "";
          }

          if (isset($post_elec['fields']['netadmin_city'])) {
            $netadmin_city = $post_elec['fields']['netadmin_city'];
          } else {
            $netadmin_city = "";
          }

          if (isset($post_elec['fields']['netadmin_city'])) {
            $netadmin_city = $post_elec['fields']['netadmin_city'];
          } else {
            $netadmin_city = "";
          }

          if (isset($post_elec['fields']['netadmin_subcity'])) {
            $netadmin_subcity = $post_elec['fields']['netadmin_subcity'];
          } else {
            $netadmin_subcity = "";
          }

          if (isset($post_elec['fields']['product'])) {
            $product = $post_elec['fields']['product'];
          } else {
            $product = "";
          }

          if (isset($post_elec['fields']['Grid_operational'])) {
            $Grid_operational = $post_elec['fields']['Grid_operational'];
          } else {
            $Grid_operational = "";
          }
          if (isset($post_elec['fields']['gas_H_L'])) {
            $gas_H_L = $post_elec['fields']['gas_H_L'];
          } else {
            $gas_H_L = "";
          }


          if (isset($post_elec['fields']['DGO'])) {
            $DGO = $post_elec['fields']['DGO'];
          } else {
            $DGO = "";
          }

          if (isset($post_elec['fields']['netadmin_website'])) {
            $netadmin_website = $post_elec['fields']['netadmin_website'];
          } else {
            $netadmin_website = "0";
          }

          if (isset($post_elec['fields']['TNB'])) {
            $TNB = $post_elec['fields']['TNB'];
          } else {
            $TNB = "";
          }

          if (isset($post_elec['fields']['REGION'])) {
            $region = $post_elec['fields']['REGION'];
          } else {
            $region = "";
          }

          if (isset($post_elec['fields']['language_code'])) {
            $language_code = $post_elec['fields']['language_code'];
          } else {
            $language_code = "";
          }
          PostalcodeGas::create(
            [
              '_id' => $recordId,
              'distribution_id' => $distributor_id,
              'netadmin_zip' => $netadmin_zip,
              'netadmin_city' => $netadmin_city,
              'netadmin_subcity' => $netadmin_subcity,
              'product' => $product,
              'grid_operational' => $Grid_operational,
              'gas_H_L' => $gas_H_L,
              'DNB' => $DGO,
              'netadmin_website' => $netadmin_website,
              'TNB' => $TNB,
              'language_code' => $language_code,
              'region' => $region,

            ]
          );
        }
      }
    }
  }
}

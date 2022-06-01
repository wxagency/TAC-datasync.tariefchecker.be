<?php

namespace App\Console\Commands\Restore;

use Illuminate\Console\Command;
use App\Models\History\StaticPackResidential;
use App\Models\History\StaticElecticResidential;
use App\Models\History\StaticGasResidential;
use Carbon\Carbon;
use Session;

class PackResidential extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pack-residential:restore {table_name}{backupdate}';

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
        $this->_delete();
        $this->info("Deleted all data in Airtable");
        $this->alert('Restoring Data to Airtable : ' . Carbon::now());
        $this->_packRestore();
        $this->info("Restored");
        
    }

    /**
     * Delete Airtable data
     */
    private function _delete()
    {
       Session::put('offset','0'); 
       while(Session::get('offset')!='stop') {
                try {
                    $client = new \GuzzleHttp\Client();
                    $query['pageSize'] =10;  
                    $query['offset'] =Session::get('offset');
                    $request = $client->get('https://api.airtable.com/v0/applSCRl4UvL2haqK/PACKS%20RES', [
                        'headers' => [
                            'Accept' => 'application/json',
                            'Content-type' => 'application/json',
                            'Authorization' => 'Bearer keySZo45QUBRPLwjL'
                        ],
                        'query' => $query
                    ]);
                } catch (Exception $ex) {
                    return $ex->getCode();
                }

                $response = $request->getBody()->getContents();       
                $json = json_decode($response, true);
                
                
                if (isset($json['offset'])) {
                    Session::put('offset',$json['offset']);
                    
                } else {
        
                    Session::put('offset','stop');
                    
                } 

             if(!empty($json['records'])) {

            foreach ($json['records'] as $key => $value) {
            $query['records'][0]=$value['id'];
                    $request =$client->delete('https://api.airtable.com/v0/applSCRl4UvL2haqK/PACKS%20RES', [
                            'headers' => [
                            'Accept' => 'application/json',
                            'Content-type' => 'application/json',
                            'Authorization' => 'Bearer keySZo45QUBRPLwjL'
                    ],
                            'query' => $query
                    ]);
            $response = $request->getBody()->getContents();
            $json = json_decode($response, true);

            }   
        }          

       }     

       // delete airtable data
    }
    private function _packRestore()
    {
        $data=StaticPackResidential::where('backupdate', $this->argument('backupdate'))->get();
        foreach ($data as $value) {
            $productE = StaticElecticResidential::select('_id')->where('product_id', $value->pro_id_E)->first();
            $productG = StaticGasResidential::select('_id')->where('product_id', $value->pro_id_G)->first();

            $query['records'][0]['fields']['PACK ID']= $value->pack_id;     
            $query['records'][0]['fields']['Pack Name NL']=$value->pack_name_NL;
            $query['records'][0]['fields']['PACK NAME FR']=$value->pack_name_FR;
            $query['records'][0]['fields']['Active']=$value->active;
            $query['records'][0]['fields']['Partner']=$value->partner;
            $query['records'][0]['fields']['PROD ID E'][0]=$productE->_id;
            $query['records'][0]['fields']['PROD ID G'][0]=$producstG->_id;
            $query['records'][0]['fields']['URL NL']=$value->URL_NL;
            $query['records'][0]['fields']['INFO NL']=$value->info_NL;
            $query['records'][0]['fields']['Tariff description NL']=$value->tariff_description_NL;
            $query['records'][0]['fields']['URL FR']=$value->URL_FR;
            $query['records'][0]['fields']['INFO FR']=$value->info_FR;
            $query['records'][0]['fields']['Tariff description FR']=$value->tariff_description_FR;
            $query['records'][0]['fields']['check elek']=$value->check_elec;
            $query['records'][0]['fields']['check gas']=$value->check_gas;

             try {
                $client = new \GuzzleHttp\Client();
               
                $request = $client->post('https://api.airtable.com/v0/applSCRl4UvL2haqK/PACKS%20RES', 
                [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-type' => 'application/x-www-form-urlencoded',
                        'Authorization' => 'Bearer keySZo45QUBRPLwjL'
                    ],
                    'form_params' => $query
                ]);
            } catch (Exception $ex) {
                return $ex->getCode();
            }
           $response = $request->getBody()->getContents();
        }
    }
}

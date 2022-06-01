<?php

namespace App\Console\Commands\Restore;

use Illuminate\Console\Command;
use App\Models\History\Netcostes;
use App\Models\Dgo;
use Carbon\Carbon;
use Session;

class NetcostERestore extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'netcost-E:restore {table_name}{backupdate}';

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
        $this->_restorenetcostE();
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
                    $request = $client->get('https://api.airtable.com/v0/applSCRl4UvL2haqK/Netcosts%20-%20E', [
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
                    $request =$client->delete('https://api.airtable.com/v0/applSCRl4UvL2haqK/Netcosts%20-%20E', [
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
    private function _restorenetcostE()
    {
        $data=Netcostes::where('backupdate', $this->argument('backupdate'))->get();
        foreach ($data as $value) {
            $dgo = Dgo::select('_id')->where('dgo', $value->dgo)->first();
            $query['records'][0]['fields']['Date']= date("d/m/Y", strtotime($value->date));     
            $query['records'][0]['fields']['Valid from']=date("d/m/Y", strtotime($value->valid_from));
            $query['records'][0]['fields']['Valid till']=date("d/m/Y", strtotime($value->valid_till));
            $query['records'][0]['fields']['DGO'][0]=$dgo->_id;
            $query['records'][0]['fields']['DGO - Electrabel name']=$value->dgo_electrabelname;
            $query['records'][0]['fields']['Fuel']=$value->fuel;
            $query['records'][0]['fields']['Segment'][0]=$value->segment;
            $query['records'][0]['fields']['VL']=$value->VL;
            $query['records'][0]['fields']['WA']=$value->WA;
            $query['records'][0]['fields']['BR']=$value->BR;
            $query['records'][0]['fields']['Volume lower']=$value->volume_lower;
            $query['records'][0]['fields']['Volume upper']=$value->volume_upper;
            $query['records'][0]['fields']['Price single']=$value->price_single;
            $query['records'][0]['fields']['Price day']=$value->price_day;
            $query['records'][0]['fields']['Price night']=$value->price_night;
            $query['records'][0]['fields']['Price Excl Night']=$value->price_excl_night;
            $query['records'][0]['fields']['Reading meter']=$value->reading_meter;
            $query['records'][0]['fields']['Prosumers']=$value->prosumers;
            $query['records'][0]['fields']['Transport']=$value->transport;

             try {
                $client = new \GuzzleHttp\Client();
               
                $request = $client->post('https://api.airtable.com/v0/applSCRl4UvL2haqK/Netcosts%20-%20E', 
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

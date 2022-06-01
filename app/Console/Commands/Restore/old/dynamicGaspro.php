<?php

namespace App\Console\Commands\Restore;

use Illuminate\Console\Command;
use App\Models\History\DynamicGasProfessional;
use Carbon\Carbon;
use App\Models\Supplier;
use App\Models\StaticGasProfessional;

class dynamicGaspro extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dynamicGaspro:start {table_name}{backupdate}';

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

        $table_name= $this->argument('table_name');
        $backupdate= $this->argument('backupdate');

        $data=DynamicGasProfessional::where('backupdate',$backupdate)->get();

        foreach ($data as  $value) {
    
        $supplier=Supplier::where('commercial_name',$value->supplier)->first();
        $pro=StaticGasProfessional::where('product_id',$value->product_id)->first();


        $query['records'][0]['fields']['Product']=$value->product;
        $query['records'][0]['fields']['Valid from']=date("d/m/Y", strtotime($value->valid_from));
        $query['records'][0]['fields']['Valid till']=date("d/m/Y", strtotime($value->valid_till));
         $query['records'][0]['fields']['PROD ID'][0]=$pro->_id;
         $query['records'][0]['fields']['Supplier'][0]=$supplier->_id;
         $query['records'][0]['fields']['Fuel']=$value->fuel;
         $query['records'][0]['fields']['Duration']=$value->duration;
         $query['records'][0]['fields']['Fixed/Indexed']=$value->fixed_indexed;
         $query['records'][0]['fields']['Segment']=$value->segment;
         $query['records'][0]['fields']['VL']=$value->VL;
         $query['records'][0]['fields']['WA']=$value->WA;
         $query['records'][0]['fields']['BR']=$value->BR;
         $query['records'][0]['fields']['Volume lower']=$value->volume_lower;
         $query['records'][0]['fields']['Volume upper']=$value->volume_upper;
         $query['records'][0]['fields']['Price gas']=$value->price_gas;       
         $query['records'][0]['fields']['FF']=$value->ff;        
         $query['records'][0]['fields']['Prices URL NL']=$value->prices_url_nl;
         $query['records'][0]['fields']['Prices URL FR']=$value->prices_url_fr;
         $query['records'][0]['fields']['Index_name']=$value->index_name;
         $query['records'][0]['fields']['Index_Value']=$value->index_value;
         $query['records'][0]['fields']['coeff']=$value->coeff;
         $query['records'][0]['fields']['term']=$value->term;         
         $query['records'][0]['fields']['Date']=date("d/m/Y", strtotime($value->date));
        
       

         try {
                $client = new \GuzzleHttp\Client();
               
                $request = $client->post('https://api.airtable.com/v0/applSCRl4UvL2haqK/Dyn%20data%20-%20G%20PRO', [
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


        }
    }

    private function __delete()
    {
       Session::put('offset','0'); 
       while(Session::get('offset')!='stop') {
           try {
               $client = new \GuzzleHttp\Client();
               $query['pageSize'] =10;  
               $query['offset'] =Session::get('offset');
               $request = $client->get('https://api.airtable.com/v0/applSCRl4UvL2haqK/Dyn%20data%20-%20G%20PRO', [
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
                        $request =$client->delete('https://api.airtable.com/v0/applSCRl4UvL2haqK/Dyn%20data%20-%20G%20PRO', [
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
    }
}

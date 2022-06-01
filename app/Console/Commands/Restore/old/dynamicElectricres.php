<?php

namespace App\Console\Commands\Restore;

use Illuminate\Console\Command;
use App\Models\History\DynamicElectricResidential;
use App\Models\Supplier;
use App\Models\StaticElecticResidential;

class dynamicElectricres extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dynamicElectricres:start {table_name}{backupdate}';

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

        $data=DynamicElectricResidential::where('backupdate',$backupdate)->get();

        foreach ($data as  $value) {

        $supplier=Supplier::where('commercial_name',$value->supplier)->first();
        $pro=StaticElecticResidential::where('product_id',$value->product_id)->first();

                   
        echo $value->product_id;
       

        $query['records'][0]['fields']['Product']=$value->product;
        $query['records'][0]['fields']['Valid from']=date("d/m/Y", strtotime($value->valid_from));
        $query['records'][0]['fields']['Valid till']=date("d/m/Y", strtotime($value->valid_till));

         $query['records'][0]['fields']['PROD ID'][0]=$pro->_id;
         $query['records'][0]['fields']['Supplier'][0]=$supplier->_id;

         $query['records'][0]['fields']['Fuel']=$value->fuel;
         $query['records'][0]['fields']['Duration']=$value->duration;
         $query['records'][0]['fields']['Fixed/Indexed']=$value->fixed_indexed;
         $query['records'][0]['fields']['Customer_Segment']=$value->customer_segment;
         $query['records'][0]['fields']['VL']=$value->VL;
         $query['records'][0]['fields']['WA']=$value->WA;
         $query['records'][0]['fields']['BR']=$value->BR;
         $query['records'][0]['fields']['Volume lower']=$value->volume_lower;
         $query['records'][0]['fields']['Volume upper']=$value->volume_upper;
         $query['records'][0]['fields']['Price Single']=$value->price_single;
         $query['records'][0]['fields']['Price Day']=$value->price_day;
         $query['records'][0]['fields']['Price Night']=$value->price_night;
         $query['records'][0]['fields']['Price Excl Night']=$value->price_excl_night;
         $query['records'][0]['fields']['FF Single']=$value->ff_single;
         $query['records'][0]['fields']['FF day/night']=$value->ff_day_night;
         $query['records'][0]['fields']['FF excl night']=$value->ff_excl_night;
         $query['records'][0]['fields']['GSC VL']=$value->gsc_vl;
         $query['records'][0]['fields']['WKC VL']=$value->wkc_vl;
         $query['records'][0]['fields']['GSC WA']=$value->gsc_wa;
         $query['records'][0]['fields']['GSC BR']=$value->gsc_br;
         $query['records'][0]['fields']['Prices URL NL']=$value->prices_url_nl;
         $query['records'][0]['fields']['Prices URL FR']=$value->prices_url_fr;
         $query['records'][0]['fields']['Index_name']=$value->index_name;
         $query['records'][0]['fields']['Index_value']=$value->index_value;
         $query['records'][0]['fields']['coeff_single']=$value->coeff_single;
         $query['records'][0]['fields']['term_single']=$value->term_single;
         $query['records'][0]['fields']['coeff_day']=$value->coeff_day;
         $query['records'][0]['fields']['term_day']=$value->term_day;
         $query['records'][0]['fields']['coeff_night']=$value->coeff_night;
         $query['records'][0]['fields']['term_night']=$value->term_night;
         $query['records'][0]['fields']['coeff_excl']=$value->coeff_excl;
         $query['records'][0]['fields']['term_excl']=$value->term_excl;
         $query['records'][0]['fields']['Date']=date("d/m/Y", strtotime($value->date));
        
       

         try {
                $client = new \GuzzleHttp\Client();
               
                $request = $client->post('https://api.airtable.com/v0/applSCRl4UvL2haqK/Dyn%20data%20-%20E%20RES', [
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
    
    private function _delete()
    {
        // delete airtable data
       Session::put('offset','0'); 
       while(Session::get('offset')!='stop') {
           try {
               $client = new \GuzzleHttp\Client();
               $query['pageSize'] =10;  
               $query['offset'] =Session::get('offset');
               $request = $client->get('https://api.airtable.com/v0/applSCRl4UvL2haqK/Dyn%20data%20-%20E%20RES', [
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
                        $request =$client->delete('https://api.airtable.com/v0/applSCRl4UvL2haqK/Dyn%20data%20-%20E%20RES', [
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

<?php

namespace App\Console\Commands\Restore;

use Illuminate\Console\Command;
use App\Models\History\StaticGasResidential;
use App\Models\Supplier;

class staticGasres extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'staticGasres:start {table_name}{backupdate}';

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

        $data=StaticGasResidential::where('backupdate',$backupdate)->get();

        foreach ($data as  $value) {
     $supplier=Supplier::where('commercial_name',$value->supplier)->first();

    if($value->product_id!=""){
    $query['records'][0]['fields']['PROD ID']=$value->product_id;
    }
    if($value->acticve!=""){
    $query['records'][0]['fields']['active']=$value->acticve;
    }
      if($value->partner!=""){
        $query['records'][0]['fields']['partner']=$value->partner;
    }
       
         $query['records'][0]['fields']['Supplier'][0]=$supplier->_id;
     if($value->product_name_NL!=""){
         $query['records'][0]['fields']['Product Name NL']=$value->product_name_NL;
     }
     if($value->product_name_FR!=""){
         $query['records'][0]['fields']['Product Name FR']=$value->product_name_FR;
     }
     if($value->fuel!=""){
         $query['records'][0]['fields']['Fuel']=$value->fuel;
     }
      if($value->duration!=""){
         $query['records'][0]['fields']['Duration']=$value->duration;
     }
     if($value->fixed_indiable!=""){
         $query['records'][0]['fields']['Fixed/Indiable']=$value->fixed_indiable;
     }
     
         
          if($value->segment!=""){
         $query['records'][0]['fields']['Segment']=$value->segment;
         }
          if($value->VL!=""){
         $query['records'][0]['fields']['VL']=$value->VL;
         }  
          if($value->WA!=""){     
         $query['records'][0]['fields']['WA']=$value->WA;
         }   
         if($value->BR!=""){      
         $query['records'][0]['fields']['BR']=$value->BR;
         }
         if($value->service_level_payment!=""){    
         $query['records'][0]['fields']['Servicelevel Payment']=$value->service_level_payment;
        }
        if($value->service_level_invoicing!=""){ 
         $query['records'][0]['fields']['Servicelevel Invoicing']=$value->service_level_invoicing ;
        }
        if($value->service_level_contact!=""){ 
         $query['records'][0]['fields']['Servicelevel Contact']=$value->service_level_contact;
         }
          if($value->FF_pro_rata!=""){ 
         $query['records'][0]['fields']['FF pro rata?']=$value->FF_pro_rata;
         }
         if($value->inv_period!=""){ 
         $query['records'][0]['fields']['Inv period']=$value->inv_period;
         }     
          if($value->customer_condition!=""){     
         $query['records'][0]['fields']['Customer condition']=$value->customer_condition;
        }
        if($value->subscribe_url_NL!=""){
         $query['records'][0]['fields']['Subscribe URL NL']=$value->subscribe_url_NL;
         }
        if($value->info_NL!=""){
         $query['records'][0]['fields']['info NL']=$value->info_NL;
         }
          if($value->tariff_description_NL!=""){
         $query['records'][0]['fields']['Tariff Description NL']=$value->tariff_description_NL;
          }
        if($value->terms_NL!=""){
         $query['records'][0]['fields']['Terms NL']=$value->terms_NL;
        }
         if($value->subscribe_url_FR!=""){
         $query['records'][0]['fields']['Subscribe URL FR']=$value->subscribe_url_FR;
        }
         if($value->info_FR!=""){
         $query['records'][0]['fields']['info FR']=$value->info_FR;
        }
        if($value->tariff_description_FR!=""){
         $query['records'][0]['fields']['Tariff Description FR']=$value->tariff_description_FR;
        }
        if($value->terms_FR!=""){
         $query['records'][0]['fields']['Terms FR']=$value->terms_FR;
        }
        // $query['records'][0]['fields']['PACKS PRO']=date("d/m/Y", strtotime($value->date));
         //$query['records'][0]['fields']['Dyn data - G PRO']=date("d/m/Y", strtotime($value->date));
        
       

         try {
                $client = new \GuzzleHttp\Client();
               
                $request = $client->post('https://api.airtable.com/v0/applSCRl4UvL2haqK/GAS%20RES', [
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
       Session::put('offset','0'); 
       while(Session::get('offset')!='stop') {
           try {
               $client = new \GuzzleHttp\Client();
               $query['pageSize'] =10;  
               $query['offset'] =Session::get('offset');
               $request = $client->get('https://api.airtable.com/v0/applSCRl4UvL2haqK/GAS%20RES', [
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
                        $request =$client->delete('https://api.airtable.com/v0/applSCRl4UvL2haqK/GAS%20RES', [
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

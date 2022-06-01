<?php

namespace App\Console\Commands\Restore;

use Illuminate\Console\Command;
use App\Models\History\Discount;
use App\Models\History\Supplier;
use Carbon\Carbon;
use Session;

class DiscountRestore extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'discount:restore {table_name}{backupdate}';

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
        $this->_restoreDiscount();
        $this->info('Completed discount Restore');
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
                    $request = $client->get('https://api.airtable.com/v0/applSCRl4UvL2haqK/Discounts', [
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
                    $request =$client->delete('https://api.airtable.com/v0/applSCRl4UvL2haqK/Discounts', [
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
    private function _restoreDiscount()
    {
        
        $data=Discount::where('backupdate', $this->argument('backupdate'))->get();
        
        foreach ($data as $value) {
            $supplier = Supplier::select('_id')->where('commercial_name', $value->supplier)->first();

            $query['records'][0]['fields']['Id']=$value->discountId;

            $query['records'][0]['fields']['Supplier'][0]=$supplier->_id;

            $query['records'][0]['fields']['CreatedAt']= date("D,d M Y H:i:s",strtotime($value->discountCreated));
            
            $query['records'][0]['fields']['StartDate']=date("D,d M Y H:i:s",strtotime($value->startdate));
            $query['records'][0]['fields']['EndDate']=date("D,d M Y H:i:s", strtotime($value->enddate));
            $query['records'][0]['fields']['CustomerGroup']=$value->customergroup;
            $query['records'][0]['fields']['VolumeLower']=$value->volume_lower;
            $query['records'][0]['fields']['VolumeUpper']=$value->volume_upper;
            $query['records'][0]['fields']['DiscountType']=$value->discountType;
            $query['records'][0]['fields']['FuelType']=$value->fuelType;
            $query['records'][0]['fields']['Channel']=$value->channel;
            $query['records'][0]['fields']['ApplicationVContractDuration']=$value->applicationVContractDuration;
            $query['records'][0]['fields']['ServiceLevelPayment']=$value->serviceLevelPayment;
            $query['records'][0]['fields']['ServiceLevelInvoicing']=$value->serviceLevelInvoicing;
            $query['records'][0]['fields']['ServiceLevelContact']=$value->serviceLevelContact;
            $query['records'][0]['fields']['MinimumSupplyCondition']=$value->minimumSupplyCondition;
            $query['records'][0]['fields']['Duration']=$value->duration;
            $query['records'][0]['fields']['Applicability']=$value->applicability;
            $query['records'][0]['fields']['ValueType']=$value->valueType;
            $query['records'][0]['fields']['Value']=$value->value;
            $query['records'][0]['fields']['Unit']=$value->unit;
            $query['records'][0]['fields']['ApplicableForExistingCustomers']=$value->applicableForExistingCustomers;
            $query['records'][0]['fields']['Greylist']=$value->greylist;
            $query['records'][0]['fields']['ProductId']=$value->productId;
            $query['records'][0]['fields']['NameNl']=$value->nameNl;
            $query['records'][0]['fields']['DescriptionNl']=$value->descriptionNl;
            $query['records'][0]['fields']['NameFr']=$value->nameFr;
            $query['records'][0]['fields']['DescriptionFr']=$value->descriptionFr;



             try {
                $client = new \GuzzleHttp\Client();
               
                $request = $client->post('https://api.airtable.com/v0/applSCRl4UvL2haqK/Discounts', [
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
        // echo $this->argument('table_name');
        // echo $this->argument('backupdate');


    }


}

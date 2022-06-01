<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Discount;
use Carbon\Carbon;
use Session;
use DateTime;

class Discounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'discounts:generate';

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
            $this->alert('Fetching Discounts from Airtable : ' . Carbon::now());
            $this->_manageDiscounts();
            $this->comment('Completed at : ' . Carbon::now());
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    private function _manageDiscounts()
    {
        Discount::truncate();
        Session::put('offset','0'); 
        while(Session::get('offset')!='stop') {
               try {
                $client = new \GuzzleHttp\Client();
                $query['pageSize'] =100;  
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
                        
             foreach ($json['records'] as $discounts) {
                 
                   if( !empty($discounts['fields']['Id']) && !empty($discounts['fields']['Supplier']) && isset($discounts['fields']['ProductId'])){
                     
                     $ProductId = $discounts['fields']['ProductId'];
                      foreach($ProductId as $ProductIds){
                          
                          $request = $client->get('https://api.airtable.com/v0/applSCRl4UvL2haqK/Product-Id/'.$ProductIds, [
                            'headers' => [
                                'Accept' => 'application/json',
                                'Content-type' => 'application/json',
                                'Authorization' => 'Bearer keySZo45QUBRPLwjL'
                            ]
                            
                        ]);
                    
                        $response = $request->getBody()->getContents();       
                        $json = json_decode($response, true);
                        
                        $product_id = $json['fields']['Product'];
                          
                          
                        /*insert- discounts*/
                        
                         if(isset($discounts['id'])){
                        $recordId = $discounts['id'];
                    } else {
                        $recordId = NULL;
                    }

                    if(isset($discounts['fields']['Id'])){
                        $id = $discounts['fields']['Id'];
                    } else {
                        $id = NULL;
                    }
                    if(isset($discounts['fields']['Supplier'])){
                        $supplier = $discounts['fields']['Supplier'];
                        $request = $client->get('https://api.airtable.com/v0/applSCRl4UvL2haqK/Suppliers/'.$supplier[0], [
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
                        $supplier = NULL;
                    }
                    if(isset($discounts['createdTime'])){
                        $createdat = $discounts['createdTime'];
                    } else {
                        $createdat = NULL;
                    }
                    if(isset($discounts['fields']['StartDate'])){
                        $startdate = $discounts['fields']['StartDate'];
                    } else {
                        $startdate = NULL;
                    }
                    if(isset($discounts['fields']['EndDate'])){
                        $enddate = $discounts['fields']['EndDate'];
                    } else {
                        $enddate = NULL;
                    }
                    if(isset($discounts['fields']['CustomerGroup'])){
                        $customergroup = $discounts['fields']['CustomerGroup'];
                    } else {
                        $customergroup = NULL;
                    }
                    if(isset($discounts['fields']['VolumeLower'])){
                        $volumeLower = $discounts['fields']['VolumeLower'];
                    } else {
                        $volumeLower = NULL;
                    }
                    if(isset($discounts['fields']['VolumeUpper'])){
                        $volumeUpper = $discounts['fields']['VolumeUpper'];
                    } else {
                        $volumeUpper = NULL;
                    }
                    if(isset($discounts['fields']['DiscountType'])){
                        $discounttype = $discounts['fields']['DiscountType'];
                    } else {
                        $discounttype = NULL;
                    }
                    if(isset($discounts['fields']['FuelType'])){
                        $fueltype = $discounts['fields']['FuelType'];
                    } else {
                        $fueltype = NULL;
                    }
                    if(isset($discounts['fields']['ComparisonType'])){
                        $comparisonType = $discounts['fields']['ComparisonType'];
                    } else {
                        $comparisonType = NULL;
                    }
                    if(isset($discounts['fields']['Channel'])){
                        $channel = $discounts['fields']['Channel'];
                    } else {
                        $channel = NULL;
                    }
                    if(isset($discounts['fields']['ApplicationVContractDuration'])){
                        $applicationVcontractduration = $discounts['fields']['ApplicationVContractDuration'];
                    } else {
                        $applicationVcontractduration = NULL;
                    }
                    if(isset($discounts['fields']['ServiceLevelPayment'])){
                        $servicepayment = $discounts['fields']['ServiceLevelPayment'];
                    } else {
                        $servicepayment = NULL;
                    }
                    if(isset($discounts['fields']['ServiceLevelInvoicing'])){
                        $serviceInvoicing = $discounts['fields']['ServiceLevelInvoicing'];
                    } else {
                        $serviceInvoicing = NULL;
                    }
                    if(isset($discounts['fields']['ServiceLevelContact'])){
                        $serviceContact = $discounts['fields']['ServiceLevelContact'];
                    } else {
                        $serviceContact = NULL;
                    }
                    if(isset($discounts['fields']['DiscountCodeE'])){
                        $discountcodeE = $discounts['fields']['DiscountCodeE'];
                    } else {
                        $discountcodeE = NULL;
                    }
                    if(isset($discounts['fields']['DiscountCodeG'])){
                        $discountcodeG = $discounts['fields']['DiscountCodeG'];
                    } else {
                        $discountcodeG = NULL;
                    }
                    if(isset($discounts['fields']['DiscountCodeP'])){
                        $discountcodeP = $discounts['fields']['DiscountCodeP'];
                    } else {
                        $discountcodeP = NULL;
                    }
                    if(isset($discounts['fields']['MinimumSupplyCondition'])){
                        $minimumSupplycondition = $discounts['fields']['MinimumSupplyCondition'];
                    } else {
                        $minimumSupplycondition = NULL;
                    }
                    if(isset($discounts['fields']['Duration'])){
                        $duration = $discounts['fields']['Duration'];
                    } else {
                        $duration = NULL;
                    }
                    if(isset($discounts['fields']['Applicability'])){
                        $applicability = $discounts['fields']['Applicability'];
                    } else {
                        $applicability = NULL;
                    }
                    if(isset($discounts['fields']['ValueType'])){
                        $valuetype = $discounts['fields']['ValueType'];
                    } else {
                        $valuetype = NULL;
                    }
                    if(isset($discounts['fields']['Value'])){
                        $value = $discounts['fields']['Value'];
                        $values = str_replace(",",".",$value);
                        $value = preg_replace('/\.(?=.*\.)/', '', $values);
                    } else {
                        $value = NULL;
                    }
                    if(isset($discounts['fields']['Unit'])){
                        $unit = $discounts['fields']['Unit'];
                    } else {
                        $unit = NULL;
                    }
                    if(isset($discounts['fields']['ApplicableForExistingCustomers'])){
                        $forexistingCustomers = $discounts['fields']['ApplicableForExistingCustomers'];
                    } else {
                        $forexistingCustomers = NULL;
                    }
                    if(isset($discounts['fields']['Greylist'])){
                        $greylist = $discounts['fields']['Greylist'];
                    } else {
                        $greylist = NULL;
                    }
                    if(isset($discounts['fields']['ProductId'])){
                        $productId = $discounts['fields']['ProductId'];
                    } else {
                        $productId = NULL;
                    }
                    if(isset($discounts['fields']['NameNl'])){
                        $namenl = $discounts['fields']['NameNl'];
                    } else {
                        $namenl = NULL;
                    }
                    if(isset($discounts['fields']['DescriptionNl'])){
                        $descriptionNl = $discounts['fields']['DescriptionNl'];
                    } else {
                        $descriptionNl = NULL;
                    }
                    if(isset($discounts['fields']['NameFr'])){
                        $namefr = $discounts['fields']['NameFr'];
                    } else {
                        $namefr = NULL;
                    }
                    if(isset($discounts['fields']['DescriptionFr'])){
                        $descriptionFr = $discounts['fields']['DescriptionFr'];
                    } else {
                        $descriptionFr = NULL;
                    }

                    // $date = Carbon::createFromIsoFormat('LLLL', 'Monday 11 March 2019 16:28:00', null, 'fr');
                    // dd($date->isoFormat('M/D/YY HH:mm:ss')) ; // 3/11/19 16:28
                    // $old_date_timestamp = strtotime('Wed, 29 Aug 2018 09:04:05 +0000');
                    // $new_date = date('Y-m-d H:i:s', $old_date_timestamp);
                    // dd(gettype($new_date));

                    $time = strtotime($createdat);
                    $newdate = date('Y-m-d',$time);
                    
                    $time = strtotime($startdate);
                    $newstartdate = date('Y-m-d',$time);
                    $time = strtotime($enddate);
                    $newenddate = date('Y-m-d',$time);
                    Discount::create(
                            [
                                '_id' => $recordId,
                                'discountId' => $id,
                                'supplier' => $supply,
                                'discountCreated' => $newdate,
                                'startdate' => $newstartdate,
                                'enddate' => $newenddate,
                                'customergroup' => $customergroup,
                                'volume_lower' => $volumeLower,
                                'volume_upper' => $volumeUpper,
                                'discountType' => $discounttype,
                                'fuelType' => $fueltype,
                                'comparisonType' => $comparisonType,
                                'channel' => $channel,
                                'applicationVContractDuration' => $applicationVcontractduration,
                                'serviceLevelPayment' => $servicepayment,
                                'serviceLevelInvoicing' => $serviceInvoicing,
                                'serviceLevelContact' => $serviceContact,
                                'discountcodeE' => $discountcodeE,
                                'discountcodeG' => $discountcodeG,
                                'discountcodeP' => $discountcodeP,
                                'minimumSupplyCondition' => $minimumSupplycondition,
                                'duration' => $duration,
                                'applicability' => $applicability,
                                'valueType' => $valuetype,
                                'value' => $value,
                                'unit' => $unit,
                                'applicableForExistingCustomers' => $forexistingCustomers,
                                'greylist' => $greylist,
                                'productId' => $product_id,
                                'nameNl' => $namenl,
                                'descriptionNl' => $descriptionNl,
                                'nameFr' => $namefr,
                                'descriptionFr' => $descriptionFr,
                            ]); 
                        
                        
                        
                        
                        /*end*/
                          
                          
                      }
                      
                 }
                 
             }
             
        }
        $this->info('All discounts are saved');
    }
}

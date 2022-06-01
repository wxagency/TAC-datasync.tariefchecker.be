<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\DynamicElectricResidential;
use App\Models\DynamicGasResidential;
use App\Models\Supplier;
use Carbon\Carbon;
use Session;

class DynamicDataResidential extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'residentialdata:import';

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
            $this->alert('Fetching Residential data from Airtable : ' . Carbon::now());
            $this->_electricityResidential();
            $this->_gasResidential();
            $this->comment('Completed at : ' . Carbon::now());
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    private function _electricityResidential()
    {

        
        DynamicElectricResidential::truncate();
        Session::put('offset','0'); 
        while(Session::get('offset')!='stop') {
            try {
                $client = new \GuzzleHttp\Client();
                $query['pageSize'] =100;  
                $query['offset'] =Session::get('offset');
                $request = $client->get('https://api.airtable.com/v0/applSCRl4UvL2haqK/Dyn%20data%20-%20E%20RES', [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-type' => 'application/json',
                        'Authorization' => 'Bearer keySZo45QUBRPLwjL'
                    ],
                    'query' => $query
                ]);
            } catch (Exception $e) {
                return $e->getCode();
            }
            $response = $request->getBody()->getContents();       
            $json = json_decode($response, true);
            if (isset($json['offset'])) {
                Session::put('offset',$json['offset']);
               
            } else {
  
                Session::put('offset','stop');
                
            }
            foreach ($json['records'] as $dynamicData) {
                if (!empty($dynamicData['fields']['Product']) && !empty($dynamicData['fields']['PROD ID'])) {
                 if(isset($dynamicData['id'])){
                    $recordId = $dynamicData['id'];
                } else {
                    $recordId = NULL;
                }
                if(isset($dynamicData['fields']['PROD ID'])){
                    $productId = $dynamicData['fields']['PROD ID'];
                    $request = $client->get('https://api.airtable.com/v0/applSCRl4UvL2haqK/Dyn%20data%20-%20E%20RES/'.$productId[0], [
                        'headers' => [
                            'Accept' => 'application/json',
                            'Content-type' => 'application/json',
                            'Authorization' => 'Bearer keySZo45QUBRPLwjL'
                        ]
                        
                      ]);
                  
                      $response = $request->getBody()->getContents();       
                      $json = json_decode($response, true);
                      $proId = $json['fields']['PROD ID'];
                } else {
                    $productId = NULL;
                }
                if(isset($dynamicData['fields']['Date'])){
                    $date = $dynamicData['fields']['Date'];
                } else {
                    $date = NULL;
                }
                if(isset($dynamicData['fields']['Valid from'])){
                    $validFrom = $dynamicData['fields']['Valid from'];
                } else {
                    $validFrom = NULL;
                }
                if(isset($dynamicData['fields']['Valid till'])){
                    $validTill = $dynamicData['fields']['Valid till'];
                } else {
                    $validTill = NULL;
                }
                if(isset($dynamicData['fields']['Supplier'])){
                    $supplier = $dynamicData['fields']['Supplier'];
                    $request = $client->get('https://api.airtable.com/v0/applSCRl4UvL2haqK/Dyn%20data%20-%20E%20RES/'.$supplier[0], [
                        'headers' => [
                            'Accept' => 'application/json',
                            'Content-type' => 'application/json',
                            'Authorization' => 'Bearer keySZo45QUBRPLwjL'
                        ]
                        
                      ]);
                  
                      $response = $request->getBody()->getContents();       
                      $json = json_decode($response, true);
                      $supplier = $json['fields']['Commercial Name'];
                } else {
                    $supplier = NULL;
                }
                if(isset($dynamicData['fields']['Product'][0])){
                    $product = $dynamicData['fields']['Product'][0];
                } else {
                    $product = NULL;
                }
                if(isset($dynamicData['fields']['Fuel'][0])){
                    $fuel = $dynamicData['fields']['Fuel'][0];
                } else {
                    $fuel = NULL;
                }
                if(isset($dynamicData['fields']['Duration'])){
                    $duration = $dynamicData['fields']['Duration'];
                } else {
                    $duration = 0;
                }
                
                
                if(isset($dynamicData['fields']['Price Type'][0])){
                    $fixedIndiable = $dynamicData['fields']['Price Type'][0];
                } else {
                    $fixedIndiable = NULL;
                }
                
                
                if(isset($dynamicData['fields']['Customer Segment'][0])){
                    $segment = $dynamicData['fields']['Customer Segment'][0];
                } else {
                    $segment = NULL;
                }
                if(isset($dynamicData['fields']['VL'])){
                    $vl = $dynamicData['fields']['VL'];
                } else {
                    $vl = NULL;
                }
                
               
                if(isset($dynamicData['fields']['WA'])){
                    $wa = $dynamicData['fields']['WA'];
                } else {
                    $wa = NULL;
                }
                if(isset($dynamicData['fields']['BR'])){
                    $br = $dynamicData['fields']['BR'];
                } else {
                    $br = NULL;
                }
                if(isset($dynamicData['fields']['Volume lower'])){
                    $volumeLower = $dynamicData['fields']['Volume lower'];
                } else {
                    $volumeLower = NULL;
                }
                if(isset($dynamicData['fields']['Volume upper'])){
                    $volumeUpper = $dynamicData['fields']['Volume upper'];
                } else {
                    $volumeUpper = NULL;
                }
                if(isset($dynamicData['fields']['Price Single'])){
                    $priceSingle = $dynamicData['fields']['Price Single'];
                    $priceSing = str_replace(",",".",$priceSingle);
                    $priceSingle = preg_replace('/\.(?=.*\.)/', '', $priceSing);
                } else {
                    $priceSingle = NULL;
                }
                if(isset($dynamicData['fields']['Price Day'])){
                    $priceDay = $dynamicData['fields']['Price Day'];
                    $priceDy = str_replace(",",".",$priceDay);
                    $priceDay = preg_replace('/\.(?=.*\.)/', '', $priceDy);
                } else {
                    $priceDay = NULL;
                }
                if(isset($dynamicData['fields']['Price Night'])){
                    $priceNight = $dynamicData['fields']['Price Night'];
                    $priceNi = str_replace(",",".",$priceNight);
                    $priceNight = preg_replace('/\.(?=.*\.)/', '', $priceNi);
                } else {
                    $priceNight = NULL;
                }
                if(isset($dynamicData['fields']['Price Excl Night'])){
                    $priceExclNight = $dynamicData['fields']['Price Excl Night'];
                    $priceExclNig = str_replace(",",".",$priceExclNight);
                    $priceExclNight = preg_replace('/\.(?=.*\.)/', '', $priceExclNig);
                } else {
                    $priceExclNight = NULL;
                }
                if(isset($dynamicData['fields']['FF Single'])){
                    $ffSingle = $dynamicData['fields']['FF Single'];
                    $ffSing = str_replace(",",".",$ffSingle);
                    $ffSingle = preg_replace('/\.(?=.*\.)/', '', $ffSing);
                } else {
                    $ffSingle = NULL;
                }
                if(isset($dynamicData['fields']['FF day/night'])) {
                    $ffDayNight = $dynamicData['fields']['FF day/night'];
                    $ffDayNig = str_replace(",",".",$ffDayNight);
                    $ffDayNight = preg_replace('/\.(?=.*\.)/', '', $ffDayNig);
                } else {
                    $ffDayNight = NULL;
                }
                if(isset($dynamicData['fields']['FF excl night'])) {
                    $ffExclNight = $dynamicData['fields']['FF excl night'];
                    $ffExclNig = str_replace(",",".",$ffExclNight);
                    $ffExclNight = preg_replace('/\.(?=.*\.)/', '', $ffExclNig);
                } else {
                    $ffExclNight = NULL;
                }
                if(isset($dynamicData['fields']['GSC VL'])) {
                    $gscVl = $dynamicData['fields']['GSC VL'];
                    $gscV = str_replace(",",".",$gscVl);
                    $gscVl = preg_replace('/\.(?=.*\.)/', '', $gscV);
                } else {
                    $gscVl = NULL;
                }
                if(isset($dynamicData['fields']['WKC VL'])) {
                    $wkcVl = $dynamicData['fields']['WKC VL'];
                    $wkcV = str_replace(",",".",$wkcVl);
                    $wkcVl = preg_replace('/\.(?=.*\.)/', '', $wkcV);
                } else {
                    $wkcVl = NULL;
                }
                if(isset($dynamicData['fields']['GSC WA'])) {
                    $gscWa = $dynamicData['fields']['GSC WA'];
                    $gscW = str_replace(",",".",$gscWa);
                    $gscWa = preg_replace('/\.(?=.*\.)/', '', $gscW);
                } else {
                    $gscWa = NULL;
                }
                if(isset($dynamicData['fields']['GSC BR'])) {
                    $gscBr = $dynamicData['fields']['GSC BR'];
                    $gscB = str_replace(",",".",$gscBr);
                    $gscBr = preg_replace('/\.(?=.*\.)/', '', $gscB);
                } else {
                    $gscBr = NULL;
                }
                if(isset($dynamicData['fields']['Prices URL NL'])) {
                    $pricesUrlNL = $dynamicData['fields']['Prices URL NL'];
                } else {
                    $pricesUrlNL = NULL;
                }
                if(isset($dynamicData['fields']['Prices URL FR'])) {
                    $pricesUrlFR = $dynamicData['fields']['Prices URL FR'];
                } else {
                    $pricesUrlFR = NULL;
                }
                if(isset($dynamicData['fields']['Index_name'])) {
                    $index = $dynamicData['fields']['Index_name'];
                } else {
                    $index = NULL;
                }
                if(isset($dynamicData['fields']['Index_value'])) {
                    $waarde = $dynamicData['fields']['Index_value'];
                    $indexVal = str_replace(",",".",$waarde);
                    $waarde = preg_replace('/\.(?=.*\.)/', '', $indexVal);
                } else {
                    $waarde = NULL;
                }
                if(isset($dynamicData['fields']['coeff_single'])) {
                    $coefficientSingle = $dynamicData['fields']['coeff_single'];
                    $coefficientSin = str_replace(",",".",$coefficientSingle);
                    $coefficientSingle = preg_replace('/\.(?=.*\.)/', '', $coefficientSin);
                } else {
                    $coefficientSingle = NULL;
                }
                if(isset($dynamicData['fields']['term_single'])) {
                    $termSingle = $dynamicData['fields']['term_single'];
                    $termSin = str_replace(",",".",$termSingle);
                    $termSingle = preg_replace('/\.(?=.*\.)/', '', $termSin);
                } else {
                    $termSingle = NULL;
                }
                if(isset($dynamicData['fields']['coeff_day'])) {
                    $coefficientDay = $dynamicData['fields']['coeff_day'];
                    $coefficientD = str_replace(",",".",$coefficientDay);
                    $coefficientDay = preg_replace('/\.(?=.*\.)/', '', $coefficientD);
                } else {
                    $coefficientDay = NULL;
                }
                if(isset($dynamicData['fields']['term_day'])) {
                    $termDay = $dynamicData['fields']['term_day'];
                    $termD = str_replace(",",".",$termDay);
                    $termDay = preg_replace('/\.(?=.*\.)/', '', $termD);
                } else {
                    $termDay = NULL;
                }
                if(isset($dynamicData['fields']['coeff_night'])) {
                    $coefficientNight = $dynamicData['fields']['coeff_night'];
                    $coefficientNig = str_replace(",",".",$coefficientNight);
                    $coefficientNight = preg_replace('/\.(?=.*\.)/', '', $coefficientNig);
                } else {
                    $coefficientNight = NULL;
                }
                if(isset($dynamicData['fields']['term_night'])) {
                    $termNight = $dynamicData['fields']['term_night'];
                    $termNig = str_replace(",",".",$termNight);
                    $termNight = preg_replace('/\.(?=.*\.)/', '', $termNig);
                } else {
                    $termNight = NULL;
                }
                if(isset($dynamicData['fields']['coeff_excl'])) {
                    $coefficientExcl = $dynamicData['fields']['coeff_excl'];
                    $coefficientEx = str_replace(",",".",$coefficientExcl);
                    $coefficientExcl = preg_replace('/\.(?=.*\.)/', '', $coefficientEx);
                } else {
                    $coefficientExcl = NULL;
                }
                if(isset($dynamicData['fields']['term_excl'])) {
                    $termExcl = $dynamicData['fields']['term_excl'];
                    $termEx = str_replace(",",".",$termExcl);
                    $termExcl = preg_replace('/\.(?=.*\.)/', '', $termEx);
                } else {
                    $termExcl = NULL;
                }
                
                $regionValue=Supplier::where('commercial_name',$supplier)->first();
                $gscVl=$regionValue->gsc_vl;
                $wkcVl=$regionValue->wkc_vl;
                $gscWa=$regionValue->gsc_wa;
                $gscBr=$regionValue->gsc_br;
                
                
                $newdate = $date; // Carbon::createFromFormat('d/m/Y', $date)->toDateString();
                $newValidFrom = $validFrom; // Carbon::createFromFormat('d/m/Y', $validFrom)->toDateString();
                $newValidtill = $validTill; // Carbon::createFromFormat('d/m/Y', $validTill)->toDateString();
                
                DynamicElectricResidential::Create(
                    ['product_id' => $proId,
                            '_id' => $recordId,
                            'product_id' => $proId,
                            'date' => $newdate,
                            'valid_from' => $newValidFrom,
                            'valid_till' => $newValidtill,
                            'supplier' => $supplier,
                            'product' => $product,
                            'fuel' => $fuel,
                            'duration' => $duration,
                            'fixed_indexed' => $fixedIndiable,
                            'customer_segment' => $segment,
                            'VL' => $vl,
                            'WA' => $wa,
                            'BR' => $br,
                            'volume_lower' => $volumeLower,
                            'volume_upper' => $volumeUpper,
                            'price_single' => $priceSingle,
                            'price_day' => $priceDay,
                            'price_night' => $priceNight,
                            'price_excl_night' => $priceExclNight,
                            'ff_single' => $ffSingle,
                            'ff_day_night' => $ffDayNight,
                            'ff_excl_night' => $ffExclNight,
                            'gsc_vl' => $gscVl,
                            'wkc_vl' => $wkcVl,
                            'gsc_wa' => $gscWa,
                            'gsc_br' => $gscBr,
                            'prices_url_nl' => $pricesUrlNL,
                            'prices_url_fr' => $pricesUrlFR,
                            'index_name' => $index,
                            'index_value' => $waarde,
                            'coeff_single' => $coefficientSingle,
                            'term_single' => $termSingle,
                            'coeff_day' => $coefficientDay,
                            'term_day' => $termDay,
                            'coeff_night' => $coefficientNight,
                            'term_night' => $termNight,
                            'coeff_excl' => $coefficientExcl,
                            'term_excl' => $termExcl,
                        ]); 
                }   
            }
        }
        $this->info('Products saved from Dynamic data of Electricity Residential type');
        $this->info('Next');
    }

    private function _gasResidential()
    {
        Session::put('offset','0'); 
        DynamicGasResidential::truncate();
        while(Session::get('offset')!='stop') {
            try {
                $client = new \GuzzleHttp\Client();
                $query['pageSize'] =100;  
                $query['offset'] =Session::get('offset');
                $request = $client->get('https://api.airtable.com/v0/applSCRl4UvL2haqK/Dyn%20data%20-%20G%20RES', [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-type' => 'application/json',
                        'Authorization' => 'Bearer keySZo45QUBRPLwjL'
                    ],
                    'query' => $query
                ]);
            } catch (Exception $e) {
                return $e->getCode();
            }
            $response = $request->getBody()->getContents();       
            $json = json_decode($response, true);
            if (isset($json['offset'])) {
                Session::put('offset',$json['offset']);
               
            } else {
  
                Session::put('offset','stop');
                
            }
            foreach ($json['records'] as $dynamicData) {
                if (!empty($dynamicData['fields']['Product']) && !empty($dynamicData['fields']['PROD ID'])) {
                 if(isset($dynamicData['id'])){
                    $recordId = $dynamicData['id'];
                } else {
                    $recordId = NULL;
                }
                if(isset($dynamicData['fields']['PROD ID'])){
                    $productId = $dynamicData['fields']['PROD ID'];
                    $request = $client->get('https://api.airtable.com/v0/applSCRl4UvL2haqK/Dyn%20data%20-%20G%20RES/'.$productId[0], [
                        'headers' => [
                            'Accept' => 'application/json',
                            'Content-type' => 'application/json',
                            'Authorization' => 'Bearer keySZo45QUBRPLwjL'
                        ]
                        
                      ]);
                  
                      $response = $request->getBody()->getContents();       
                      $json = json_decode($response, true);
                      $proId = $json['fields']['PROD ID'];
                } else {
                    $productId = NULL;
                }
                if(isset($dynamicData['fields']['Date'])){
                    $date = $dynamicData['fields']['Date'];
                } else {
                    $date = NULL;
                }
                if(isset($dynamicData['fields']['Valid from'])){
                    $validFrom = $dynamicData['fields']['Valid from'];
                } else {
                    $validFrom = NULL;
                }
                if(isset($dynamicData['fields']['Valid till'])){
                    $validTill = $dynamicData['fields']['Valid till'];
                } else {
                    $validTill = NULL;
                }
                if(isset($dynamicData['fields']['Supplier'])){
                    $supplier = $dynamicData['fields']['Supplier'];
                    $request = $client->get('https://api.airtable.com/v0/applSCRl4UvL2haqK/Dyn%20data%20-%20G%20RES/'.$supplier[0], [
                        'headers' => [
                            'Accept' => 'application/json',
                            'Content-type' => 'application/json',
                            'Authorization' => 'Bearer keySZo45QUBRPLwjL'
                        ]
                        
                      ]);
                  
                      $response = $request->getBody()->getContents();       
                      $json = json_decode($response, true);
                      $supplier = $json['fields']['Commercial Name'];
                } else {
                    $supplier = NULL;
                }
                if(isset($dynamicData['fields']['Product'][0])){
                    $product = $dynamicData['fields']['Product'][0];
                } else {
                    $product = NULL;
                }
                if(isset($dynamicData['fields']['Fuel'][0])){
                    $fuel = $dynamicData['fields']['Fuel'][0];
                } else {
                    $fuel = NULL;
                }
                if(isset($dynamicData['fields']['Duration'])){
                    $duration = $dynamicData['fields']['Duration'];
                } else {
                    $duration = 0;
                }
                
                
                if(isset($dynamicData['fields']['Price Type'][0])){
                    $fixedIndiable = $dynamicData['fields']['Price Type'][0];
                } else {
                    $fixedIndiable = NULL;
                }
                
                
                if(isset($dynamicData['fields']['Customer Segment'][0])){
                    $segment = $dynamicData['fields']['Customer Segment'][0];
                } else {
                    $segment = NULL;
                }
                if(isset($dynamicData['fields']['VL'])){
                    $vl = $dynamicData['fields']['VL'];
                } else {
                    $vl = NULL;
                }
                if(isset($dynamicData['fields']['WA'])){
                    $wa = $dynamicData['fields']['WA'];
                } else {
                    $wa = NULL;
                }
                if(isset($dynamicData['fields']['BR'])){
                    $br = $dynamicData['fields']['BR'];
                } else {
                    $br = NULL;
                }
                if(isset($dynamicData['fields']['Volume lower'])){
                    $volumeLower = $dynamicData['fields']['Volume lower'];
                } else {
                    $volumeLower = NULL;
                }
                if(isset($dynamicData['fields']['Volume upper'])){
                    $volumeUpper = $dynamicData['fields']['Volume upper'];
                } else {
                    $volumeUpper = NULL;
                }
                if(isset($dynamicData['fields']['Price gas'])){
                    $priceGas = $dynamicData['fields']['Price gas'];
                    $priceG = str_replace(",",".",$priceGas);
                    $priceGas = preg_replace('/\.(?=.*\.)/', '', $priceG);
                } else {
                    $priceGas = NULL;
                }
                if(isset($dynamicData['fields']['FF'])){
                    $ff = $dynamicData['fields']['FF'];
                    $ffgas = str_replace(",",".",$ff);
                    $ff = preg_replace('/\.(?=.*\.)/', '', $ffgas);
                } else {
                    $ff = NULL;
                }
                if(isset($dynamicData['fields']['Prices URL NL'])) {
                    $pricesUrlNL = $dynamicData['fields']['Prices URL NL'];
                } else {
                    $pricesUrlNL = NULL;
                }
                if(isset($dynamicData['fields']['Prices URL FR'])) {
                    $pricesUrlFR = $dynamicData['fields']['Prices URL FR'];
                } else {
                    $pricesUrlFR = NULL;
                }
                if(isset($dynamicData['fields']['Index_name'])) {
                    $index = $dynamicData['fields']['Index_name'];
                } else {
                    $index = NULL;
                }
                if(isset($dynamicData['fields']['Index_Value'])) {
                    $waarde = $dynamicData['fields']['Index_Value'];
                    $indexvalue = str_replace(",",".",$waarde);
                    $waarde = preg_replace('/\.(?=.*\.)/', '', $indexvalue);
                } else {
                    $waarde = NULL;
                }
                if(isset($dynamicData['fields']['coeff'])) {
                    $coefficient = $dynamicData['fields']['coeff'];
                    $coefficientg = str_replace(",",".",$coefficient);
                    $coefficient = preg_replace('/\.(?=.*\.)/', '', $coefficientg);
                } else {
                    $coefficient = NULL;
                }
                if(isset($dynamicData['fields']['term'])) {
                    $term = $dynamicData['fields']['term'];
                    $termg = str_replace(",",".",$term);
                    $term = preg_replace('/\.(?=.*\.)/', '', $termg);
                } else {
                    $term = NULL;
                }

                $newdate = $date; // Carbon::createFromFormat('d/m/Y', $date)->toDateString();
                $newValidFrom = $validFrom; // Carbon::createFromFormat('d/m/Y', $validFrom)->toDateString();
                $newValidtill = $validTill; // Carbon::createFromFormat('d/m/Y', $validTill)->toDateString();
               
                DynamicGasResidential::Create(
                    ['product_id' => $proId,
                            '_id' => $recordId,
                            'product_id' => $proId,
                            'date' => $newdate,
                            'valid_from' => $newValidFrom,
                            'valid_till' => $newValidtill,
                            'supplier' => $supplier,
                            'product' => $product,
                            'fuel' => $fuel,
                            'duration' => $duration,
                            'fixed_indexed' => $fixedIndiable,
                            'segment' => $segment,
                            'VL' => $vl,
                            'WA' => $wa,
                            'BR' => $br,
                            'volume_lower' => $volumeLower,
                            'volume_upper' => $volumeUpper,
                            'price_gas' => $priceGas,
                            'ff' => $ff,
                            'prices_url_nl' => $pricesUrlNL,
                            'prices_url_fr' => $pricesUrlFR,
                            'index_name' => $index,
                            'index_value' => $waarde,
                            'coeff' => $coefficient,
                            'term' => $term,
                        ]);  
                }  
            }
        }
        $this->info('Products saved from Dynamic data of Gas Residential');
        $this->info('Next');
    }
}

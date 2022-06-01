<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\DynamicElectricProfessional;
use App\Models\DynamicGasProfessional;
use App\Models\Supplier;
use Carbon\Carbon;
use Session;

class DynamicDataProfessional extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'professionaldata:import';

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
            $this->alert('Fetching professional data from Airtable : ' . Carbon::now());
            $this->_electricityProfessional();
            $this->_gasProfessional();
            $this->comment('Completed at : ' . Carbon::now());
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    private function _electricityProfessional()
    {
        Session::put('offset','0');
        DynamicElectricProfessional::truncate(); 
        while(Session::get('offset')!='stop') {
            try {
                $client = new \GuzzleHttp\Client();
                $query['pageSize'] =100;  
                $query['offset'] =Session::get('offset');
                $request = $client->get('https://api.airtable.com/v0/applSCRl4UvL2haqK/Dyn%20data%20-%20E%20PRO', [
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
           
            foreach ($json['records'] as $electricityProfessional) {
                if (!empty($electricityProfessional['fields']['Product']) && !empty($electricityProfessional['fields']['PROD ID'])) {
                    if(isset($electricityProfessional['id'])){
                        $recordId = $electricityProfessional['id'];
                    } else {
                        $recordId = NULL;
                    }
                    
                    if(isset($electricityProfessional['fields']['PROD ID'])){
                        $productId = $electricityProfessional['fields']['PROD ID'];
                        $request = $client->get('https://api.airtable.com/v0/applSCRl4UvL2haqK/Stat%20data%20-%20E%20PRO/'.$productId[0], [
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
                    if(isset($electricityProfessional['fields']['Date'])){
                        $date = $electricityProfessional['fields']['Date'];
                    } else {
                        $date = NULL;
                    }
                    if(isset($electricityProfessional['fields']['Valid from'])){
                        $validFrom = $electricityProfessional['fields']['Valid from'];
                    } else {
                        $validFrom = NULL;
                    }
                    if(isset($electricityProfessional['fields']['Valid till'])){
                        $validTill = $electricityProfessional['fields']['Valid till'];
                    } else {
                        $validTill = NULL;
                    }
                    if(isset($electricityProfessional['fields']['Supplier'])){
                        $supplier = $electricityProfessional['fields']['Supplier'];
                        $request = $client->get('https://api.airtable.com/v0/applSCRl4UvL2haqK/Suppliers/'.$supplier[0], [
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
                    if(isset($electricityProfessional['fields']['Product'][0])){
                        $product = $electricityProfessional['fields']['Product'][0];
                    } else {
                        $product = NULL;
                    }
                    if(isset($electricityProfessional['fields']['Fuel'][0])){
                        $fuel = $electricityProfessional['fields']['Fuel'][0];
                    } else {
                        $fuel = NULL;
                    }
                    if(isset($electricityProfessional['fields']['Duration'])){
                        $duration = $electricityProfessional['fields']['Duration'];
                    } else {
                        $duration = 0;
                    }
                    if(isset($electricityProfessional['fields']['Price Type'][0])){
                        $fixedIndiable = $electricityProfessional['fields']['Price Type'][0];
                    } else {
                        $fixedIndiable = NULL;
                    }
                    if(isset($electricityProfessional['fields']['Customer Segment'][0])){
                        $segment = $electricityProfessional['fields']['Customer Segment'][0];
                    } else {
                        $segment = NULL;
                    }
                    if(isset($electricityProfessional['fields']['VL'])){
                        $vl = $electricityProfessional['fields']['VL'];
                    } else {
                        $vl = NULL;
                    }
                    if(isset($electricityProfessional['fields']['WA'])){
                        $wa = $electricityProfessional['fields']['WA'];
                    } else {
                        $wa = NULL;
                    }
                    if(isset($electricityProfessional['fields']['BR'])){
                        $br = $electricityProfessional['fields']['BR'];
                    } else {
                        $br = NULL;
                    }
                    if(isset($electricityProfessional['fields']['Volume lower'])){
                        $volumeLower = $electricityProfessional['fields']['Volume lower'];
                    } else {
                        $volumeLower = NULL;
                    }
                    if(isset($electricityProfessional['fields']['Volume upper'])){
                        $volumeUpper = $electricityProfessional['fields']['Volume upper'];
                    } else {
                        $volumeUpper = NULL;
                    }
                    if(isset($electricityProfessional['fields']['Price Single'])){
                        $priceSingle = $electricityProfessional['fields']['Price Single'];
                        $priceSing = str_replace(",",".",$priceSingle);
                        $priceSingle = preg_replace('/\.(?=.*\.)/', '', $priceSing);
                    } else {
                        $priceSingle = NULL;
                    }
                    if(isset($electricityProfessional['fields']['Price Day'])){
                        $priceDay = $electricityProfessional['fields']['Price Day'];
                        $priceDy = str_replace(",",".",$priceDay);
                        $priceDay = preg_replace('/\.(?=.*\.)/', '', $priceDy);
                    } else {
                        $priceDay = NULL;
                    }
                    if(isset($electricityProfessional['fields']['Price Night'])){
                        $priceNight = $electricityProfessional['fields']['Price Night'];
                        $priceNi = str_replace(",",".",$priceNight);
                        $priceNight = preg_replace('/\.(?=.*\.)/', '', $priceNi);
                    } else {
                        $priceNight = NULL;
                    }
                    if(isset($electricityProfessional['fields']['Price Excl Night'])){
                        $priceExclNight = $electricityProfessional['fields']['Price Excl Night'];
                        $priceExclNig = str_replace(",",".",$priceExclNight);
                        $priceExclNight = preg_replace('/\.(?=.*\.)/', '', $priceExclNig);
                    } else {
                        $priceExclNight = NULL;
                    }
                    if(isset($electricityProfessional['fields']['FF Single'])){
                        $ffSingle = $electricityProfessional['fields']['FF Single'];
                        $ffSing = str_replace(",",".",$ffSingle);
                        $ffSingle = preg_replace('/\.(?=.*\.)/', '', $ffSing);
                    } else {
                        $ffSingle = NULL;
                    }
                    if(isset($electricityProfessional['fields']['FF day/night'])) {
                        $ffDayNight = $electricityProfessional['fields']['FF day/night'];
                        $ffDayNig = str_replace(",",".",$ffDayNight);
                        $ffDayNight = preg_replace('/\.(?=.*\.)/', '', $ffDayNig);
                    } else {
                        $ffDayNight = NULL;
                    }
                    if(isset($electricityProfessional['fields']['FF excl night'])) {
                        $ffExclNight = $electricityProfessional['fields']['FF excl night'];
                        $ffExclNig = str_replace(",",".",$ffExclNight);
                        $ffExclNight = preg_replace('/\.(?=.*\.)/', '', $ffExclNig);
                    } else {
                        $ffExclNight = NULL;
                    }
                    if(isset($electricityProfessional['fields']['GSC VL'])) {
                        $gscVl = $electricityProfessional['fields']['GSC VL'];
                        $gscV = str_replace(",",".",$gscVl);
                        $gscVl = preg_replace('/\.(?=.*\.)/', '', $gscV);
                    } else {
                        $gscVl = NULL;
                    }
                    if(isset($electricityProfessional['fields']['WKC VL'])) {
                        $wkcVl = $electricityProfessional['fields']['WKC VL'];
                        $wkcV = str_replace(",",".",$wkcVl);
                        $wkcVl = preg_replace('/\.(?=.*\.)/', '', $wkcV);
                    } else {
                        $wkcVl = NULL;
                    }
                    if(isset($electricityProfessional['fields']['GSC WA'])) {
                        $gscWa = $electricityProfessional['fields']['GSC WA'];
                        $gscW = str_replace(",",".",$gscWa);
                        $gscWa = preg_replace('/\.(?=.*\.)/', '', $gscW);
                    } else {
                        $gscWa = NULL;
                    }
                    if(isset($electricityProfessional['fields']['GSC BR'])) {
                        $gscBr = $electricityProfessional['fields']['GSC BR'];
                        $gscB = str_replace(",",".",$gscBr);
                        $gscBr = preg_replace('/\.(?=.*\.)/', '', $gscB);
                    } else {
                        $gscBr = NULL;
                    }
                    if(isset($electricityProfessional['fields']['Prices URL NL'])) {
                        $pricesUrlNL = $electricityProfessional['fields']['Prices URL NL'];
                    } else {
                        $pricesUrlNL = NULL;
                    }
                    if(isset($electricityProfessional['fields']['Prices URL FR'])) {
                        $pricesUrlFR = $electricityProfessional['fields']['Prices URL FR'];
                    } else {
                        $pricesUrlFR = NULL;
                    }
                    if(isset($electricityProfessional['fields']['Index_name'])) {
                        $index = $electricityProfessional['fields']['Index_name'];
                    } else {
                        $index = NULL;
                    }
                    if(isset($electricityProfessional['fields']['Index_value'])) {
                        $waarde = $electricityProfessional['fields']['Index_value'];
                        $indexVal = str_replace(",",".",$waarde);
                        $waarde = preg_replace('/\.(?=.*\.)/', '', $indexVal);
                    } else {
                        $waarde = NULL;
                    }
                    if(isset($electricityProfessional['fields']['coeff_single'])) {
                        $coefficientSingle = $electricityProfessional['fields']['coeff_single'];
                        $coefficientSin = str_replace(",",".",$coefficientSingle);
                        $coefficientSingle = preg_replace('/\.(?=.*\.)/', '', $coefficientSin);
                    } else {
                        $coefficientSingle = NULL;
                    }
                    if(isset($electricityProfessional['fields']['term_single'])) {
                        $termSingle = $electricityProfessional['fields']['term_single'];
                        $termSin = str_replace(",",".",$termSingle);
                        $termSingle = preg_replace('/\.(?=.*\.)/', '', $termSin);
                    } else {
                        $termSingle = NULL;
                    }
                    if(isset($electricityProfessional['fields']['coeff_day'])) {
                        $coefficientDay = $electricityProfessional['fields']['coeff_day'];
                        $coefficientD = str_replace(",",".",$coefficientDay);
                        $coefficientDay = preg_replace('/\.(?=.*\.)/', '', $coefficientD);
                    } else {
                        $coefficientDay = NULL;
                    }
                    if(isset($electricityProfessional['fields']['term_day'])) {
                        $termDay = $electricityProfessional['fields']['term_day'];
                        $termD = str_replace(",",".",$termDay);
                        $termDay = preg_replace('/\.(?=.*\.)/', '', $termD);
                    } else {
                        $termDay = NULL;
                    }
                    if(isset($electricityProfessional['fields']['coeff_night'])) {
                        $coefficientNight = $electricityProfessional['fields']['coeff_night'];
                        $coefficientNig = str_replace(",",".",$coefficientNight);
                        $coefficientNight = preg_replace('/\.(?=.*\.)/', '', $coefficientNig);
                    } else {
                        $coefficientNight = NULL;
                    }
                    if(isset($electricityProfessional['fields']['term_night'])) {
                        $termNight = $electricityProfessional['fields']['term_night'];
                        $termNig = str_replace(",",".",$termNight);
                        $termNight = preg_replace('/\.(?=.*\.)/', '', $termNig);
                    } else {
                        $termNight = NULL;
                    }
                    if(isset($electricityProfessional['fields']['coeff_excl'])) {
                        $coefficientExcl = $electricityProfessional['fields']['coeff_excl'];
                        $coefficientEx = str_replace(",",".",$coefficientExcl);
                        $coefficientExcl = preg_replace('/\.(?=.*\.)/', '', $coefficientEx);
                    } else {
                        $coefficientExcl = NULL;
                    }
                    if(isset($electricityProfessional['fields']['term_excl'])) {
                        $termExcl = $electricityProfessional['fields']['term_excl'];
                        $termEx = str_replace(",",".",$termExcl);
                        $termExcl = preg_replace('/\.(?=.*\.)/', '', $termEx);
                    } else {
                        $termExcl = NULL;
                    }
                    
                   $dateString = $validTill;
                //    echo '             ###             ',$dateString;
                   $newValidtill =$dateString; // Carbon::createFromFormat('d/m/Y', $dateString)->toDateString();
                   
                //    echo '    ****   new date format    *****        ',$newValidtill;
                  
                $newdate =$date;// Carbon::createFromFormat('d/m/Y', $date)->toDateString();
                $newValidFrom =$validFrom;// Carbon::createFromFormat('d/m/Y', $validFrom)->toDateString();
                
                $regionValue=Supplier::where('commercial_name',$supplier)->first();
                $gscVl=$regionValue->gsc_vl/1.06;
                $wkcVl=$regionValue->wkc_vl/1.06;
                $gscWa=$regionValue->gsc_wa/1.06;
                $gscBr=$regionValue->gsc_br/1.06;
                
                    
                    DynamicElectricProfessional::Create(
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
        $this->info('Products saved from Dynamic data of Electricity Professional');
        $this->info('Next');
    }

    private function _gasProfessional()
    {
        Session::put('offset','0'); 
        DynamicGasProfessional::truncate();
        while(Session::get('offset')!='stop') {
            try {
                $client = new \GuzzleHttp\Client();
                $query['pageSize'] =100;  
                $query['offset'] =Session::get('offset');
                $request = $client->get('https://api.airtable.com/v0/applSCRl4UvL2haqK/Dyn%20data%20-%20G%20PRO', [
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
            foreach ($json['records'] as $gasProfessional) {
                if (!empty($gasProfessional['fields']['Product']) && !empty($gasProfessional['fields']['PROD ID'])) {
                    if(isset($gasProfessional['id'])){
                        $recordId = $gasProfessional['id'];
                    } else {
                        $recordId = NULL;
                    }
                    
                    if(isset($gasProfessional['fields']['PROD ID'])){
                        $productId = $gasProfessional['fields']['PROD ID'];
                        $request = $client->get('https://api.airtable.com/v0/applSCRl4UvL2haqK/Stat%20data%20-%20G%20PRO/'.$productId[0], [
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
                    if(isset($gasProfessional['fields']['Date'])){
                        $date = $gasProfessional['fields']['Date'];
                    } else {
                        $date = NULL;
                    }
                    if(isset($gasProfessional['fields']['Valid from'])){
                        $validFrom = $gasProfessional['fields']['Valid from'];
                    } else {
                        $validFrom = NULL;
                    }
                    if(isset($gasProfessional['fields']['Valid till'])){
                        $validTill = $gasProfessional['fields']['Valid till'];
                    } else {
                        $validTill = NULL;
                    }
                    if(isset($gasProfessional['fields']['Supplier'])){
                        $supplier = $gasProfessional['fields']['Supplier'];
                        $request = $client->get('https://api.airtable.com/v0/applSCRl4UvL2haqK/Suppliers/'.$supplier[0], [
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
                    if(isset($gasProfessional['fields']['Product'][0])){
                        $product = $gasProfessional['fields']['Product'][0];
                    } else {
                        $product = NULL;
                    }
                    if(isset($gasProfessional['fields']['Fuel'][0])){
                        $fuel = $gasProfessional['fields']['Fuel'][0];
                    } else {
                        $fuel = NULL;
                    }
                    if(isset($gasProfessional['fields']['Duration'])){
                        $duration = $gasProfessional['fields']['Duration'];
                    } else {
                        $duration = 0;
                    }
                    if(isset($gasProfessional['fields']['Price Type'][0])){
                        $fixedIndiable = $gasProfessional['fields']['Price Type'][0];
                    } else {
                        $fixedIndiable = NULL;
                    }
                    if(isset($gasProfessional['fields']['Customer Segment'][0])){
                        $segment = $gasProfessional['fields']['Customer Segment'][0];
                    } else {
                        $segment = NULL;
                    }
                    if(isset($gasProfessional['fields']['VL'])){
                        $vl = $gasProfessional['fields']['VL'];
                    } else {
                        $vl = NULL;
                    }
                    if(isset($gasProfessional['fields']['WA'])){
                        $wa = $gasProfessional['fields']['WA'];
                    } else {
                        $wa = NULL;
                    }
                    if(isset($gasProfessional['fields']['BR'])){
                        $br = $gasProfessional['fields']['BR'];
                    } else {
                        $br = NULL;
                    }
                    if(isset($gasProfessional['fields']['Volume lower'])){
                        $volumeLower = $gasProfessional['fields']['Volume lower'];
                    } else {
                        $volumeLower = NULL;
                    }
                    if(isset($gasProfessional['fields']['Volume upper'])){
                        $volumeUpper = $gasProfessional['fields']['Volume upper'];
                    } else {
                        $volumeUpper = NULL;
                    }
                    if(isset($gasProfessional['fields']['Price gas'])){
                        $priceGas = $gasProfessional['fields']['Price gas'];
                        $priceG = str_replace(",",".",$priceGas);
                        $priceGas = preg_replace('/\.(?=.*\.)/', '', $priceG);
                    } else {
                        $priceGas = NULL;
                    }
                    if(isset($gasProfessional['fields']['FF'])){
                        $ff = $gasProfessional['fields']['FF'];
                        $ffgas = str_replace(",",".",$ff);
                        $ff = preg_replace('/\.(?=.*\.)/', '', $ffgas);
                    } else {
                        $ff = NULL;
                    }
                    if(isset($gasProfessional['fields']['Prices URL NL'])) {
                        $pricesUrlNL = $gasProfessional['fields']['Prices URL NL'];
                    } else {
                        $pricesUrlNL = NULL;
                    }
                    if(isset($gasProfessional['fields']['Prices URL FR'])) {
                        $pricesUrlFR = $gasProfessional['fields']['Prices URL FR'];
                    } else {
                        $pricesUrlFR = NULL;
                    }
                    if(isset($gasProfessional['fields']['Index_name'])) {
                        $index = $gasProfessional['fields']['Index_name'];
                    } else {
                        $index = NULL;
                    }
                    if(isset($gasProfessional['fields']['Index_Value'])) {
                        $waarde = $gasProfessional['fields']['Index_Value'];
                        $indexvalue = str_replace(",",".",$waarde);
                        $waarde = preg_replace('/\.(?=.*\.)/', '', $indexvalue);
                    } else {
                        $waarde = NULL;
                    }
                    if(isset($gasProfessional['fields']['coeff'])) {
                        $coefficient = $gasProfessional['fields']['coeff'];
                        $coefficientg = str_replace(",",".",$coefficient);
                        $coefficient = preg_replace('/\.(?=.*\.)/', '', $coefficientg);
                    } else {
                        $coefficient = NULL;
                    }
                    if(isset($gasProfessional['fields']['term'])) {
                        $term = $gasProfessional['fields']['term'];
                        $termg = str_replace(",",".",$term);
                        $term = preg_replace('/\.(?=.*\.)/', '', $termg);
                    } else {
                        $term = NULL;
                    }
    
                    $time = strtotime($date);
                    $newdate =$date; // date('Y-m-d',$time);
                    $time = strtotime($validFrom);
                    $newValidFrom =$validFrom; // date('Y-m-d',$time);
                    $dateString = $validTill;
                    $newValidtill =$dateString; // Carbon::createFromFormat('d/m/Y', $dateString)->toDateString();
                    
                    DynamicGasProfessional::Create(
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
        $this->info('Products saved from Dynamic data of Gas Professional');
        $this->info('Electricity Taxes');
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Netcostes;
use Session;
use Carbon\Carbon;

class NetcostE extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'netcoste:update';

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
      Netcostes::truncate();
      $this->alert('Fetching Netcost E data from Airtable : ' . Carbon::now());
     
      $progressBar = $this->output->createProgressBar();
      $progressBar->start();
        Session::put('offset','0');     

          while(Session::get('offset')!='stop'){ 

           try{ 
            $client = new \GuzzleHttp\Client(); 
            $query['pageSize'] =100;  
            $query['offset'] =Session::get('offset');
              $request = $client->get('https://api.airtable.com/v0/applSCRl4UvL2haqK/Netcosts%20-%20E', [
                  'headers' => [
                      'Accept' => 'application/json',
                      'Content-type' => 'application/json',
                      'Authorization' => 'Bearer keySZo45QUBRPLwjL'
                  ],
                  'query' => $query
                  
              ]);
            }catch (\Exception $e) { 
              return $e->getCode();           
            }

         
            $response = $request->getBody()->getContents();       
            $json = json_decode($response, true);
         
            if(isset($json['offset'])){
              Session::put('offset',$json['offset']);
            }else{
              Session::put('offset','stop');
              
            }

            foreach ($json['records'] as $pack_res) {
              if(!empty($pack_res['fields']['Date'])) {         
              if(isset($pack_res['id'])){
                    $recordId = $pack_res['id'];
                } else {
                    $recordId = NULL;
                }
              if(isset($pack_res['fields']['Date'])){
                $date = $pack_res['fields']['Date'];
              }else{
                $date ="";
              }
  
              if(isset($pack_res['fields']['Valid from'])){
                $validFrom = $pack_res['fields']['Valid from'];
              }else{
                $validFrom ="";
              }
  
              if(isset($pack_res['fields']['Valid till'])){
                $validTill = $pack_res['fields']['Valid till'];
              }else{
                $validTill ="";
              }
              
              if(isset($pack_res['fields']['DGO'])){
                $dnb = $pack_res['fields']['DGO'];
                $request = $client->get('https://api.airtable.com/v0/applSCRl4UvL2haqK/Netcosts%20-%20E/'.$dnb[0], [
                  'headers' => [
                      'Accept' => 'application/json',
                      'Content-type' => 'application/json',
                      'Authorization' => 'Bearer keySZo45QUBRPLwjL'
                  ]
                  
                ]);
            
                $response = $request->getBody()->getContents();       
                $json = json_decode($response, true);
                $dnb_e = $json['fields']['DGO'];
              }else{
                $dnb ="";
              }
              
              if(isset($pack_res['fields']['DGO - Electrabel name'])){
                $electrabelbenaming_dnb = $pack_res['fields']['DGO - Electrabel name'];
              }else{
                $electrabelbenaming_dnb ="";
              }
              
              if(isset($pack_res['fields']['Fuel'])){
                $fuel = $pack_res['fields']['Fuel'];
              }else{
                $fuel ="";
              }
  
              if(isset($pack_res['fields']['Customer Segment'])){
                $segment = $pack_res['fields']['Customer Segment'];
              }else{
                $segment ="";
              }
              if(isset($pack_res['fields']['VL'])){
                $vl = $pack_res['fields']['VL'];
              }else{
                $vl ="";
              }              
              if(isset($pack_res['fields']['WA'])){
                $wa = $pack_res['fields']['WA'];
              }else{
                $wa ="";
              }
              if(isset($pack_res['fields']['BR'])){
                $br = $pack_res['fields']['BR'];
              }else{
                $br ="";
              }  
              if(isset($pack_res['fields']['Volume lower'])){
                $volume_lower = $pack_res['fields']['Volume lower'];
              }else{
                $volume_lower ="0";
              }             
              if(isset($pack_res['fields']['Volume upper'])){
                $volume_upper = $pack_res['fields']['Volume upper'];
              }else{
                $volume_upper ="";
              }             
              if(isset($pack_res['fields']['Price single'])){
                $price_single = $pack_res['fields']['Price single'];
                $priceSing = str_replace(",",".",$price_single);
                $price_single = preg_replace('/\.(?=.*\.)/', '', $priceSing);
              }else{
                $price_single ="";
              }

              if(isset($pack_res['fields']['Price day'])){
                $price_day = $pack_res['fields']['Price day'];
                $priceDay = str_replace(",",".",$price_day);
                $price_day = preg_replace('/\.(?=.*\.)/', '', $priceDay);
              }else{
                $price_day ="";
              }

              if(isset($pack_res['fields']['Price night'])){
                $price_night = $pack_res['fields']['Price night'];
                $pricenight = str_replace(",",".",$price_night);
                $price_night = preg_replace('/\.(?=.*\.)/', '', $pricenight);
              }else{
                $price_night ="";
              }

              if(isset($pack_res['fields']['Price Excl Night'])){
                $price_excl_night = $pack_res['fields']['Price Excl Night'];
                $priceExclnight = str_replace(",",".",$price_excl_night);
                $price_excl_night = preg_replace('/\.(?=.*\.)/', '', $priceExclnight);
              }else{
                $price_excl_night ="";
              }

              if(isset($pack_res['fields']['Reading meter'])){
                $reading_meter = $pack_res['fields']['Reading meter'];
                $readingMeter = str_replace(",",".",$reading_meter);
                $reading_meter = preg_replace('/\.(?=.*\.)/', '', $readingMeter);
              }else{
                $reading_meter ="";
              }

              if(isset($pack_res['fields']['Prosumers'])){
                $prosumers = $pack_res['fields']['Prosumers'];
                $prosumer = str_replace(",",".",$prosumers);
                $prosumers = preg_replace('/\.(?=.*\.)/', '', $prosumer);
              }else{
                $prosumers ="";
              }

              if(isset($pack_res['fields']['Transport_var'])){
                $transport = $pack_res['fields']['Transport_var'];
                $transp = str_replace(",",".",$transport);
                $transport = preg_replace('/\.(?=.*\.)/', '', $transp);
              }else{
                $transport ="";
              }
             
                $newdate =$date;// Carbon::createFromFormat('d/m/Y', $date)->toDateString();
                $newValidFrom =$validFrom;// Carbon::createFromFormat('d/m/Y', $validFrom)->toDateString();
                $newValidtill =$validTill;// Carbon::createFromFormat('d/m/Y', $validTill)->toDateString();
              
              Netcostes::create(                                
                    [   
                    '_id' => $recordId,               
                    'date' => $newdate,
                    'valid_from' => $newValidFrom,
                    'valid_till' => $newValidtill,
                    'dgo' => $dnb_e,
                    'dgo_electrabelname' => $electrabelbenaming_dnb,
                    'fuel' => $fuel,
                    'segment' => $segment,  
                    'VL' => $vl,
                    'WA' => $wa,
                    'BR' => $br,
                    'volume_lower' => $volume_lower,
                    'volume_upper'=>$volume_upper,
                    'price_single'=>$price_single,
                    'price_day'=>$price_day,
                    'price_night'=>$price_night,
                    'price_excl_night'=>$price_excl_night,
                    'reading_meter'=>$reading_meter,
                    'prosumers'=>$prosumers,
                    'transport'=>$transport,                    
                    ]


                    ); 
                  } 

                    $progressBar->advance();
             }


          }

          $progressBar->finish();
          $this->comment('Completed at : ' . Carbon::now());
    }
}

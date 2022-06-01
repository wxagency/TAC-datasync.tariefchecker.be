<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Netcostgs;
use Session;
use Carbon\Carbon;

class NetcostG extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'netcostg:update';

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
      Netcostgs::truncate();

      $this->alert('Fetching Netcost G data from Airtable : ' . Carbon::now());
      $progressBar = $this->output->createProgressBar();
      $progressBar->start();
        Session::put('offset','0');     

        while(Session::get('offset')!='stop') { 

         try{ 
          $client = new \GuzzleHttp\Client(); 
          $query['pageSize'] =100;  
          $query['offset'] =Session::get('offset');
            $request = $client->get('https://api.airtable.com/v0/applSCRl4UvL2haqK/Netcosts%20-%20G', [
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
              $request = $client->get('https://api.airtable.com/v0/applSCRl4UvL2haqK/Netcosts%20-%20G/'.$dnb[0], [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-type' => 'application/json',
                    'Authorization' => 'Bearer keySZo45QUBRPLwjL'
                ]
                
              ]);
          
              $response = $request->getBody()->getContents();       
              $json = json_decode($response, true);
              $dnb_g = $json['fields']['DGO'];
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
            if(isset($pack_res['fields']['Fixed term'])){
              $fixed_term = $pack_res['fields']['Fixed term'];
              $fixedTerm = str_replace(",",".",$fixed_term);
              $fixed_term = preg_replace('/\.(?=.*\.)/', '', $fixedTerm);
            }else{
              $fixed_term ="";
            }

            if(isset($pack_res['fields']['Variable term'])){
              $variable_term = $pack_res['fields']['Variable term'];
              $variableTerm = str_replace(",",".",$variable_term);
              $variable_term = preg_replace('/\.(?=.*\.)/', '', $variableTerm);
            }else{
              $variable_term ="";
            }

            if(isset($pack_res['fields']['Reading meter yearly'])){
              $reading_meter_yearly = $pack_res['fields']['Reading meter yearly'];
              $reading_yearly = str_replace(",",".",$reading_meter_yearly);
              $reading_meter_yearly = preg_replace('/\.(?=.*\.)/', '', $reading_yearly);
            }else{
              $reading_meter_yearly ="";
            }

            if(isset($pack_res['fields']['Reading meter monthly'])){
              $reading_meter_monthly = $pack_res['fields']['Reading meter monthly'];
              $reading_monthly = str_replace(",",".",$reading_meter_monthly);
              $reading_meter_monthly = preg_replace('/\.(?=.*\.)/', '', $reading_monthly);
            }else{
              $reading_meter_monthly ="";
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

            Netcostgs::create(                                
                  [  
                  '_id' => $recordId,                
                  'date' => $newdate,
                  'valid_from' => $newValidFrom,
                  'valid_till' => $newValidtill,
                  'dgo' => $dnb_g,
                  'dgo_electrabelname' => $electrabelbenaming_dnb,
                  'fuel' => $fuel,
                  'segment' => $segment,  
                  'VL' => $vl,
                  'WA' => $wa,
                  'BR' => $br,
                  'volume_lower' => $volume_lower,
                  'volume_upper'=>$volume_upper,
                  'fixed_term'=>$fixed_term,
                  'variable_term'=>$variable_term,
                  'reading_meter_yearly'=>$reading_meter_yearly,
                  'reading_meter_monthly'=>$reading_meter_monthly,
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

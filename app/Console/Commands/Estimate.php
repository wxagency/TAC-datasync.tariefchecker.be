<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\EstimateConsumption;
use Carbon\Carbon;
use Session;
use DateTime;

class Estimate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'estimate:generate';

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
            $this->_manageEstimate();
            $this->comment('Completed at : ' . Carbon::now());
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    private function _manageEstimate()
    {
        EstimateConsumption::truncate();
        Session::put('offset','0'); 
        while(Session::get('offset')!='stop') {
            try {
                $client = new \GuzzleHttp\Client();
                $query['pageSize'] =100;  
                $query['offset'] =Session::get('offset');
                $request = $client->get('https://api.airtable.com/v0/applSCRl4UvL2haqK/Estimate%20-%20Consumption', [
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
            foreach ($json['records'] as $estimate) {
                
                    

                    if(isset($estimate['fields']['Id'])){
                        $id = $estimate['fields']['Id'];
                    } else {
                        $id = NULL;
                    }
                   
                    if(isset($estimate['fields']['residents'])){
                        $residents = $estimate['fields']['residents'];
                    } else {
                        $residents = NULL;
                    }
                    if(isset($estimate['fields']['building type'])){
                        
                        if($estimate['fields']['building type']=="house < 200 m²"){
                            
                            $building_type = "lesser200";
                        }
                        if($estimate['fields']['building type']=="house > 200 m²"){
                            
                            $building_type = "greater200";
                        }
                        if($estimate['fields']['building type']=="Appartement"){
                            
                            $building_type = "Appartement";
                        }
                        
                    } else {
                        $building_type = NULL;
                    }
                    if(isset($estimate['fields']['Isolation level'])){
                        $isolation_level = $estimate['fields']['Isolation level'];
                    } else {
                        $isolation_level = NULL;
                    }
                    if(isset($estimate['fields']['Heating system'])){
                        $heating_system = $estimate['fields']['Heating system'];
                    } else {
                        $heating_system = NULL;
                    }
                    if(isset($estimate['fields']['E-mono'])){
                        $e_mono = $estimate['fields']['E-mono'];
                    } else {
                        $e_mono = NULL;
                    }
                    if(isset($estimate['fields']['E-day'])){
                        $e_day = $estimate['fields']['E-day'];
                    } else {
                        $e_day = NULL;
                    }
                    if(isset($estimate['fields']['E-night'])){
                        $e_night = $estimate['fields']['E-night'];
                    } else {
                        $e_night = NULL;
                    }
                    if(isset($estimate['fields']['E-excl night'])){
                        $excl_night = $estimate['fields']['E-excl night'];
                    } else {
                        $excl_night = NULL;
                    }
                    if(isset($estimate['fields']['G'])){
                        $gas = $estimate['fields']['G'];
                    } else {
                        $gas = NULL;
                    }
                    
                    
                   

                   
                    EstimateConsumption::create(
                            [
                                'id' => $id,
                                'residents' => $residents,
                                'building_type' => $building_type,
                                'Isolation_level' => $isolation_level,
                                'Heating_system' => $heating_system,
                                'E_mono' => $e_mono,
                                'E_day' => $e_day,
                                'E_night' => $e_night,
                                'E_excl_night' => $excl_night,
                                'G' => $gas
                            ]); 
             
                    
            }
             
        }
        $this->info('All Estimate Consumption data are saved');
    }
}

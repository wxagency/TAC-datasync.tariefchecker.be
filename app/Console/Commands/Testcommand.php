<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;

class Testcommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'airtable:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update all airtables';

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
            $client = new \GuzzleHttp\Client(); 

            try{ 
            $client = new \GuzzleHttp\Client(); 
              $request = $client->get('https://api.airtable.com/v0/app6bZwM5E2SSnySJ/Netcost-E', [
                  'headers' => [
                      'Accept' => 'application/json',
                      'Content-type' => 'application/json',
                      'Authorization' => 'Bearer keyti6w8M4eBgZPDW'
                  ]
              ]);
            }catch (\Exception $e) {   
              if($e->getCode()==400 || $e->getCode()==true){                
                  Session::put('msg','Ongeldige Postcode');
                  return back();
               }
            }
          
            $response = $request->getBody()->getContents();       
            $json = json_decode($response, true);

            dd($json);
    }
}

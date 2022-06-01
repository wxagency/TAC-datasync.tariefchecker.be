<?php

namespace App\Console\Commands\Restore;

use Illuminate\Console\Command;
use App\Models\History\Supplier;
use Carbon\Carbon;

use App\Exports\supplierExport;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class SupplierRestore extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'supplier:restore {table_name}{backupdate}';

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
        // $this->_delete();
        // $this->info("Deleted all data in Airtable");
        // $this->alert('Restoring Data to Airtable : ' . Carbon::now());
        // $this->_restoreSupplier();
        // $this->info("Restored");
        return Excel::download(new supplierExport, 'users.xlsx');
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
                    $request = $client->get('https://api.airtable.com/v0/applSCRl4UvL2haqK/Suppliers', [
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
                    $request =$client->delete('https://api.airtable.com/v0/applSCRl4UvL2haqK/Suppliers', [
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
    private function _restoreSupplier()
    {
        $data=Supplier::where('backupdate', $this->argument('backupdate'))->get();
        foreach ($data as $value) {

            $query['records'][0]['fields']['Id']=$value->supplier_id;
            $query['records'][0]['fields']['Supplier Type']= $value->suppliertype;      
            $query['records'][0]['fields']['Origin']=$value->origin;
            $query['records'][0]['fields']['Official Name']=$value->official_name;
            $query['records'][0]['fields']['Commercial Name']=$value->commercial_name;
            $query['records'][0]['fields']['Abbreviation']=$value->abbreviation;
            $query['records'][0]['fields']['Parent Company']=$value->parent_company;
            $query['records'][0]['fields']['Logo Large']=$value->logo_large;
            $query['records'][0]['fields']['Logo Small']=$value->logo_small;
            $query['records'][0]['fields']['Website']=$value->website;
            $query['records'][0]['fields']['Youtube Video']=$value->youtube_video;
            $query['records'][0]['fields']['Video Webm']=$value->video_webm;
            $query['records'][0]['fields']['B2b Customers']=$value->B2b_customers;
            $query['records'][0]['fields']['B2c Customers']=$value->B2c_customers;
            $query['records'][0]['fields']['Greenpeace Rating']=$value->greenpeace_rating;
            $query['records'][0]['fields']['Vreg Rating']=$value->Vreg_rating;
            $query['records'][0]['fields']['Customer Rating']=$value->customer_rating;
            $query['records'][0]['fields']['Advice Rating']=$value->advice_rating;
            $query['records'][0]['fields']['Presentation']=$value->presentation;
            $query['records'][0]['fields']['Mission Vision']=$value->mission_vision;
            $query['records'][0]['fields']['Values']=$value->supplier_values;
            $query['records'][0]['fields']['Services']=$value->services;
            $query['records'][0]['fields']['Mission Vision Image']=$value->mission_vision_image;
            $query['records'][0]['fields']['Facebook Page']=$value->facebook_page;
            $query['records'][0]['fields']['Twitter Name']=$value->twitter_name;
            $query['records'][0]['fields']['Location']=$value->location;
            $query['records'][0]['fields']['Video Mp4']=$value->video_mp4;
            $query['records'][0]['fields']['Video Ogg']=$value->video_ogg;
            $query['records'][0]['fields']['Video Flv']=$value->video_flv;
            $query['records'][0]['fields']['Greenpeace Report']=$value->greenpeace_report;
            $query['records'][0]['fields']['Greenpeace Report Url']=$value->greenpeace_report_url;
            $query['records'][0]['fields']['Greenpeace Supplier Response']=$value->greenpeace_supplier_response;
            $query['records'][0]['fields']['Greenpeace Production Image']=$value->greenpeace_production_image;
            $query['records'][0]['fields']['Greenpeace Investments Image']=$value->greenpeace_investments_image;
            $query['records'][0]['fields']['Greenpeace Report Pdf']=$value->greenpeace_report_pdf;
            $query['records'][0]['fields']['Tagline']=$value->tagline;
            $query['records'][0]['fields']['Vimeo Url']=$value->vimeo_url;
            $query['records'][0]['fields']['Is Partner']=$value->is_partner;
            $query['records'][0]['fields']['Customer Reviews']=$value->customer_reviews;
            $query['records'][0]['fields']['Logo Medium']=$value->logo_medium;
            $query['records'][0]['fields']['Conversion Value']=$value->conversion_value;

             try {
                $client = new \GuzzleHttp\Client();
               
                $request = $client->post('https://api.airtable.com/v0/applSCRl4UvL2haqK/Suppliers', [
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
    }
}

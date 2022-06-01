<?php

namespace App\Console\Commands\History;

use Illuminate\Console\Command;
use App\Models\Supplier as SUP;

use App\Models\History\Supplier;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Session;

class SupplierHistory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'supplier:backup';

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
        $this->_supplierList();
        $this->info('Completed back up of supplier list');
    }

    private function _supplierList()
    {
        $supplierList = SUP :: all();

        if ( Session::get('backup-date')) {
            $backup = Session::get('backup-date');
        } else {
            $backup = Carbon::now();
            Session::put('backup' , $backup) ;
        }

        foreach ($supplierList as $supplier) {
            Supplier :: Create(                 
                [
                '_id' => $supplier->_id,
                'backupdate' =>$backup,
                'supplier_id' => $supplier->supplier_id,
                'suppliertype' => $supplier->suppliertype,
                'origin' => $supplier->origin,
                'official_name' => $supplier->official_name,
                'commercial_name' => $supplier->commercial_name,
                'abbreviation' => $supplier->abbreviation,
                'parent_company' => $supplier->parent_company,
                'logo_large' => $supplier->logo_large,
                'logo_small'=>$supplier->logo_small,
                'website' => $supplier->website,
                'youtube_video' => $supplier->youtube_video,
                'video_webm' => $supplier->video_webm,
                'B2b_customers' => $supplier->B2b_customers,
                'B2c_customers'=>$supplier->B2c_customers,
                'greenpeace_rating' => $supplier->greenpeace_rating,
                'Vreg_rating' => $supplier->Vreg_rating,
                'customer_rating' => $supplier->customer_rating,
                'advice_rating' => $supplier->advice_rating,
                'presentation'=>$supplier->presentation,
                'mission_vision' => $supplier->mission_vision,
                'supplier_values' => $supplier->supplier_values,
                'services' => $supplier->services,
                'mission_vision_image' => $supplier->mission_vision_image,
                'facebook_page'=>$supplier->facebook_page,
                'twitter_name' => $supplier->twitter_name,
                'location' => $supplier->location,
                'video_mp4' => $supplier->video_mp4,
                'video_ogg' => $supplier->video_ogg,
                'video_flv'=>$supplier->video_flv,
                'greenpeace_report' => $supplier->greenpeace_report,
                'greenpeace_report_url' => $supplier->greenpeace_report_url,
                'greenpeace_supplier_response' => $supplier->greenpeace_supplier_response,
                'greenpeace_production_image' => $supplier->greenpeace_production_image,
                'greenpeace_investments_image'=>$supplier->greenpeace_investments_image,
                'greenpeace_report_pdf' => $supplier->greenpeace_report_pdf,
                'tagline' => $supplier->tagline,
                'vimeo_url' => $supplier->vimeo_url,
                'is_partner' => $supplier->is_partner,
                'customer_reviews' => $supplier->customer_reviews,
                'logo_medium' => $supplier->logo_medium,
                'conversion_value' => $supplier->conversion_value,
                'gsc_vl' => $supplier->gsc_vl,
                'wkc_vl' => $supplier->wkc_vl,
                'gsc_wa' => $supplier->gsc_wa,
                'gsc_br' => $supplier->gsc_br,
                ]
             );
        }
    }
}

<?php

namespace App\Console\Commands\History;

use Illuminate\Console\Command;
use App\Models\StaticPackResidential as SPR;
use App\Models\StaticPackProfessional as SPP;

use App\Models\History\StaticPackResidential;
use App\Models\History\StaticPackProfessional;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use DateTime;

class StaticPack extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SPack:backup';

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
            $this->_packResident();
            $this->_packProfessional();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Backup Residential pack data.
     *
     * @return void
     */ 
    private function _packResident()
    {
        $packResident = SPR::all();
        
        if ( Session::get('backup-date')) {
            $backup = Session::get('backup-date');
        } else {
            $backup = Carbon::now();
            Session::put('backup' , $backup) ;
        }

        foreach ($packResident as $resident) {
          StaticPackResidential::Create(                 
            [
            '_id' => $resident->_id,
            'pack_id' => $resident->pack_id,
            'backupdate' =>$backup,
            'pack_name_NL' => $resident->pack_name_NL,
            'pack_name_FR' => $resident->pack_name_FR,
            'active' => $resident->active,
            'partner' => $resident->partner,
            'pro_id_E' => $resident->pro_id_E,
            'pro_id_G' => $resident->pro_id_G,
            'URL_NL' => $resident->URL_NL,
            'info_NL' => $resident->info_NL,
            'tariff_description_NL' => $resident->tariff_description_NL,
            'URL_FR'=>$resident->URL_FR,
            'info_FR' => $resident->info_FR,
            'tariff_description_FR' => $resident->tariff_description_FR,
            'check_elec' => $resident->check_elec,
            'check_gas' => $resident->check_gas,
            
            ]
  
         );
        }
        $this->info('Packs Residential backup complete');

    }

    /**
     * Backup Professional pack data.
     *
     * @return void
     */
    private function _packProfessional()
    {
        $packProfessional = SPP::all(); 

        if ( Session::get('backup-date')) {
            $backup = Session::get('backup-date');
        } else {
            $backup = Carbon::now();
            Session::put('backup' , $backup) ;
        }

        foreach ($packProfessional as $professional) {
          StaticPackProfessional::Create(                 
            [
            '_id' => $professional->_id,
            'pack_id' => $professional->pack_id,
            'backupdate' =>$backup,
            'pack_name_NL' => $professional->pack_name_NL,
            'pack_name_FR' => $professional->pack_name_FR,
            'active' => $professional->active,
            'partner' => $professional->partner,
            'pro_id_E' => $professional->pro_id_E,
            'pro_id_G' => $professional->pro_id_G,
            'URL_NL' => $professional->URL_NL,
            'info_NL' => $professional->info_NL,
            'tariff_description_NL' => $professional->tariff_description_NL,
            'URL_FR'=>$professional->URL_FR,
            'info_FR' => $professional->info_FR,
            'tariff_description_FR' => $professional->tariff_description_FR,
            'check_elec' => $professional->check_elec,
            'check_gas' => $professional->check_gas,
            
            ]
  
         );
        }
        $this->info('Packs professional backup complete');
    }
}

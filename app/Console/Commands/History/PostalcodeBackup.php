<?php

namespace App\Console\Commands\History;

use Illuminate\Console\Command;
use App\Models\PostalcodeElectricity as PE;
use App\Models\PostalcodeGas as PG;

use App\Models\History\PostalcodeElectricity;
use App\Models\History\PostalcodeGas;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use DateTime;

class PostalcodeBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Postalcode:backup';

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

            $this->info('Backup started for electricity');
            $this->_ElectricityPost();
            $this->_GasPost();
            $this->info('Backup started for electricity');
        } catch (\Exception $e) {
            $this->info('Exception : ', $e->getMessage()) ;
        }
    }

    /**
     * Backup postal code of electricity.
     *
     * @return void
     */
    private function _ElectricityPost()
    {
        $electricityPost = PE::all();

        if (Session::get('backup-date')) {
            $backup = Session::get('backup-date');
        } else {
            $backup = Carbon::now();
            Session::put('backup', $backup);
        }

        foreach ($electricityPost as $codeE) {
            PostalcodeElectricity::create(
                [
                    '_id' => $codeE->_id,
                    'backupdate' => $backup,
                    'distribution_id' => $codeE->distribution_id,
                    'netadmin_zip' => $codeE->netadmin_zip,
                    'netadmin_city' => $codeE->netadmin_city,
                    'netadmin_subcity' => $codeE->netadmin_subcity,
                    'product' => $codeE->product,
                    'grid_operational' => $codeE->grid_operational,
                    'gas_H_L' => $codeE->gas_H_L,
                    'DNB' => $codeE->DNB,
                    'netadmin_website' => $codeE->netadmin_website,
                    'TNB' => $codeE->TNB,
                    'language_code' => $codeE->language_code,
                    'region' => $codeE->region,
                ]
            );
        }
    }

    /**
     * Backup postal code of gas.
     *
     * @return void
     */
    private function _GasPost()
    {
        $gasPost = PG::all();

        if (Session::get('backup-date')) {
            $backup = Session::get('backup-date');
        } else {
            $backup = Carbon::now();
            Session::put('backup', $backup);
        }

        foreach ($gasPost as $codeG) {
            PostalcodeGas::create(
                [
                    '_id' => $codeG->_id,
                    'backupdate' => $backup,
                    'distribution_id' => $codeG->distribution_id,
                    'netadmin_zip' => $codeG->netadmin_zip,
                    'netadmin_city' => $codeG->netadmin_city,
                    'netadmin_subcity' => $codeG->netadmin_subcity,
                    'product' => $codeG->product,
                    'grid_operational' => $codeG->grid_operational,
                    'gas_H_L' => $codeG->gas_H_L,
                    'DNB' => $codeG->DNB,
                    'netadmin_website' => $codeG->netadmin_website,
                    'TNB' => $codeG->TNB,
                    'language_code' => $codeG->language_code,
                    'region' => $codeG->region,
                ]
            );
        }
    }
}

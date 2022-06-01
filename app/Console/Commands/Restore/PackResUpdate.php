<?php

namespace App\Console\Commands\Restore;

use Illuminate\Console\Command;
use App\Models\History\StaticPackResidential;
use Illuminate\Support\Facades\Session;
use App\Console\Commands\Restore\AirtableTrait;

class PackResUpdate extends Command
{
    use AirtableTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pack-res:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $currentElek = [];
    protected $currentGas = [];
    const TABLE = 'Stat data - Packs RES';
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
        $this->info("---Pack Residential Restore started--");
        $this->_update();
        $this->info("---Pack Residential Restore ended--");
    }

    public function _update()
    {
        $restoreDate = $this->getRestoreDate(); 
        if( $restoreDate == false){
            $this->info("---No restore point found--");
            exit;
        }
        $currentData = [];
        $newData = [];
        $data = StaticPackResidential::where('backupdate', $restoreDate)->get()->toArray();
        Session::put('offset', '0');
        while (Session::get('offset') != 'stop') {

            $query['pageSize'] = 100;
            $query['offset'] = Session::get('offset');

            $json = $this->get(self::TABLE, $query);

            if (isset($json['offset'])) {
                Session::put('offset', $json['offset']);
            } else {

                Session::put('offset', 'stop');
            }

            // Here key is the unique value in the Supplier table and Value is the auto generated ID
            
            foreach ($json['records'] as $pack) {

                $currentData[$pack['fields']['PACK ID']] = $pack['id'];
            }
        }
            
        $newData = $data;
        $createRecord = [];
        $updateRecord = [];
        foreach ($newData as $key => $value) {
            $_id = isset($currentData[$value['pack_id']]) ? $currentData[$value['pack_id']] : '';
            if (strlen($_id) > 0) {
                $record = $this->_formatRecord($value, $_id);
                array_push($updateRecord, $record);
                unset($currentData[$value['pack_id']]);
                if (count($updateRecord) == 10) {
                    $this->_updateRecords($updateRecord);
                    $updateRecord = [];
                }
            } else {
                $record = $this->_formatRecord($value, $_id);
                array_push($createRecord, $record);
                if (count($createRecord) == 10) {
                    $this->_createRecords($createRecord);
                    $createRecord = [];
                }
            }
        }
        if (count($updateRecord) > 0) {
            $this->_updateRecords($updateRecord);
            $updateRecord = [];
        }

        if (count($createRecord) > 0) {
            $this->_createRecords($createRecord);
            $createRecord = [];
        }

        $deleteRecords = [];
        foreach ($currentData as $id => $autoKey) {
            $deleteRecords[] = urlencode($autoKey);
            if (count($deleteRecords) == 10) {
                $this->_deleteRecord($deleteRecords);
                $deleteRecords = [];
            }
        }

        if (count($deleteRecords) > 0) {
            $this->_deleteRecord($deleteRecords);
            $deleteRecords = [];
        } 

        $this->info("completed");
        
    }

    function getElekKey($productId) 
    {
        if(count($this->currentElek) == 0) {
            $this->currentElek = $this->_getElekProductID();
        }
        if(isset($this->currentElek[$productId])) {
            foreach($this->currentElek[$productId] as $sup) {
                    return $sup['key'];
            }
            
          return $this->currentElek[$productId][0]['key'];   
        }
        return null;
        
    }

    function getGasKey($productId) 
    {
        if(count($this->currentGas) == 0) {
            $this->currentGas = $this->_getGasProductID();
        }
        if(isset($this->currentGas[$productId])) {
            foreach($this->currentGas[$productId] as $sup) {
                    return $sup['key'];
            }
            
          return $this->currentGas[$productId][0]['key'];   
        }
        return null;
    }

    private function _getElekProductID()
    {
        $currentElek = [];
        Session::put('elek_offset', '0');
        while (Session::get('elek_offset') != 'stop') {

            $query['pageSize'] = 100;
            $query['offset'] = Session::get('elek_offset');

            $json = $this->get('ELEK RES', $query);
            if (isset($json['offset'])) {
                Session::put('elek_offset', $json['offset']);
            } else {

                Session::put('elek_offset', 'stop');
            }

            // Here key is the unique value in the Supplier table and Value is the auto generated ID
            
            foreach ($json['records'] as $elek) {
                $currentElek[$elek['fields']['PROD ID']][] = [
                    'key' => $elek['id'],
                ];
            }
           
        }
    
        return $currentElek;
    }

    private function _getGasProductID()
    {
        $currentGas = [];
        Session::put('gas_offset', '0');
        while (Session::get('gas_offset') != 'stop') {

            $query['pageSize'] = 100;
            $query['offset'] = Session::get('gas_offset');

            $json = $this->get('GAS RES', $query);
            if (isset($json['offset'])) {
                Session::put('gas_offset', $json['offset']);
            } else {

                Session::put('gas_offset', 'stop');
            }

            // Here key is the unique value in the Supplier table and Value is the auto generated ID
            
            foreach ($json['records'] as $gas) {
                $currentGas[$gas['fields']['PROD ID']][] = [
                    'key' => $gas['id'],
                ];
            }
           
        }
    
        return $currentGas;
    }

    function _formatRecord($record, $_id = '')
    {
        $elekKey = $this->getElekKey( $record['pro_id_E']);
        $gasKey = $this->getGasKey( $record['pro_id_G'] );
        $newData = [
            'PACK ID' => $record['pack_id'],
            'Pack Name NL'  =>  $record['pack_name_NL'],
            'PACK NAME FR'  =>  $record['pack_name_FR'],
            'Active'  =>  $record['active'],
            'Partner'  =>  $record['partner'],
            'PROD ID E'  =>  [$elekKey],
            'PROD ID G'  =>  [$gasKey],
            'URL NL'  =>  $record['URL_NL'],
            'Descr_Long_NL'  =>  $record['info_NL'],
            'Descr_Short_NL'  =>  $record['tariff_description_NL'],
            'URL FR'  =>  $record['URL_FR'],
            'Descr_Long_FR'  =>  $record['info_FR'],
            'Descr_Short_FR'  =>  $record['tariff_description_FR'],
            'check elek'  =>  $record['check_elec'],
            'check gas'  =>  $record['check_gas'],
        ];
        $result = [
            'fields' =>  $newData,
        ];
        if (strlen($_id) > 0) {
            $result['id'] = $_id;
        }


        return $result;
    }

    private function _updateRecords($records)
    {

        $requestData = [
            'records' => $records
        ];

        $this->patch(self::TABLE, $requestData, [
            'error' => function ($ex, $data) {
                // die($ex->getMessage());
            }
        ]);
    }

    private function _createRecords($records)
    {
        $requestData = [
            'records' => $records
        ];

        $this->post(self::TABLE, $requestData, [
            'error' => function ($ex, $data) {
                // die($ex->getMessage());
            }
        ]);
    }

    function _deleteRecord($data)
    {
        $requestData = [
            'records' => $data
        ];

        if (count($requestData['records'])) {

            $this->delete(self::TABLE, $requestData, [
                'error' => function ($ex, $data) {
                    // die($ex->getMessage());
                }
            ]);
        }
    }
}

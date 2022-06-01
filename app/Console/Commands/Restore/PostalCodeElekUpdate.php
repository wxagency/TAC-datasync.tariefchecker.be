<?php

namespace App\Console\Commands\Restore;

use Illuminate\Console\Command;
use App\Models\History\PostalcodeElectricity;
use Illuminate\Support\Facades\Session;
use App\Console\Commands\Restore\AirtableTrait;

class PostalCodeElekUpdate extends Command
{
    use AirtableTrait;

    const TABLE = 'Postal Code - DGO - E';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'postalcode-electricity:update';

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
        $this->info("---Postal Code electricity Restore started---");
        $this->_restore();
        $this->info("---Postal Code electricity Restore ended---");
    }

    public function _restore()
    {
        $restoreDate = $this->getRestoreDate(); 
        if( $restoreDate == false){
            $this->info("---No restore point found--");
            exit;
        }
        $counter = 0;
        $currentData = [];
        $newData = [];
        $data = PostalcodeElectricity::where('backupdate', $restoreDate)->get()->toArray();
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
            
            foreach ($json['records'] as $postalcode) {

                $currentData[] = $postalcode['id'];
            }
        }
            
       

        $newData = $data;
        // $createRecord = [];
        
        // foreach ($newData as $key => $value) {
        //     $_id = isset($currentData[$key]) ? $currentData[$key] : '';
        //     $counter ++;
        //     if ( $counter >=1000 ) {
        //         sleep(12); 
        //         $counter = 0;
        //     }
        //     $record = $this->_formatRecord($value,  $_id );
        //     array_push($createRecord, $record);
        //     if (count($createRecord) == 10) {
        //         $this->_updateRecords($createRecord);
        //         $createRecord = [];
        //     }
        // }

        $create_record = [];
        $update_record = [];

        foreach ($newData as $key => $value) {
            $_id = isset($currentData[$key]) ? $currentData[$key] : '';
             if (strlen($_id) > 0) {
                $record = $this->_formatRecord($value, $_id);
                array_push($update_record, $record);
                unset($currentData[$key]);
                if (count($update_record) == 10) {
                    // dd($update_record);
                    $this->_updateRecords($update_record);
                    $update_record = [];
                }
            } else {
                $record = $this->_formatRecord($value, $_id);
                array_push($create_record, $record);
                if (count($create_record) == 10) {
                    $this->_createRecords($create_record);
                    $create_record = [];
                }
            }
        }

        if (count($update_record) > 0) {
            $this->_updateRecords($update_record);
            $update_record = [];
        }

        if (count($create_record) > 0) {
            $this->_createRecords($create_record);
            $create_record = [];
        }

         $this->_deleteTable($currentData);
        $this->info("completed");
        
    }

    function _formatRecord($record, $_id = '')
    {
        $newData = [
            'netadmin_zip' => $record['netadmin_zip'],
            'netadmin_city'  =>  $record['netadmin_city'],
            'netadmin_subcity'  =>  $record['netadmin_subcity'],
            'product'  =>  $record['product'],
            'Grid_operational'  =>  $this->get_value($record['grid_operational']),
            'gas_H_L'  =>  $this->get_value($record['gas_H_L']),
            'DGO'  =>  $this->get_value($record['DNB']),
            'netadmin_website'  =>  $record['netadmin_website'],
            'TNB'  =>  $this->get_value($record['TNB']),
            'language_code'  =>  $this->get_value($record['language_code']),
            'REGION'  =>  $this->get_value($record['region']),
            'distributor_id'  =>  $record['distribution_id'],
        ];
        $result = [
            'fields' =>  $newData,
        ];
        if (strlen($_id) > 0) {
            $result['id'] = $_id;
        }


        return $result;
    }

    private function _deleteTable($currentData)
    {
        $counter = 0;
        $deleteRecords = [];
        foreach ($currentData as $id => $autoKey) {

            $counter ++;
            if ( $counter >=1000 ) {
                sleep(12); 
                $counter = 0;
            }
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
}

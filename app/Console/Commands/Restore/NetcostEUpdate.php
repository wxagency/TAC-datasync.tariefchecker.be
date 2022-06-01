<?php

namespace App\Console\Commands\Restore;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Session;
use App\Console\Commands\Restore\AirtableTrait;
use App\Models\History\Netcostes;

class NetcostEUpdate extends Command
{
    use AirtableTrait;

    const TABLE = 'Netcosts - E';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'netcost-E:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    protected $currentDgo = [];

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
        $this->info("---Netcost Electricity Restore started---");
        $this->_restore();
        $this->info("---Netcost Electricity Restore ended---");
    }

    private function _restore()
    {
        $restoreDate = $this->getRestoreDate(); 
        if( $restoreDate == false){
            $this->info("---No restore point found--");
            exit;
        }
        $currentData = [];
        $newData = [];
        $data = Netcostes::where('backupdate', $restoreDate)->get()->toArray();
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

            foreach ($json['records'] as $discount) {

                $currentData[] = $discount['id'];
            }
        }
        $this->_deleteTable($currentData);

        $newData = $data;
        $createRecord = [];
        foreach ($newData as $key => $value) {

            $record = $this->_formatRecord($value, '');
            array_push($createRecord, $record);
            if (count($createRecord) == 10) {
                $this->_createRecords($createRecord);
                $createRecord = [];
            }
        }

        if (count($createRecord) > 0) {
            $this->_createRecords($createRecord);
            $createRecord = [];
        }

        $this->info("completed");
    }

    private function _getDgo()
    {
        $currentDgo = [];
        Session::put('p_offset', '0');
        while (Session::get('p_offset') != 'stop') {

            $query['pageSize'] = 100;
            $query['offset'] = Session::get('p_offset');

            $json = $this->get('DGO', $query);

            if (isset($json['offset'])) {
                Session::put('p_offset', $json['offset']);
            } else {

                Session::put('p_offset', 'stop');
            }

            // Here key is the unique value in the Supplier table and Value is the auto generated ID

            foreach ($json['records'] as $dgo) {
                /*
                "Belpower" => array:1 [
                "key" => "rec0V1FX4CU6TjsD7"
                ]
                  */

                $currentDgo[$dgo['fields']['DGO']] = [
                    'key' => $dgo['id'],
                ];
            }
        }

        return $currentDgo;
    }

    function getDgoKey($dgo)
    {
        if (count($this->currentDgo) == 0) {
            $this->currentDgo = $this->_getDgo();
        }
        if (isset($this->currentDgo[$dgo])) {
            return $this->currentDgo[$dgo]['key'];
        }
        return null;
    }

    function _formatRecord($record, $_id = '')
    {
        $gdoKey = $this->getDgoKey($record['dgo']);
        $newData = [
            'Date' => $this->dateFormat($record['date']),
            'Valid from'  =>  $this->dateFormat($record['valid_from']),
            'Valid till'  =>  $this->dateFormat($record['valid_till']),
            'DGO'  =>  [$gdoKey],
            'DGO - Electrabel name'  =>  $record['dgo_electrabelname'],
            'Fuel'  =>  $this->getValue($record['fuel']),
            'Customer Segment'  =>  $this->getValue($record['segment']),
            'VL'  =>  $this->getValue($record['VL']),
            'WA'  =>  $this->getValue($record['WA']),
            'BR'  =>  $this->getValue($record['BR']),
            'Volume lower'  =>  $this->getValue($record['volume_lower']),
            'Volume upper'  =>  $this->getValue($record['volume_upper']),
            'Price single'  =>  $this->formatPrice($record['price_single']),
            'Price day'  =>  $this->formatPrice($record['price_day']),
            'Price night'  =>  $this->formatPrice($record['price_night']),
            'Price Excl Night'  =>  $this->formatPrice($record['price_excl_night']),
            'Reading meter'  =>  $this->formatPrice($record['reading_meter']),
            'Prosumers'  =>  $this->formatPrice($record['prosumers']),
            'Transport_var'  =>  $this->formatPrice($record['transport']),
        ];
        $result = [
            'fields' =>  $newData,
        ];
        if (strlen($_id) > 0) {
            $result['id'] = $_id;
        }
        return $result;
    }

    private function _createRecords($records)
    {
        $requestData = [
            'records' => $records
        ];

        $this->post(self::TABLE, $requestData, [
            'error' => function ($ex, $data) {

                foreach ($data['records'] as $rec) {
                    $this->_createRecordsOnError([$rec]);
                }
                // die($ex->getMessage());
            }
        ]);
    }

    private function _createRecordsOnError($records)
    {
        $requestData = [
            'records' => $records
        ];

        $this->post(self::TABLE, $requestData, [
            'error' => function ($ex, $data) {
            }
        ]);
    }

    private function _deleteTable($currentData)
    {
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

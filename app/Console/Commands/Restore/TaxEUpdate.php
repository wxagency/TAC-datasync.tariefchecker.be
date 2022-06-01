<?php

namespace App\Console\Commands\Restore;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Session;
use App\Console\Commands\Restore\AirtableTrait;
use App\Models\History\TaxElectricity;

class TaxEUpdate extends Command
{
    use AirtableTrait;

    const TABLE = 'Tax - E';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tax-E:update';

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
        $this->info("---Tax electricity Restore started---");
        $this->_restore();
        $this->info("---Tax electricity Restore ended---");
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
        $data = TaxElectricity::where('backupdate', $restoreDate)->get()->toArray();
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
            'Date' => $this->formatDate($record['date']),
            'Valid from'  =>  $this->formatDate($record['valid_from']),
            'Valid till'  =>  $this->formatDate($record['valid_till']),
            'DGO'  =>  [$gdoKey],
            'DGO - Electrabel name'  =>  $record['dgo_electrabelname'],
            'Fuel'  =>  $this->getValue($record['fuel']),
            'Customer Segment'  =>  $this->getValue($record['segment']),
            'VL'  =>  $this->getValue($record['VL']),
            'WA'  =>  $this->getValue($record['WA']),
            'BR'  =>  $this->getValue($record['BR']),
            'Volume lower'  =>  $this->getValue($record['volume_lower']),
            'Volume upper'  =>  $this->getValue($record['volume_upper']),
            'Energy contribution'  =>  $this->formatPrice($record['energy_contribution']),
            'Federal contribution'  =>  $this->formatPrice($record['federal_contribution']),
            'Connection fee'  =>  $this->formatPrice($record['connection_fee']),
            'Contribution public services'  =>  $this->formatPrice($record['contribution_public_services']),
            'fixed taks_first res'  =>  $this->formatPrice($record['fixed_tax_first_res']),
            'fixed taks_not first residence'  =>  $this->formatPrice($record['fixed_tax_not_first_res']),
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

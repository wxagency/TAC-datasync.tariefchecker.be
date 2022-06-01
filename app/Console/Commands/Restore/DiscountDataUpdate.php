<?php

namespace App\Console\Commands\Restore;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Session;
use App\Console\Commands\Restore\AirtableTrait;
use App\Models\History\Discount;

class DiscountDataUpdate extends Command
{
    use AirtableTrait;

    const TABLE = 'Discounts';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'discount-data:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $currentSupplier = [];

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
        $this->info("---Discount Restore started---");
        $this->_restore();
        $this->info("---Discount Restore ended---");
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
        $data = Discount::where('backupdate', $restoreDate)->get()->toArray();
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
        $this->currentSupplier = $this->_getSupplier();
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

    private function _getSupplier()
    {
        $currentSupplier = [];
        Session::put('p_offset', '0');
        while (Session::get('p_offset') != 'stop') {

            $query['pageSize'] = 100;
            $query['offset'] = Session::get('p_offset');

            $json = $this->get('Suppliers', $query);

            if (isset($json['offset'])) {
                Session::put('p_offset', $json['offset']);
            } else {

                Session::put('p_offset', 'stop');
            }

            // Here key is the unique value in the Supplier table and Value is the auto generated ID

            foreach ($json['records'] as $supplier) {
                /*
                "Belpower" => array:1 [
                "key" => "rec0V1FX4CU6TjsD7"
                ]
                  */

                $currentSupplier[$supplier['fields']['Commercial Name']] = [
                    'key' => $supplier['id'],
                ];
            }
        }

        return $currentSupplier;
    }

    function getSupplierKey($commmercialName)
    {
        if (count($this->currentSupplier) == 0) {
            $this->currentSupplier = $this->_getSupplier();
        }
        if (isset($this->currentSupplier[$commmercialName])) {
            return $this->currentSupplier[$commmercialName]['key'];
        }
        return null;
    }

    function _formatRecord($record, $_id = '')
    {
        $supplierKey = $this->getSupplierKey($record['supplier']);
        // $supplier = $this->currentSupplier[$record['supplier']];
        // dd($supplier);
        $newData = [
            'Id' => $this->getValue($record['discountId']),
            'Supplier'  =>  [$supplierKey],
            'CreatedAt'  =>  $this->dateStructureFormat($record['discountCreated']),
            'StartDate'  =>  $this->dateStructureFormat($record['startdate']),
            'EndDate'  =>  $this->dateStructureFormat($record['enddate']),
            'CustomerGroup'  =>  $this->getValue($record['customergroup']),
            'VolumeLower'  =>  $this->getValue($record['volume_lower']),
            'VolumeUpper'  =>  $this->getValue($record['volume_upper']),
            'DiscountType'  =>  $this->getValue($record['discountType']),
            'FuelType'  =>  $this->getValue($record['fuelType']),
            'ComparisonType'  =>  $record['comparisonType'],
            'Channel'  =>  $this->getValue($record['channel']),
            'ApplicationVContractDuration'  =>  $this->getValue($record['applicationVContractDuration']),
            'ServiceLevelPayment'  =>  $this->getValue($record['serviceLevelPayment']),
            'ServiceLevelInvoicing'  =>  $this->getValue($record['serviceLevelInvoicing']),
            'ServiceLevelContact'  =>  $this->getValue($record['serviceLevelContact']),
            'DiscountCodeE'  =>  $record['discountcodeE'],
            'DiscountCodeG'  =>  $record['discountcodeG'],
            'DiscountCodeP'  =>  $record['discountcodeP'],
            'MinimumSupplyCondition'  =>  $record['minimumSupplyCondition'],
            'Duration'  =>  $this->getValue($record['duration']),
            'Applicability'  =>  $record['applicability'],
            'ValueType'  =>  $this->getValue($record['valueType']),
            'Value'  =>  $this->formatPrice($record['value']),
            'Unit'  =>  $this->getValue($record['unit']),
            'ApplicableForExistingCustomers'  =>  $this->getValue($record['applicableForExistingCustomers']),
            'Greylist'  =>  $record['greylist'],
            'ProductId'  =>  $record['productId'],
            'NameNl'  =>  $record['nameNl'],
            'DescriptionNl'  =>  $record['descriptionNl'],
            'NameFr'  =>  $record['nameFr'],
            'DescriptionFr'  =>  $record['descriptionFr'],
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

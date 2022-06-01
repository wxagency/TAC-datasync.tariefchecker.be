<?php

namespace App\Console\Commands\Restore;

use Illuminate\Console\Command;
use App\Models\History\Supplier;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use App\Console\Commands\Restore\AirtableTrait;


class SupplierUpdate extends Command
{
    use AirtableTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'supplier:update';

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
        $this->info("---Supplier Restore started--");
        $this->_update();
        $this->info("---Supplier Restore ended--");
        
        // $this->_test();
    }


    private function _update()
    {
        $restoreDate = $this->getRestoreDate(); 
        if( $restoreDate == false){
            $this->info("---No restore point found--");
            exit;
        }
        $current_supplier = [];
        $new_supplier = [];
        $data = Supplier::where('backupdate', $restoreDate)->get()->toArray();
        Session::put('offset', '0');
        while (Session::get('offset') != 'stop') {

            $query['pageSize'] = 100;
            $query['offset'] = Session::get('offset');

            $json = $this->get('Suppliers', $query);
            return $json;
            exit();

            if (isset($json['offset'])) {
                Session::put('offset', $json['offset']);
            } else {

                Session::put('offset', 'stop');
            }

            // Here key is the unique value in the Supplier table and Value is the auto generated ID

            foreach ($json['records'] as $supplier) {

                $current_supplier[$supplier['fields']['Id']] = $supplier['id'];
            }
        }


        $new_supplier = $data;
        $create_record = [];
        $update_record = [];

        foreach ($new_supplier as $key => $value) {
            $_id = isset($current_supplier[$value['supplier_id']]) ? $current_supplier[$value['supplier_id']] : '';
            if (strlen($_id) > 0) {
                $record = $this->_formatRecord($value, $_id);
                array_push($update_record, $record);
                unset($current_supplier[$value['supplier_id']]);
                if (count($update_record) == 10) {
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

        $delete_records = [];
        foreach ($current_supplier as $id => $autoKey) {
            $delete_records[] = urlencode($autoKey);
            if (count($delete_records) == 10) {
                $this->_deleteRecord($delete_records);
                $delete_records = [];
            }
        }

        if (count($delete_records) > 0) {
            $this->_deleteRecord($delete_records);
            $delete_records = [];
        }
        // $this->info("completed");

    }

    /**
     * Setting the exact format of each record to restore.
     */
    function _formatRecord($record, $_id = '')
    {

        $newData = [
            'Id' => $record['supplier_id'],
            'Supplier Type'  =>  $this->get_value($record['suppliertype']),
            'Origin'  =>  $this->get_value($record['origin']),
            'Official Name'  =>  $record['official_name'],
            'Commercial Name'  =>  $record['commercial_name'],
            'Abbreviation'  =>  $record['abbreviation'],
            'Parent Company'  =>  $record['parent_company'],
            'Logo URL'  =>  $record['logo_large'],
            'Greenpeace Rating'  =>  $this->get_value($record['greenpeace_rating']),
            'Vreg Rating'  =>  $this->get_value($record['Vreg_rating']),
            'Customer Rating'  =>  $this->get_value($record['customer_rating']),
            'Is Partner'  => $this->get_value($record['is_partner']),
            'GSC VL'  =>  $record['gsc_vl'],
            'WKC VL'  =>  $record['wkc_vl'],
            'GSC WA'  =>  $record['gse_wa'],
            'GSC BR'  =>  $record['gsc_br'],
        ];
        $result = [
            'fields' =>  $newData,
        ];
        if (strlen($_id) > 0) {
            $result['id'] = $_id;
        }


        return $result;
    }

    /**
     * update the records
     */
    private function _updateRecords($records)
    {

        $requestData = [
            'records' => $records
        ];

        $this->patch('Suppliers', $requestData, [
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

        $this->post('Suppliers', $requestData, [
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

            $this->delete('Suppliers', $requestData, [
                'error' => function ($ex, $data) {
                    // die($ex->getMessage());
                }
            ]);
        }
    }
}

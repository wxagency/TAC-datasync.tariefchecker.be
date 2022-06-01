<?php

namespace App\Console\Commands\Restore;

use Illuminate\Console\Command;
use App\Models\History\StaticElectricProfessional;
use Illuminate\Support\Facades\Session;
use App\Console\Commands\Restore\AirtableTrait;

class ElekProUpdate extends Command
{
    use AirtableTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elek-pro:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $current_supplier = [];

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
        $this->info("---Electricity Professional Restore started---");
        $this->_update();
        $this->info("---Electricity Professional Restore ended---");
    }

    private function _update()
    {
        $restoreDate = $this->getRestoreDate(); 
        if( $restoreDate == false){
            $this->info("---No restore point found--");
            exit;
        }
        $current_data = [];
        $new_data = [];
        $data = StaticElectricProfessional::where('backupdate', $restoreDate)->get()->toArray();
        Session::put('offset', '0');
        while (Session::get('offset') != 'stop') {

            $query['pageSize'] = 100;
            $query['offset'] = Session::get('offset');

            $json = $this->get('Stat data - E PRO', $query);
            if (isset($json['offset'])) {
                Session::put('offset', $json['offset']);
            } else {

                Session::put('offset', 'stop');
            }

            // Here key is the unique value in the Supplier table and Value is the auto generated ID
            
            foreach ($json['records'] as $electricity) {

                $current_data[$electricity['fields']['PROD ID']] = $electricity['id'];
            }
        }


    
        $new_data = $data;
        $create_record = [];
        $update_record = [];

        foreach ($new_data as $key => $value) {
            $_id = isset($current_data[$value['product_id']]) ? $current_data[$value['product_id']] : '';
            if (strlen($_id) > 0) {
                $record = $this->_formatRecord($value, $_id);
                array_push($update_record, $record);
                unset($current_data[$value['product_id']]);
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

        $delete_records = [];
        foreach ($current_data as $id => $autoKey) {
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

        $this->info("completed");

    }


    function getSupplierKey($commmercialName, $origin){
        if(count($this->current_supplier) == 0){
            $this->current_supplier = $this->_getSuppliers();
        }
        if(isset($this->current_supplier[$commmercialName])){
            foreach($this->current_supplier[$commmercialName] as $sup) {
                if(strtolower($sup['origin']) ==  strtolower($origin)){
                    return $sup['key'];
                }
            }
            
          return $this->current_supplier[$commmercialName][0]['key'];   
        }
        return null;
        
    }
    function _formatRecord($record, $_id = '')
    {
        $supplierKey = $this->getSupplierKey( $record['supplier'], $record['origin'] );
        // dd($supplierKey , $record['supplier'], $record['origin']);
        $newData = [
            'PROD ID' => $record['product_id'],
            'Active'  =>  $this->get_value($record['acticve']),
            'Partner'  =>  $this->get_value($record['partner']),
            'Supplier'  =>  [$supplierKey],
            'Product Name NL'  =>  $record['product_name_NL'],
            'Product Name FR'  =>  $record['product_name_FR'],
            'Fuel'  =>  $record['fuel'],
            'Duration'  =>  $this->get_value($record['duration']),
            'Price Type'  =>  $this->get_value($record['fixed_indiable']),
            'Green Percentage'  =>  $this->get_value($record['green_percentage']),
            'Origin'  =>  $this->get_value($record['origin']),
            'Segment'  =>  $record['segment'],
            'VL'  =>  $this->get_value($record['VL']),
            'WA'  =>  $this->get_value($record['WA']),
            'BR'  =>  $this->get_value($record['BR']),
            'Servicelevel Payment'  =>  $this->get_value($record['service_level_payment']),
            'Servicelevel Invoicing'  =>  $this->get_value($record['service_level_invoicing']),
            'Servicelevel Contact'  =>  $this->get_value($record['service_level_contact']),
            'FF pro rata?'  =>  $this->get_value($record['FF_pro_rata']),
            'Inv period'  =>  $this->get_value($record['inv_period']),
            'Customer condition'  =>  $this->get_value($record['customer_condition']),
            'Subscribe URL NL'  =>  $record['subscribe_url_NL'],
            'Descr_Long_NL'  =>  $record['info_NL'],
            'Descr_Short_NL'  =>  $record['tariff_description_NL'],
            'Terms NL'  =>  $record['terms_NL'],
            'Subscribe URL FR'  => $record['subscribe_url_FR'],
            'Descr_Long_FR'  =>  $record['info_FR'],
            'Descr_Short_FR'  =>  $record['tariff_description_FR'],
            'Terms FR'  =>  $record['terms_FR'],
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

        $this->patch('Stat data - E PRO', $requestData, [
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

        $this->post('Stat data - E PRO', $requestData, [
            'error' => function ($ex, $data) {
                // die($ex->getMessage());
            }
        ]);
    }

    private function _getSuppliers()
    {
        $current_supplier = [];
        Session::put('s_offset', '0');
        while (Session::get('s_offset') != 'stop') {

            $query['pageSize'] = 100;
            $query['offset'] = Session::get('s_offset');

            $json = $this->get('Suppliers', $query);
            if (isset($json['offset'])) {
                Session::put('s_offset', $json['offset']);
            } else {

                Session::put('s_offset', 'stop');
            }

            // Here key is the unique value in the Supplier table and Value is the auto generated ID
            
            foreach ($json['records'] as $supplier) {
                // dd($supplier['fields']);
                $current_supplier[$supplier['fields']['Commercial Name']][] = [
                    'key' => $supplier['id'],
                    'origin' => isset($supplier['fields']['Origin']) ? $supplier['fields']['Origin'] : null
                ];
            }
           
        }
    
        return $current_supplier;
    }

    function _deleteRecord($data)
    {
        $requestData = [
            'records' => $data
        ];

        if (count($requestData['records'])) {

            $this->delete('Stat data - E PRO', $requestData, [
                'error' => function ($ex, $data) {
                    // die($ex->getMessage());
                }
            ]);
        }
    }
}

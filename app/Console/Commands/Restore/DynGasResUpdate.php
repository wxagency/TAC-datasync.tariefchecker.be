<?php

namespace App\Console\Commands\Restore;

use Illuminate\Console\Command;
use App\Models\History\DynamicGasResidential;
use Illuminate\Support\Facades\Session;
use App\Console\Commands\Restore\AirtableTrait;

class DynGasResUpdate extends Command
{
    use AirtableTrait;

    const TABLE = 'Dyn data - G RES' ;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dynamic-gasRes:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $currentProduct = [];

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
        $this->info("---Dynamic gas Residential Restore started---");
        $this->_restore();
        $this->info("---Dynamic gas Residential Restore ended---");
    }

    private function _restore()
    {
        $restoreDate = $this->getRestoreDate(); 
        if( $restoreDate == false){
            $this->info("---No restore point found--");
            exit;
        }
        $current_data = [];
        $new_data = [];
        $data = DynamicGasResidential::where('backupdate', $restoreDate)->get()->toArray();
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

            foreach ($json['records'] as $gas) {

                $current_data[] = $gas['id'];
            }
        }
        $this->_deleteTable($current_data);

        $new_data = $data;
        $create_record = [];
        $this->currentProduct = $this->_getProducts();
        foreach ($new_data as $key => $value) {

            $record = $this->_formatRecord($value, '');
            array_push($create_record, $record);
            if (count($create_record) == 10) {
                $this->_createRecords($create_record);
                $create_record = [];
            }
        }

        if (count($create_record) > 0) {
            $this->_createRecords($create_record);
            $create_record = [];
        }
        $this->info("completed");
        
    }

    private function _getProducts()
    {
        $currentProducts = [];
        Session::put('p_offset', '0');
        while (Session::get('p_offset') != 'stop') {

            $query['pageSize'] = 100;
            $query['offset'] = Session::get('p_offset');

            $json = $this->get('Stat%20data%20-%20G%20RES', $query);

            if (isset($json['offset'])) {
                Session::put('p_offset', $json['offset']);
            } else {

                Session::put('p_offset', 'stop');
            }

            // Here key is the unique value in the Supplier table and Value is the auto generated ID

            foreach ($json['records'] as $product) {
                /*"MEG-RES-SUPERFIX-1-E" => array:2 [
                    "prod_key" => "reczbrtn5Pc9XmOMt"
                    "supplier_key" => array:1 [
                      0 => "recI791ZFoAH4hsRL"
                    ]
                  ]*/
               
                $currentProducts[$product['fields']['PROD ID']] = [
                    'prod_key' => $product['id'],
                    'supplier_key' => $product['fields']['Supplier']
                ];
                
            }
           
        }

        return $currentProducts;
    }

    function _formatRecord($record, $_id = '')
    {
       
        $product = $this->currentProduct[$record['product_id']];
        $newData = [
            'Product' => $record['product'],
            'Valid from'  =>  $this->formatDate($record['valid_from']),
            'Valid till'  =>  $this->formatDate($record['valid_till']),
            'PROD ID'  =>  [ $product['prod_key']],
            'Supplier'  =>  $product['supplier_key'],
            'Fuel'  =>  $record['fuel'],
            'Duration'  =>  $this->get_value($record['duration']),
            'Price Type'  =>  $this->get_value($record['fixed_indexed']),
            'Customer Segment'  =>  $record['segment'],
            'VL'  =>  $this->get_value($record['VL']),
            'WA'  =>  $this->get_value($record['WA']),
            'BR'  =>  $this->get_value($record['BR']),
            'Volume lower'  =>  $this->get_value($record['volume_lower']),
            'Volume upper'  =>  $this->get_value($record['volume_upper']),
            'Price gas'  =>  $this->get_value($record['price_gas']),
            'FF'  =>  $this->formatPrice($record['ff']),
            'Prices URL NL'  =>  $record['prices_url_nl'],
            'Prices URL FR'  =>  $record['prices_url_fr'],
            'Index_name'  =>  $record['index_name'],
            'Index_Value'  =>  $this->formatPrice($record['index_value']),
            'coeff'  =>  $this->formatPrice($record['coeff']),
            'term'  =>  $this->formatPrice($record['term']),
            'Date'  =>  $this->formatDate($record['date']),
            // 'TP_incl'  =>  $this->formatPrice($record['coeff_day']),
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

                die($ex->getMessage());
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
                    die($ex->getMessage());
                }
            ]);
        }
    }
}


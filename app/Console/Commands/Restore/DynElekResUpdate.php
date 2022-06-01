<?php

namespace App\Console\Commands\Restore;

use Illuminate\Console\Command;
use App\Models\History\DynamicElectricResidential;
use Illuminate\Support\Facades\Session;
use App\Console\Commands\Restore\AirtableTrait;

class DynElekResUpdate extends Command
{
    use AirtableTrait;

    const TABLE = 'Dyn data - E RES';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dynamic-elekRes:update';

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
        $this->info("---Dynamic Electric Residential Restore started---");
        $this->_update();
        $this->info("---Dynamic Electric Residential Restore ended---");
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
        $data = DynamicElectricResidential::where('backupdate', $restoreDate)->get()->toArray();
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

            foreach ($json['records'] as $electricity) {

                $current_data[] = $electricity['id'];
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
            'Customer Segment'  =>  $record['customer_segment'],
            'VL'  =>  $this->get_value($record['VL']),
            'WA'  =>  $this->get_value($record['WA']),
            'BR'  =>  $this->get_value($record['BR']),
            'Volume lower'  =>  $this->get_value($record['volume_lower']),
            'Volume upper'  =>  $this->get_value($record['volume_upper']),
            'Price Single'  =>  $this->get_value($record['price_single']),
            'Price Day'  =>  $this->formatPrice($record['price_day']),
            'Price Night'  =>  $this->formatPrice($record['price_night']),
            'Price Excl Night'  =>  $this->formatPrice($record['price_excl_night']),
            'FF Single'  =>  $this->formatPrice($record['ff_single']),
            'FF day/night'  =>  $this->formatPrice($record['ff_day_night']),
            'FF excl night'  =>  $this->formatPrice($record['ff_excl_night']),
            'GSC VL'  =>  $this->formatPrice($record['gsc_vl']),
            'WKC VL'  => $this->formatPrice($record['wkc_vl']),
            'GSC WA'  =>  $this->formatPrice($record['gsc_wa']),
            'GSC BR'  =>  $this->formatPrice($record['gsc_br']),
            'Prices URL NL'  =>  $record['prices_url_nl'],
            'Prices URL FR'  =>  $record['prices_url_fr'],
            'Index_name'  =>  $record['index_name'],
            'Index_value'  =>  $this->formatPrice($record['index_value']),
            'coeff_single'  =>  $this->formatPrice($record['coeff_single']),
            'term_single'  =>  $this->formatPrice($record['term_single']),
            'coeff_day'  =>  $this->formatPrice($record['coeff_day']),
            'term_day'  =>  $this->formatPrice($record['term_day']),
            'coeff_night'  =>  $this->formatPrice($record['coeff_night']),
            'term_night'  =>  $this->formatPrice($record['term_night']),
            'coeff_excl'  =>  $this->formatPrice($record['coeff_excl']),
            'term_excl'  =>  $this->formatPrice($record['term_excl']),
            'Date'  =>  $this->formatDate($record['date']),
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

                // die($ex->getMessage());
            }
        ]);
    }

    private function _getProducts()
    {
        $currentProducts = [];
        Session::put('p_offset', '0');
        while (Session::get('p_offset') != 'stop') {

            $query['pageSize'] = 100;
            $query['offset'] = Session::get('p_offset');

            $json = $this->get('Stat%20data%20-%20E%20RES', $query);

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

<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Console\Commands\Restore\AirtableTrait;
use Illuminate\Support\Facades\Session;

class DisountController extends Controller
{
    use AirtableTrait;

    const TABLE = 'Discounts';
    const SUPPLIER = 'Suppliers';

    protected $currentSupplier = [];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $discount = $this->_getDiscount();
       return view('admin.discount.index', compact('discount'));
      
    }
    
    public function edit($id)
    {
        
        $currentSupplier = [];
        
        // Generate a new unique number  
        $id = $this->generateBarcodeNumber();

        // Get Supplier
        Session::put('offset', '0');
        while (Session::get('offset') != 'stop') {

            $query['pageSize'] = 100;
            $query['offset'] = Session::get('offset');

            $json = $this->get(self::SUPPLIER, $query);

            if (isset($json['offset'])) {
                Session::put('offset', $json['offset']);
            } else {

                Session::put('offset', 'stop');
            }
        }

        foreach ($json['records'] as $supplier) {
            $currentSupplier[] = $supplier['fields']['Commercial Name'];
        }
        sort($currentSupplier);
        
        
        

        return view('admin.discount.duplicate', compact('currentSupplier', 'id'));
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $currentSupplier = [];
        
        // Generate a new unique number  
        $id = $this->generateBarcodeNumber();

        // Get Supplier
        Session::put('offset', '0');
        while (Session::get('offset') != 'stop') {

            $query['pageSize'] = 100;
            $query['offset'] = Session::get('offset');

            $json = $this->get(self::SUPPLIER, $query);

            if (isset($json['offset'])) {
                Session::put('offset', $json['offset']);
            } else {

                Session::put('offset', 'stop');
            }
        }

        foreach ($json['records'] as $supplier) {
            $currentSupplier[] = $supplier['fields']['Commercial Name'];
        }
        sort($currentSupplier);

        return view('admin.discount.create', compact('currentSupplier', 'id'));
    }

     function generateBarcodeNumber() {
        $number = mt_rand(1000, 9999);
    
        // call the same function if the barcode exists already
        if ($this->barcodeNumberExists($number)) {
            return $this->generateBarcodeNumber();
        }
    
    $disc= Discount::orderBy('discountId', 'desc') ->first();
    $Pid=$disc->discountId;
   // $checkFlag= Discount::where('discountId', $Pid)->exists();
    $checkFlag="";
    while($checkFlag==false){
        
        $checkFlag= Discount::where('discountId', $Pid)->exists();
        $Pid=$Pid+1;
         
        
    }
    return $Pid;
   
    
        // otherwise, it's valid and can be used
       // return $number;
    }
    
    function barcodeNumberExists($number) {
        // query the database and return a boolean
        return Discount::where('discountId', $number)->exists();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'discountId' => '',
            'discountCreated' => 'required',
            'supplier' => 'required',
            'startdate' => 'required|date|before:enddate',
            'enddate' => 'required|date|after:startdate',
            'customergroup' => 'required',
            'volume_lower' => 'required',
            'volume_upper' => 'required',
            'fuelType' => 'required',
            'productId' => 'required',
        ], [
            'supplier.required' => 'Please select Supplier.',
            'customergroup.required' => 'Please select Customergroup.',
            'fuelType.required' => 'Please select Fueltype.',
            'productId.required' =>'Please select at least one productId.',
        ]);
        $discounts = [];
        $createRecord = [];
        // $discounts[] = $request->all();
        $this->currentSupplier = $this->_getSupplier();
        foreach($request['productId'] as $productId) {
            $value = $request;
            $value['productId'] = $productId;
            $record[] = $this->_formatRecord($value, '');
            }
            $this->_createRecords($record);    
        return redirect()->back()->with('message', 'Discount Created Successfully');
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
        if (isset($this->currentSupplier[$commmercialName])) {
            return $this->currentSupplier[$commmercialName]['key'];
        }
        return null;
    }
    
    private function _getDiscount()
    {
        $discount = [];
        Session::put('p_offset', '0');
        while (Session::get('p_offset') != 'stop') {

            $query['pageSize'] = 100;
            $query['offset'] = Session::get('p_offset');

            $json = $this->get('Discounts', $query);

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
                array_push($discount, $supplier);
                
            }
        }

        return $discount;
    }

    function _formatRecord($record, $_id = '')
    {
        $supplierKey = $this->getSupplierKey($record['supplier']);
        // dd($supplierKey);
    
        $newData = [
            'Id' => $this->getValue($record['discountId']),
            'Supplier'  =>  [$supplierKey],
            'CreatedAt'  =>  $this->dateStructureFormat($record['discountCreated']),
            'StartDate'  =>  $this->dateStructureFormat($record['startdate']),
            'EndDate'  =>  date('D, d M Y 23:59:59', strtotime($record['enddate'])),
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
            // 'Greylist'  =>  $record['greylist'],
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
        
      
      
      $orgStartDate = $record['startdate'];
      $newStartDate = date("Y-m-d", strtotime($orgStartDate));
      $orgEndDate = $record['enddate'];
      $newEndDate = date("Y-m-d", strtotime($orgEndDate));
        // data store in databse
        Discount::create([
            'discountId' => $this->getValue($record['discountId']),
            'supplier'  =>  $supplierKey,
            'discountCreated'  =>  date('Y-m-d'),
            'startdate'  =>  $newStartDate,
            'enddate'  =>  $newEndDate,
            'customergroup'  =>  $this->getValue($record['customergroup']),
            'volume_lower'  =>  $this->getValue($record['volume_lower']),
            'volume_upper'  =>  $this->getValue($record['volume_upper']),
            'discountType'  =>  $this->getValue($record['discountType']),
            'fuelType'  =>  $this->getValue($record['fuelType']),
            'comparisonType'  =>  $record['comparisonType'],
            'channel'  =>  $this->getValue($record['channel']),
            'applicationVContractDuration'  =>  $this->getValue($record['applicationVContractDuration']),
            'serviceLevelPayment'  =>  $this->getValue($record['serviceLevelPayment']),
            'serviceLevelInvoicing'  =>  $this->getValue($record['serviceLevelInvoicing']),
            'serviceLevelContact'  =>  $this->getValue($record['serviceLevelContact']),
            'discountcodeE'  =>  $record['discountcodeE'],
            'discountcodeG'  =>  $record['discountcodeG'],
            'discountcodeP'  =>  $record['discountcodeP'],
            'minimumSupplyCondition'  =>  $record['minimumSupplyCondition'],
            'duration'  =>  $this->getValue($record['duration']),
            'applicability'  =>  $record['applicability'],
            'valueType'  =>  $this->getValue($record['valueType']),
            'value'  =>  $this->formatPrice($record['value']),
            'unit'  =>  $this->getValue($record['unit']),
            'applicableForExistingCustomers'  =>  $this->getValue($record['applicableForExistingCustomers']),
            // 'Greylist'  =>  $record['greylist'],
            'productId'  =>  $record['productId'],
            'nameNl'  =>  $record['nameNl'],
            'descriptionNl'  =>  $record['descriptionNl'],
            'nameFr'  =>  $record['nameFr'],
            'descriptionFr'  =>  $record['descriptionFr'],
            
            
            ]);
        
        
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getProductId(Request $request)
    {
        $supplier = $request->supplier;
        $this->currentSupplier = $this->_getSupplier();
        $supplierKey = $this->getSupplierKey($supplier);
        // dd($supplierKey);
        $productData = [];
        if ($request->fuel == 'electricity' && $request->customergroup == 'residential' || $request->fuel == 'all' && $request->customergroup == 'residential') {
            Session::put('offset', '0');
            while (Session::get('offset') != 'stop') {

                $query['pageSize'] = 100;
                $query['offset'] = Session::get('offset');

                $json = $this->get('ELEK RES', $query);

                if (isset($json['offset'])) {
                    Session::put('offset', $json['offset']);
                } else {

                    Session::put('offset', 'stop');
                }

                // collect to collection
                $collection = collect($json['records']);
                // filter data using where condition
                $filtered = $collection->where('fields.active','Y')
                            ->where('fields.Supplier.0', $supplierKey);

                $productData =  array_merge($productData ,$filtered->all());
            }

            // dd($productData);
            
                

        }

        if ($request->fuel == 'electricity' && $request->customergroup == 'professional' || $request->fuel == 'all' && $request->customergroup == 'professional') {
            Session::put('offset', '0');
            while (Session::get('offset') != 'stop') {

                $query['pageSize'] = 100;
                $query['offset'] = Session::get('offset');

                $json = $this->get('ELEK PRO', $query);

                if (isset($json['offset'])) {
                    Session::put('offset', $json['offset']);
                } else {

                    Session::put('offset', 'stop');
                }

                $collection = collect($json['records']);
                // filter data using where condition
                $filtered = $collection->where('fields.Active','Y')
                            ->where('fields.Supplier.0', $supplierKey);

                $productData =  array_merge($productData ,$filtered->all());

            }
            //return response()->json($productData);
        }

        if ($request->fuel == 'gas' && $request->customergroup == 'professional' || $request->fuel == 'all' && $request->customergroup == 'professional') {
            Session::put('offset', '0');
            while (Session::get('offset') != 'stop') {

                $query['pageSize'] = 100;
                $query['offset'] = Session::get('offset');

                $json = $this->get('GAS PRO', $query);

                if (isset($json['offset'])) {
                    Session::put('offset', $json['offset']);
                } else {

                    Session::put('offset', 'stop');
                }

                $collection = collect($json['records']);
                // filter data using where condition
                $filtered = $collection->where('fields.Active','Y')
                            ->where('fields.Supplier.0', $supplierKey);

                $productData =  array_merge($productData ,$filtered->all());

            }
            //return response()->json($productData);
        }

        if ($request->fuel == 'gas' && $request->customergroup == 'residential' || $request->fuel == 'all' && $request->customergroup == 'residential') {
            Session::put('offset', '0');
            while (Session::get('offset') != 'stop') {

                $query['pageSize'] = 100;
                $query['offset'] = Session::get('offset');

                $json = $this->get('GAS RES', $query);

                if (isset($json['offset'])) {
                    Session::put('offset', $json['offset']);
                } else {

                    Session::put('offset', 'stop');
                }

                $collection = collect($json['records']);
                // filter data using where condition
                $filtered = $collection->where('fields.active','Y')
                            ->where('fields.Supplier.0', $supplierKey);
                // merge all the data to $productIds
                $productData =  array_merge($productData ,$filtered->all());

            }
           // return response()->json($productData);
        } 

        $productIds = collect( $productData)->pluck('fields.PROD ID');
        $productIds = $productIds->toArray();
        sort($productIds);
        return response()->json( $productIds);

    }
    
    
    public function test(){
        
        Session::put('offset','0'); 
        try {
                $client = new \GuzzleHttp\Client();
                $query['pageSize'] =100;  
                $query['offset'] =Session::get('offset');
                $request = $client->get('https://api.airtable.com/v0/app6bZwM5E2SSnySJ/Discounts', [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-type' => 'application/json',
                        'Authorization' => 'Bearer keySZo45QUBRPLwjL'
                    ],
                    'query' => $query
                ]);
            } catch (Exception $ex) {
                return $ex->getCode();
            }
            
            $response = $request->getBody()->getContents();       
            $json = json_decode($response, true);
            dd($json['records']);
             foreach ($json['records'] as $discounts) {
                 
                   if( !empty($discounts['fields']['Id']) && !empty($discounts['fields']['Supplier']) && isset($discounts['fields']['ProductId'])){
                     
                     $ProductId = $discounts['fields']['ProductId'];
                      foreach($ProductId as $ProductIds){
                          
                          $request = $client->get('https://api.airtable.com/v0/app6bZwM5E2SSnySJ/Product-Id/'.$ProductIds, [
                            'headers' => [
                                'Accept' => 'application/json',
                                'Content-type' => 'application/json',
                                'Authorization' => 'Bearer keySZo45QUBRPLwjL'
                            ]
                            
                        ]);
                    
                        $response = $request->getBody()->getContents();       
                        $json = json_decode($response, true);
                        
                        $product_id = $json['fields']['Product'];
                          
                          
                        /*insert- discounts*/
                        
                        
                        
                        
                        
                        
                        /*end*/
                          
                          
                      }
                      
                 }
                 
             }
    }
}

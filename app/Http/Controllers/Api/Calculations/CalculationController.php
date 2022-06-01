<?php

namespace App\Http\Controllers\Api\Calculations;

use App\Models\Api\Calculation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\StaticElecticResidential;
use App\Models\StaticGasResidential;
use App\Models\StaticElectricProfessional;
use App\Models\StaticGasProfessional;
use App\Models\PostalcodeElectricity;
use App\Models\PostalcodeGas;
use App\Models\StaticPackResidential;
use App\Models\StaticPackProfessional;
use App\Models\Netcostes;
use App\Models\Netcostgs;

use App\Models\DynamicElectricProfessional;
use App\Models\DynamicGasProfessional;
use App\Models\DynamicElectricResidential;
use App\Models\DynamicGasResidential;
use DB;

class CalculationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function generateUUID($length = 36) {
        $characters = '0123456789-abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function index()
    {
        $locale='nl';
        $postalCode=2000;
        $customerGroup='professional';
        $dgoE='IMEA';
        $registerNormal="1000";
        $registerDay="0";
        $registerNight="0";
        $registerExclNight="0";
        $sumRegisters=$registerNormal+$registerDay+$registerNight+$registerExclNight;
        $capacityDecentrelisedProduction="0";
        $dgoG="IMEA";
        $registerG="1000";
        $region="VL";
        $uuid=$this->generateUUID();
      
        
       /**
        * Electricity
        */
      

        if($sumRegisters!=0){
        $res['postalE']=PostalcodeElectricity::select('netadmin_zip','DNB','region')->where('netadmin_zip','2000')->first();
        $dnbE=$res['postalE']->DNB;
        if($customerGroup=='professional'){

            $customer='PRO';
            $currentDate=date("Y/m/d");
            $result['electricity']['Netcostes']=Netcostes::where('dnb',$dnbE)->where('segment',$customer)->get();
            $result['products']['electricity'] = DynamicElectricProfessional::whereDate('valid_from','<=',$currentDate)
            ->whereDate('valid_till','>=',$currentDate)
            ->join('static_elec_professionals','static_elec_professionals.product_id','=','dynamic_electric_professionals.product_id')
            ->get();          
           
          



        }else{

            $customer='HH';
            $currentDate=date("Y/m/d");
            $result['electricity']['Netcostes']=Netcostes::where('dnb',$dnbE)->where('segment',$customer)->get();
            $result['products']['electricity']=DynamicElectricResidential::whereDate('valid_from','<=',$currentDate)->whereDate('valid_till','>=',$currentDate)->get();
            $result['products']=StaticElecticResidential::whereDate('valid_from','<=',$currentDate)->whereDate('valid_till','>=',$currentDate)->get();

        }
       
    }
       /**
        * Electricity-end
        */
       
        
        
        

        //**json output -start */


       // dd($result['products']['electricity']);
      
        $pro = [];
        $products = [];
        // parameter-start
        foreach($result['products']['electricity'] as $getProducts){
            
       
        
        $products['parameters'] = [
            'uuid' => $this->generateUUID()        
        ];
                        $products['parameters']['values']=[
                            'customer_group' => $customerGroup,
                            'location_id' => 'value',
                            'region_id' => 'label',
                            'dgo_id_electricity' => 'value',
                            'dgo_id_gas' => 'label',
                            'residents' => 'value',
                            'current_payment_amount' => 'label',
                            'current_supplier_name_gas' => 'value',
                            'current_supplier_name_electricity' => 'label',
                            'current_supplier_id_gas' => 'value',
                            'current_supplier_id_electricity' => 'label',
                            'usage_single' => 'value',
                            'usage_day' => 'label',
                            'usage_night' => 'value',
                            'usage_excl_night' => 'label',
                            'usage_gas' => 'value',
                            'current_payment_amount_gas' => 'value',
                            'email' => 'value',
                            'postal_code' => 'value',
                            'comparison_type' => 'value',
                            'meter_type' => 'value',
                            'locale' => 'value'
                        ];
        // parameter-end

        // product-start        
        $products['product'] = [
            '_id' => $getProducts->id,
            'id' => $getProducts->product_id,
            'name' => $getProducts->product_name_NL,
            'description' => $getProducts->info_NL,
            'tariff_description' => $getProducts->tariff_description_NL,
            'type' => 'value',
            'contract_duration' => $getProducts->duration,
            'service_level_payment' => $getProducts->service_level_payment,
            'service_level_invoicing' => $getProducts->service_level_invoicing,
            'service_level_contact' => $getProducts->service_level_contact,
            'customer_condition' => $getProducts->customer_condition,
            'origin' => $getProducts->origin,
            'pricing_type' => $getProducts->fixed_indiable,
            'green_percentage' => $getProducts->green_percentage,
            'subscribe_url' => $getProducts->subscribe_url_NL,
            'terms_url' => $getProducts->terms_NL,
            'ff_pro_rata' => $getProducts->FF_pro_rata,
            'inv_period' => $getProducts->inv_period,
            'popularity_score' => 'value'
        ];

                       
                        $products['product']['underlying_products']['electricity'] = [
                                    '_id' => 'label',
                                    'id' => 'value',
                                    'name' => 'label',
                                    'description' => 'value',
                                    'tariff_description' => 'label',
                                    'type' => 'value',
                                    'contract_duration' => 'label',
                                    'service_level_payment' => 'value',
                                    'service_level_invoicing' => 'label',
                                    'service_level_contact' => 'value',
                                    'customer_condition' => 'label',
                                    'origin' => 'value',
                                    'pricing_type' => 'label',
                                    'green_percentage' => 'value',
                                    'subscribe_url' => 'label',
                                    'terms_url' => 'value',
                                    'ff_pro_rata' => 'label',
                                    'inv_period' => 'value',
                                    'popularity_score' => 'label'
                                ];
                        

                       
                        $products['product']['underlying_products']['gas'] = [
                                    '_id' => 'label',
                                    'id' => 'value',
                                    'name' => 'label',
                                    'description' => 'value',
                                    'tariff_description' => 'label',
                                    'type' => 'value',
                                    'contract_duration' => 'label',
                                    'service_level_payment' => 'value',
                                    'service_level_invoicing' => 'label',
                                    'service_level_contact' => 'value',
                                    'customer_condition' => 'label',
                                    'origin' => 'value',
                                    'pricing_type' => 'label',
                                    'green_percentage' => 'value',
                                    'subscribe_url' => 'label',
                                    'terms_url' => 'value',
                                    'ff_pro_rata' => 'label',
                                    'inv_period' => 'value',
                                    'popularity_score' => 'label'
                                ];
                            

        // product-end

        // supplier-start

        $products['supplier'] = [
            'id' => 'label',
            'name' => 'value',
            'logo' => 'label',
            'url' => 'value',
            'origin' => 'label',
            'customer_rating' => 'value',
            'greenpeace_rating' => 'label',
            'type' => 'value'
        ];

        // supplier-end

        // price-start
        $products['price']['validity_period'] = [
            'start' => 'label',
            'end' => 'value'
        ];
        $products['price']['totals']['month'] = [
            'incl_promo' => 'label',
            'excl_promo' => 'value'
            ];
            $products['price']['totals']['year'] = [
            'incl_promo' => 'label',
            'excl_promo' => 'value'
            ];
            
            // price-end

            // braekdown
        $products['price']['breakdown']['electricity']['energy_cost'] = [
            'fixed_fee' => 'label',
            'certificates' => 'value',
            'single' => 'label',
            'day' => 'value',
            'night' => 'label',
            'excl_night' => 'value'
        ];
                    $products['price']['breakdown']['electricity']['distribution_and_transport'] = [
                        'distribution' => 'label',
                        'transport' => 'value'
                        
                    ];
                    $products['price']['breakdown']['electricity']['taxes'] = [
                        'tax' => 'label'                       
                    ];
                    $products['price']['breakdown']['electricity']['unit_cost'] = [
                        'energy_cost' => 'label',
                        'total' => 'value'
                       
                    ];

        $products['price']['breakdown']['gas']['energy_cost'] = [
            'fixed_fee' => 'label',
            'usage' => 'value'
        ];
                    $products['price']['breakdown']['gas']['distribution_and_transport'] = [
                         'distribution' => 'label',
                         'transport' => 'value'
                    ];
                    $products['price']['breakdown']['gas']['taxes'] = [
                        'tax' => 'label'                        
                    ];
                    $products['price']['breakdown']['gas']['unit_cost'] = [
                        'energy_cost' => 'label',
                        'total' => 'value'
                    ];

        $products['price']['breakdown']['discounts'] = [
                'id' => 'label',
                'name' => 'value',
                'description' => 'value',
                'type' => 'value',
                'included_in_calculation' => 'value'
        ];

            // breakdown-end


        $products['value_added_services'] = [];
        array_push($pro,$products);
    }
    
        dd($pro);


        //**json output -end */
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Api\Calculation  $calculation
     * @return \Illuminate\Http\Response
     */
    public function show(Calculation $calculation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Api\Calculation  $calculation
     * @return \Illuminate\Http\Response
     */
    public function edit(Calculation $calculation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Api\Calculation  $calculation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Calculation $calculation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Api\Calculation  $calculation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Calculation $calculation)
    {
        //
    }
}

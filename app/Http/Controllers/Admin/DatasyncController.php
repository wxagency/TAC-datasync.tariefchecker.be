<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\History\StaticPackProfessional;
use App\Models\History\StaticElecticResidential;
use App\Models\History\StaticGasProfessional;
use App\Models\History\PostalcodeGas;
use App\Models\History\StaticPackResidential;
use App\Models\History\TaxGas;
use App\Models\History\DynamicGasResidential;
use App\Models\History\DynamicGasProfessional;
use App\Models\History\Netcostes;
use App\Models\History\Netcostgs;
use App\Models\History\Discount;
use App\Models\History\Supplier;

use App\Models\StaticPackProfessional as SPP;
use App\Models\StaticElecticResidential as SER;
use App\Models\StaticGasProfessional as SGP;
use App\Models\PostalcodeGas as PG;
use App\Models\StaticPackResidential as SPR;
use App\Models\TaxGas as TG;
use App\Models\DynamicGasResidential as DGR;
use App\Models\DynamicGasProfessional as DGP;
use App\Models\Netcostes as NE;
use App\Models\Netcostgs as NG;
use App\Models\Discount as DIS;
use App\Models\Supplier as SUP;
use App\Models\Dgo;
use App\Models\EstimateConsumption;
use Artisan;
use Session;

class DatasyncController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $staticlast = StaticPackProfessional::select('backupdate')->latest()->first();
        $staticRes = StaticElecticResidential::select('backup_date')->latest()->first();
        $staticPro = StaticGasProfessional::select('backupdate')->latest()->first();
        $packs = StaticPackResidential::select('backupdate')->latest()->first();
        $postalcodes = PostalcodeGas::select('backupdate')->latest()->first();
        $dynamiclast = TaxGas::select('updated_at')->latest()->first();
        $dynamicRes = DynamicGasResidential::select('updated_at')->latest()->first();
        $dynamicPro = DynamicGasProfessional::select('updated_at')->latest()->first();
        $tax = TaxGas::select('updated_at')->latest()->first();
        $netcoste = Netcostes::select('backupdate')->latest()->first();
        $netcostg = Netcostgs::select('backupdate')->latest()->first();
        $discounts = Discount::select('backupdate')->latest()->first();
        $supplier = Supplier::select('backupdate')->latest()->first();
        
        $staticlastSyn = SPP::select('updated_at')->latest()->first();
        $staticResSyn = SER::select('updated_at')->latest()->first();
        $staticProSyn = SGP::select('updated_at')->latest()->first();
        $packsSyn = SPR::select('updated_at')->latest()->first();
        $postalSyn = PG::select('updated_at')->latest()->first();
        $dynlastSyn = TG::select('updated_at')->latest()->first();
        $dynResSyn = DGR::select('updated_at')->latest()->first();
        $dynProSyn = DGP::select('updated_at')->latest()->first();
        $taxSyn = TG::select('updated_at')->latest()->first();
        $netcosteSyn = NE::select('updated_at')->latest()->first();
        $netcostgSyn = NG::select('updated_at')->latest()->first();
        $discSync = DIS::select('updated_at')->latest()->first();
        $supplySync = SUP::select('updated_at')->latest()->first();
        $EstimateConsumption= EstimateConsumption::select('updated_at')->latest()->first();
        
        $dgo = Dgo::select('updated_at')->latest()->first();
        return view('admin.datasync.manualsync', compact('staticlast', 'staticRes', 'staticPro', 'packs',
            'postalcodes','dynamiclast','dynamicRes','dynamicPro','tax','netcoste','netcostg','discounts',
            'supplier', 'dgo', 'staticlastSyn', 'staticResSyn', 'staticProSyn', 'packsSyn', 'postalSyn', 
            'dynlastSyn', 'dynResSyn', 'dynProSyn', 'taxSyn', 'netcosteSyn', 'netcostgSyn', 'discSync', 'supplySync','EstimateConsumption'
        ));
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
    public function edit($id)
    {
        //
    }

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

    public function syncResidentialData()
    {
        Artisan::call('SResidential:backup');
        Artisan::call('staticdata-residential:import');
        $backupdate = Session::get('backup'); 
        echo date("D,d M Y H:i:s",strtotime($backupdate));
        // return $backupdate;
    }
    public function syncStaticData()
    {
        Artisan::call('staticdata:backup');
        Artisan::call('staticdata:update');
        $backupdate = Session::get('backup'); 
        echo date("D,d M Y H:i:s",strtotime($backupdate));
    }
    public function syncProfessionalData()
    {
        Artisan::call('SProfessional:backup');
        Artisan::call('staticdata-professional:import');
        $backupdate = Session::get('backup'); 
        echo date("D,d M Y H:i:s",strtotime($backupdate));
    }
    public function syncPacks()
    {
        Artisan::call('SPack:backup');
        Artisan::call('packs:import');
        $backupdate = Session::get('backup'); 
        echo date("D,d M Y H:i:s",strtotime($backupdate));
    }
    public function syncPostalcode()
    {
        Artisan::call('Postalcode:backup');
        Artisan::call('postalcode:import');
        $backupdate = Session::get('backup'); 
        echo date("D,d M Y H:i:s",strtotime($backupdate));
    }
    public function syncDynamicData()
    {
        Artisan::call('DynamicData:backup');
        Artisan::call('dynamicdata:update');
        $backupdate = Session::get('backup'); 
        echo date("D,d M Y H:i:s",strtotime($backupdate));
    }
    public function syncNetcostE()
    {
        Artisan::call('ENetcost:backup');
        Artisan::call('netcoste:update');
        $backupdate = Session::get('backup'); 
        echo date("D,d M Y H:i:s",strtotime($backupdate));
    }
    public function syncDynamicResident()
    {
        Artisan::call('DynamicResidential:backup');
        Artisan::call('residentialdata:import');
        $backupdate = Session::get('backup'); 
        echo date("D,d M Y H:i:s",strtotime($backupdate));
    }
    public function syncDynamicProfession()
    {
        Artisan::call('DynamicProfessional:backup');
        Artisan::call('professionaldata:import');
        $backupdate = Session::get('backup'); 
        echo date("D,d M Y H:i:s",strtotime($backupdate));
    }
    public function syncTax()
    {
        Artisan::call('Tax:backup');
        Artisan::call('tax:import');
        $backupdate = Session::get('backup'); 
        echo date("D,d M Y H:i:s",strtotime($backupdate));
    }
    public function syncNetcostG()
    {
        Artisan::call('GNetcost:backup');
        Artisan::call('netcostg:update');
        $backupdate = Session::get('backup'); 
        echo date("D,d M Y H:i:s",strtotime($backupdate));
    }
    public function syncDiscounts()
    {
        Artisan::call('DiscountHistory:backup');
        Artisan::call('discounts:generate');
        $backupdate = Session::get('backup'); 
        echo date("D,d M Y H:i:s",strtotime($backupdate));
    }
    public function syncSupplier()
    {
        Artisan::call('supplier:backup');
        Artisan::call('supplierdata:store');
        $backupdate = Session::get('backup'); 
        echo date("D,d M Y H:i:s",strtotime($backupdate));
    }

    public function syncDgo()
    {
        Artisan::call('dgo:sync');
        $update = Session::get('update'); 
        echo date("D,d M Y H:i:s",strtotime($update));
    }
    public function syncAll()
    {
        $this->syncDgo();
        $this->syncSupplier();
        $this->syncPostalcode();
        $this->syncStaticData();
        $this->syncDynamicData();
        $this->syncNetcostE();
        $this->syncNetcostG();
        $this->syncDiscounts();
        $backupdate = Session::get('backup'); 
        echo date("D,d M Y H:i:s",strtotime($backupdate));
    }
    public function syncExceptPostal()
    {
        $this->syncDgo();
        $this->syncSupplier();
        $this->syncStaticData();
        $this->syncDynamicData();
        $this->syncNetcostE();
        $this->syncNetcostG();
        $this->syncDiscounts();
        $backupdate = Session::get('backup'); 
        echo date("D,d M Y H:i:s",strtotime($backupdate));
    } 
    public function estimate_consumption()
    {
        Artisan::call('estimate:generate');
        $backupdate = Session::get('backup'); 
        echo date("D,d M Y H:i:s",strtotime($backupdate));
    }
}   

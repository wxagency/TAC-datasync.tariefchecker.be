<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\History\Discount;
use App\Models\History\DynamicElectricProfessional;
use App\Models\History\DynamicElectricResidential;
use App\Models\History\DynamicGasProfessional;
use App\Models\History\DynamicGasResidential;
use App\Models\History\Netcostes;
use App\Models\History\Netcostgs;
use App\Models\History\PostalcodeElectricity;
use App\Models\History\PostalcodeGas;
use App\Models\History\StaticElecticResidential;
use App\Models\History\StaticElectricProfessional;
use App\Models\History\StaticGasProfessional;
use App\Models\History\StaticGasResidential;
use App\Models\History\StaticPackProfessional;
use App\Models\History\StaticPackResidential;
use App\Models\History\Supplier;
use App\Models\History\TaxElectricity;
use App\Models\History\TaxGas;

use App\Exports\supplierExport;
use App\Exports\NetcostEExport;
use App\Exports\NetcostGExport;
use App\Exports\TaxEExport;
use App\Exports\TaxGExport;
use App\Exports\DiscountExport;
use App\Exports\PackResidentExport;
use App\Exports\PackProfessionExport;
use App\Exports\SGasResidentExport;
use App\Exports\SGasProfessionalExport;
use App\Exports\SElectricProfessionalExport;
use App\Exports\SElectricResidentialExport;
use App\Exports\DynGasResidentExport;
use App\Exports\DynGasProfessionExport;
use App\Exports\DynElectricResExport;
use App\Exports\DynElectricProExport;
use App\Exports\PostCodeElectricityExport;
use App\Exports\PostCodeGasExport;
use Maatwebsite\Excel\Facades\Excel;

use DB;
use Artisan;
use Session;

class DataRestoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $discount = Discount::select('backupdate')
                ->groupBy('backupdate')
                ->get();
        $dynEPro = DynamicElectricProfessional::select('backupdate')
                ->groupBy('backupdate')
                ->get();
        $dynERes = DynamicElectricResidential::select('backupdate')
                ->groupBy('backupdate')
                ->get();
        $dynGPro = DynamicGasProfessional::select('backupdate')
                ->groupBy('backupdate')
                ->get();
        $dynGRes = DynamicGasResidential::select('backupdate')
                ->groupBy('backupdate')
                ->get();
        $netcostE = Netcostes::select('backupdate')
                ->groupBy('backupdate')
                ->get();
        $netcostG = Netcostgs::select('backupdate')
                ->groupBy('backupdate')
                ->get();
        $postalcodeE = PostalcodeElectricity::select('backupdate')
                ->groupBy('backupdate')
                ->get();
        $postalcodeG = PostalcodeGas::select('backupdate')
                ->groupBy('backupdate')
                ->get();
        $staticERes = StaticElecticResidential::select('backup_date')
                ->groupBy('backup_date')
                ->get();
        $staticEPro = StaticElectricProfessional::select('backupdate')
                ->groupBy('backupdate')
                ->get();
        $staticGPro = StaticGasProfessional::select('backupdate')
                ->groupBy('backupdate')
                ->get();
        $staticGRes = StaticGasResidential::select('backupdate')
                ->groupBy('backupdate')
                ->get();
        $staticPPro = StaticPackProfessional::select('backupdate')
                ->groupBy('backupdate')
                ->get();
        $staticPRes = StaticPackResidential::select('backupdate')
                ->groupBy('backupdate')
                ->get();
        $supplier = Supplier::select('backupdate')
                ->groupBy('backupdate')
                ->get();
        $taxE = TaxElectricity::select('backupdate')
                ->groupBy('backupdate')
                ->get();
        $taxG = TaxGas::select('backupdate')
                ->groupBy('backupdate')
                ->get();
        
        return view ('admin.datarestore.index', compact('discount', 'dynEPro', 'dynERes', 
        'dynGPro', 'dynGRes', 'netcostE', 'netcostG', 'postalcodeE', 'postalcodeG', 'staticERes',
        'staticEPro','staticGPro','staticGRes','staticPPro','staticPRes','supplier','taxE','taxG'));
        // $tables = DB::select('SHOW TABLES');
        // dd($tables);
        // foreach($tables as $table)
        // {
        //      echo $table->Tables_in_db_name;
        // }
    }


    public function get_backup_date(Request $request){



        switch ($request->table_id) {
        case '1':
            $data=DynamicElectricProfessional::select('backupdate', DB::raw('count(*) as total'))->groupBy('backupdate')->get();
            return $data;
           
            break;
        case '2':

            $data=DynamicElectricResidential::select('backupdate', DB::raw('count(*) as total'))->groupBy('backupdate')->get();
            return $data;            
            break;
        case '3':

            $data=DynamicGasProfessional::select('backupdate', DB::raw('count(*) as total'))->groupBy('backupdate')->get();
            return $data;
            break;
        case '4':

            $data=DynamicGasResidential::select('backupdate', DB::raw('count(*) as total'))->groupBy('backupdate')->get();
            return $data;
            break;
        case '5':

            $data=StaticElecticResidential::select('backup_date as backupdate', DB::raw('count(*) as total'))->groupBy('backup_date')->get();
            return $data;
            break;
        case '6':

            $data=StaticElectricProfessional::select('backupdate', DB::raw('count(*) as total'))->groupBy('backupdate')->get();
            return $data;
            break;
        case '7':

            $data=StaticGasProfessional::select('backupdate', DB::raw('count(*) as total'))->groupBy('backupdate')->get();
            return $data;
            break;
        case '8':

            $data=StaticGasResidential::select('backupdate', DB::raw('count(*) as total'))->groupBy('backupdate')->get();
            return $data;
            break;
        case '9':

            $data=StaticPackProfessional::select('backupdate', DB::raw('count(*) as total'))->groupBy('backupdate')->get();
            return $data;
            break;
        case '10':

            $data=StaticPackResidential::select('backupdate', DB::raw('count(*) as total'))->groupBy('backupdate')->get();
            return $data;
            break;
        case '11':

            $data=Netcostes::select('backupdate', DB::raw('count(*) as total'))->groupBy('backupdate')->get();
            return $data;
            break;
        case '12':

            $data=Netcostgs::select('backupdate', DB::raw('count(*) as total'))->groupBy('backupdate')->get();
            return $data;
            break;
        case '13':

            $data=TaxElectricity::select('backupdate', DB::raw('count(*) as total'))->groupBy('backupdate')->get();
            return $data;
            break;
        case '14':

            $data=TaxGas::select('backupdate', DB::raw('count(*) as total'))->groupBy('backupdate')->get();
            return $data;
            break;
        case '15':
            
            $data=Supplier::select('backupdate', DB::raw('count(*) as total'))->groupBy('backupdate')->get();
            return $data;
            break;
        case '16':

            $data=Discount::select('backupdate', DB::raw('count(*) as total'))->groupBy('backupdate')->get();
            return $data;
            break;
        case '17':

            $data=PostalcodeElectricity::select('backupdate', DB::raw('count(*) as total'))->groupBy('backupdate')->get();
            return $data;
            break;
        case '18':

            $data=PostalcodeGas::select('backupdate', DB::raw('count(*) as total'))->groupBy('backupdate')->get();
            return $data;
            break;
        
    }
       
    }


    public function sync_backup(Request $request)
    {
         $table_name=$request->table;
         $backupdate=$request->backupdate;
      
         switch (true) {
         case ($table_name==1):

        //   $result=Artisan::call('dynamicElectricpro:start', ['table_name' => $table_name, 'backupdate' => $backupdate]);       
        Session::put('backupdate', $backupdate );
        return Excel::download(new DynElectricProExport, 'dyn-electricprofession.xlsx');
           
            break;
        case ($table_name==2):

        // $result=Artisan::call('dynamicElectricres:start', ['table_name' => $table_name, 'backupdate' => $backupdate]);  
            Session::put('backupdate', $backupdate );
            return Excel::download(new DynElectricResExport, 'dyn-electricresident.xlsx'); 
            break;
        case ($table_name==3):
            // $result=Artisan::call('dynamicGaspro:start', ['table_name' => $table_name, 'backupdate' => $backupdate]);
            Session::put('backupdate', $backupdate );
            return Excel::download(new DynGasProfessionExport, 'dyn-gasprofession.xlsx'); 
            
           
            break;
        case ($table_name==4):

        // $result=Artisan::call('dynamicGasres:start', ['table_name' => $table_name, 'backupdate' => $backupdate]);
          Session::put('backupdate', $backupdate );
          return Excel::download(new DynGasResidentExport, 'dyn-gasresidential.xlsx'); 
           
            break;
        case ($table_name==5):

        //  $result=Artisan::call('staticElectricres:start', ['table_name' => $table_name, 'backupdate' => $backupdate]);
            Session::put('backupdate', $backupdate );
            return Excel::download(new SElectricResidentialExport, 'static-electricresidential.xlsx');
            break;
        case ($table_name==6):

        // $result=Artisan::call('staticElectricpro:start', ['table_name' => $table_name, 'backupdate' => $backupdate]);
            Session::put('backupdate', $backupdate );
            return Excel::download(new SElectricProfessionalExport, 'static-electricprofessional.xlsx');
           
            break;
        case ($table_name==7):

        // $result=Artisan::call('staticGaspro:start', ['table_name' => $table_name, 'backupdate' => $backupdate]);
            Session::put('backupdate', $backupdate);
            return Excel::download(new SGasProfessionalExport, 'static-gasprofessional.xlsx');
            break;
        case ($table_name==8):
                // Artisan::call('staticGasres:start', ['table_name' => $table_name, 'backupdate' => $backupdate]);
                Session::put('backupdate', $backupdate);
                return Excel::download(new SGasResidentExport, 'static-gasresidential.xlsx');
            break;
        case ($table_name==9):
                // Artisan::call('staticpackpro:start', ['table_name' => $table_name, 'backupdate' => $backupdate]);
                Session::put('backupdate', $backupdate );
                return Excel::download(new PackProfessionExport, 'packprofessional.xlsx');
            break;
        case ($table_name==10):
                // Artisan::call('pack-residential:restore', ['table_name' => $table_name, 'backupdate' => $backupdate]);
                Session::put('backupdate', $backupdate );
                return Excel::download(new PackResidentExport, 'packresidential.xlsx');
            break;
        case ($table_name==11):
                // Artisan::call('netcost-E:restore', ['table_name' => $table_name, 'backupdate' => $backupdate]);
                Session::put('backupdate', $backupdate );
                return Excel::download(new NetcostEExport, 'netcostE.xlsx');
            break;
        case ($table_name==12):
                // Artisan::call('netcost-G:restore', ['table_name' => $table_name, 'backupdate' => $backupdate]);
                Session::put('backupdate', $backupdate );
                return Excel::download(new NetcostGExport, 'netcostG.xlsx');
            break;
        case ($table_name==13):
                // Artisan::call('tax-E:restore', ['table_name' => $table_name, 'backupdate' => $backupdate]);
                Session::put('backupdate', $backupdate );
                return Excel::download(new TaxEExport, 'taxE.xlsx');
            break;
        case ($table_name==14):
                // Artisan::call('tax-gas:restore', ['table_name' => $table_name, 'backupdate' => $backupdate]);
                Session::put('backupdate', $backupdate );
                return Excel::download(new TaxGExport, 'taxG.xlsx');
            break;
        case ($table_name==15):
                Session::put('backupdate', $backupdate );   
                return Excel::download(new supplierExport, 'supplier.xlsx');
           
            break;
        case ($table_name==16):
                // Artisan::call('discount:restore', ['table_name' => $table_name, 'backupdate' => $backupdate]);
                Session::put('backupdate', $backupdate );
                return Excel::download(new DiscountExport, 'discount.xlsx');
            break;
        case ($table_name==17):
            
                Session::put('backupdate', $backupdate );
                return Excel::download(new PostCodeElectricityExport, 'postcodeElectricity.xlsx');
            break;
        case ($table_name==18):
                Session::put('backupdate', $backupdate );
                return Excel::download(new PostCodeGasExport, 'postcodeGas.xlsx');
           
            break;


    }

}

    
}

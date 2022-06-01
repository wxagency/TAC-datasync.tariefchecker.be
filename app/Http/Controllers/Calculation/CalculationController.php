<?php

namespace App\Http\Controllers\Calculation;

use App\Models\Calculation\Calculation;
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


class CalculationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
       $sumRegisters="1000";
       $capacityDecentrelisedProduction="0";
       $dgoG="IMEA";
       $registerG="1000";
       $region="VL";

       $res=PostalcodeElectricity::all();

       dd($res);






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
     * @param  \App\Models\Calculation\Calculation  $calculation
     * @return \Illuminate\Http\Response
     */
    public function show(Calculation $calculation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Calculation\Calculation  $calculation
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
     * @param  \App\Models\Calculation\Calculation  $calculation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Calculation $calculation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Calculation\Calculation  $calculation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Calculation $calculation)
    {
        //
    }
}

@extends('layouts.app')
<?php
    /*Just for your server-side code*/
    //header('Content-Type: text/html; charset=ISO-8859-1');
    header('Content-Type:text/html; charset=UTF-8');
?>
@section('content')
<div class="container-sec">
  <div class="row">
    <div class="col-md-3">
      @include('includes.sidebar')
    </div>

    <div class="col-md-9 table-sec-area">
      @if (isset($userhistory) && !empty($userhistory))

      <div class="border-color">
        <h3 class="header"> User Search Details </h3>
        <div class="content-sec-user-search">
          @if ($userhistory->id != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> ID </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->id}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->uuid != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> UUID </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->uuid}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->firstname != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> First Name </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->firstname}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->lastname != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Last Name </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->lastname}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->email != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Email </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->email}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->phone != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Phone </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->phone}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->postalcode != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Postal Code </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->postalcode}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->region != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Region </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->region}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->residential_professional != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Residential Or Professional </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->residential_professional}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->familysize != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Family Size </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->familysize}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->comparison_type != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Comparison Type </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->comparison_type}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->meter_type != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Meter Type </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->meter_type}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->pack_id != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Pack ID </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->pack_id}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->eid != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Electricity ID </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->eid}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->gid != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Gas ID </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->gid}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->total_cost != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Total cost </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->total_cost}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->single != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Consumption Single </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->single}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->day != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Consumption Day </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->day}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->night != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Consumption Night </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->night}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->excl_night != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Consumption Exclnight </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->excl_night}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->current_electric_supplier != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Current Electric Supplier </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->current_electric_supplier}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->gas_consumption != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Gas Consumption </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->gas_consumption}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->current_gas_supplier != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Current Gas Supplier </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->current_gas_supplier}} </p>
            </div>
          </div>
          @endif
          <!-- New fields -->

          @if ($userhistory->locale != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Contact language </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->locale}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->decentralise_production != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Decentralise Production </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->decentralise_production}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->capacity_decentalise != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Capacity decentralise </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->capacity_decentalise}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->comparison_savings != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Comparison Savings </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->comparison_savings}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->contact_type != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Contact Type </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->contact_type}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->contact_affiliate != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Contact Affiliate </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->contact_affiliate}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->contact_source != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Contact Source </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->contact_source}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->contact_medium != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Contact Medium</p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->contact_medium}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->contact_campaign != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Contact Campaign </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->contact_campaign}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->comparison_url != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Comparison url </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->comparison_url}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->comparison_current_supplier_e != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Comparison current supplier E </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->comparison_current_supplier_e}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->comparison_current_supplier_g != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Comparison current supplier G </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->comparison_current_supplier_g}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->comparison_filters != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Comparison Filters </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->comparison_filters}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->comparison_energy_cost_e != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Comparison energy cost E </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->comparison_energy_cost_e}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->comparison_other_costs_e != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Comparison other costs E </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->comparison_other_costs_e}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->comparison_energy_cost_g != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Comparison energy cost G </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->comparison_energy_cost_g}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->comparison_other_costs_g != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Comparison other costs G </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->comparison_other_costs_g}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->comparison_promo_amount_e != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Comparison promo amount E </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->comparison_promo_amount_e}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->comparison_promo_amount_g != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Comparison promo amount G </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->comparison_promo_amount_g}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->follow_up_first_enddate != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Follow up first enddate </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->follow_up_first_enddate}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->follow_up_lastaction != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Follow up last action </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->follow_up_lastaction}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->follow_up_status != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Follow up status </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->follow_up_status}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->contract_supplier != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Contract Supplier </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->contract_supplier}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->contract_supplier_id != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Contract Supplier Id </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->contract_supplier_id}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->contract_tariff != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Contract Tariff</p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->contract_tariff}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->contract_tariff_id != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Contract Tariff Id </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->contract_tariff_id}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->contract_signup_url != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Contract signup url </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->contract_signup_url}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->contract_url_tariffcard_e != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Contract url tariffcard E </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->contract_url_tariffcard_e}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->contract_url_tariffcard_g != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Contract url tariffcard G </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->contract_url_tariffcard_g}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->contract_signdate != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Contract signdate </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->contract_signdate}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->contract_startdate != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Contract startdate </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->contract_startdate}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->contract_enddate != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Contract enddate </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->contract_enddate}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->contract_duration_db != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Contract duration db </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->contract_duration_db}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->contract_duration != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Contract duration </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->contract_duration}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->contract_pricetype_e != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Contract pricetype E </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->contract_pricetype_e}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->contract_pricetype_g != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Contract pricetype G </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->contract_pricetype_g}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->contract_energy_cost_e != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Contract energy cost E </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->contract_energy_cost_e}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->contract_energy_cost_g != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Contract energy cost G </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->contract_energy_cost_g}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->contract_othercosts_e != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Contract othercosts E </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->contract_othercosts_e}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->contract_promo_amount_e != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Contract promo amount E </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->contract_promo_amount_e}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->contract_othercosts_g != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Contract othercosts G </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->contract_othercosts_g}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->contract_promo_amount_g != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Contract promo amount G </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->contract_promo_amount_g}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->contract_promo_conditions_duration != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Contract promo duration </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->contract_promo_conditions_duration}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->contract_promo_conditions_servicelevel != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Contract promo servicelevel </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->contract_promo_conditions_servicelevel}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->contract_promo_ids != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Contract promo Ids </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->contract_promo_ids}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->contract_status_supplier != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Contract status supplier </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->contract_status_supplier}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->deal_source != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Deal source </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->deal_source}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->deal_medium != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Deal medium </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->deal_medium}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->deal_campaign != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Deal campaign </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->deal_campaign}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->deal_value != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Deal value </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{$userhistory->deal_value}} </p>
            </div>
          </div>
          @endif
          @if ($userhistory->created_at != NULL)
          <div class="row">
            <div class="col-md-offset-1 col-md-4">
              <p> Created At </p>
            </div>
            <div class="col-md-1"> : </div>
            <div class="col-md-6">
              <p> {{date("D,d M Y H:i:s",strtotime($userhistory->created_at)) }} </p>
            </div>
          </div>
          @endif

        </div>
      </div>
      @else

      <div class="alert alert-warning">
        <strong>Sorry!</strong> No User Data Found.
      </div>
      @endif

      <div class="form-group pull-right" style="padding: 25px">
        <a class="btn btn-default btn-close" href="{{route('usersearch.index')}}">Close</a>
        <a class="btn btn-danger" onclick="return confirm('Are you sure to delete?')" href="{{route('usersearch.delete',$userhistory->id)}}">Delete</a>
      </div>

    </div>
  </div>
</div>


@endsection
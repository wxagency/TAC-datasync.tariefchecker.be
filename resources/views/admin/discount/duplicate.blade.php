@extends('layouts.app')

@section('content')
<div class="container-sec">
    <div class="row">
        <div class="col-md-3">
            @include('includes.sidebar')
        </div>

        <div class="col-md-9">

            <h5>Create Discount</h5>

            <div class="row">

                <div class="col-md-12">
                    <!-- BEGIN VALIDATION STATES-->
                    <div class="portlet light portlet-fit portlet-form">

                        <div class="portlet-body">
                            <!-- BEGIN FORM-->
                            @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                            @endif
                            <form action="{{route('discount.store')}}" method="POST" id="form_sample_1" class="form-horizontal" novalidate="novalidate">
                                {{csrf_field()}}
                                <div class="form-body">
                                    <div class="form-group {{ $errors->has('discountId') ? ' has-error' : '' }}">
                                        <label class="control-label col-md-3">ID
                                            <span class="required" aria-required="true"> * </span>
                                        </label>
                                        <div class="col-md-4">
                                            <input type="text" name="discountId" class="form-control" value="{{$id ? $id : old('discountId')}}" onkeypress="return isNumberKey(event)" readonly>

                                            @if ($errors->has('discountId'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('discountId') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <!-- <div class="form-group {{ $errors->has('discountCreated') ? ' has-error' : '' }}" id="createdat">
                                        <label class="control-label col-md-3">Created At
                                            <span class="required" aria-required="true"> * </span>
                                        </label>
                                        <div class="col-md-4"> -->
                                            <input type="hidden" name="discountCreated" class="form-control" value="{{Carbon\Carbon::now()->format('D, d M Y H:i:s')}}">

                                            <!-- @if ($errors->has('discountCreated'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('discountCreated') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div> -->
                                    <div class="form-group {{ $errors->has('supplier') ? ' has-error' : '' }}">
                                        <label class="control-label col-md-3">Supplier
                                            <span class="required" aria-required="true"> * </span>
                                        </label>
                                        <div class="col-md-4">
                                            <select class="form-control" name="supplier" id="supplier">
                                                <option value="">Select...</option>

                                                @foreach($currentSupplier as $supplier)
                                                <option value="{{$supplier}}">{{$supplier}}</option>
                                                @endforeach
                                            </select>

                                            @if ($errors->has('supplier'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('supplier') }}</strong>
                                            </span>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="form-group {{ $errors->has('startdate') ? ' has-error' : '' }}">
                                        <label class="control-label col-md-3">Start Date
                                            <span class="required" aria-required="true"> * </span>
                                        </label>
                                        <div class="col-md-4">
                                            <div class="input-group date" id="datepicker">
                                                <input type="text" name="startdate" class="form-control" data-required="1" value="{{old('startdate') ? old('startdate') : ''}}">
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>

                                            @if ($errors->has('startdate'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('startdate') }}</strong>
                                            </span>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="form-group {{ $errors->has('enddate') ? ' has-error' : '' }}">
                                        <label class="control-label col-md-3">End Date
                                            <span class="required" aria-required="true"> * </span>
                                        </label>
                                        <div class="col-md-4">
                                            <div class="input-group date" id="datepicker1">
                                                <input type="text" name="enddate" class="form-control" data-required="1" value="{{old('enddate') ? old('enddate') : ''}}">
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>

                                            @if ($errors->has('enddate'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('enddate') }}</strong>
                                            </span>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="form-group {{ $errors->has('customergroup') ? ' has-error' : '' }}">
                                        <label class="control-label col-md-3">Customer Group
                                            <span class="required" aria-required="true"> * </span>
                                        </label>
                                        <div class="col-md-4">
                                            <select class="form-control" name="customergroup" id="customergroup">
                                                <option value="">Select...</option>
                                                <option value="professional">Professional</option>
                                                <option value="residential">Residential</option>
                                            </select>

                                            @if ($errors->has('customergroup'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('customergroup') }}</strong>
                                            </span>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="form-group {{ $errors->has('volume_lower') ? ' has-error' : '' }}">
                                        <label class="control-label col-md-3">VolumeLower
                                            <span class="required" aria-required="true"> * </span>
                                        </label>
                                        <div class="col-md-4">
                                            <input type="text" name="volume_lower" class="form-control" value="{{old('volume_lower') ? old('volume_lower') : '0'}}" onkeypress="return isNumberKey(event)">

                                            @if ($errors->has('volume_lower'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('volume_lower') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('volume_upper') ? ' has-error' : '' }}">
                                        <label class="control-label col-md-3">VolumeUpper
                                            <span class="required" aria-required="true"> * </span>
                                        </label>
                                        <div class="col-md-4">
                                            <input type="text" name="volume_upper" class="form-control" value="{{old('volume_upper') ? old('volume_upper') : '999999999'}}" onkeypress="return isNumberKey(event)">

                                            @if ($errors->has('volume_upper'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('volume_upper') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('discountType') ? ' has-error' : '' }}">
                                        <label class="control-label col-md-3">DiscountType
                                            <!-- <span class="required" aria-required="true"> * </span> -->
                                        </label>
                                        <div class="col-md-4">
                                            <select class="form-control" name="discountType">
                                                <option value="">Select...</option>
                                                <option value="promo" selected>Promo</option>
                                                <option value="loyalty">Loyalty</option>
                                                <option value="servicelevel">Servicelevel</option>
                                                <option value="domi">Domi</option>
                                            </select>

                                            @if ($errors->has('discountType'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('discountType') }}</strong>
                                            </span>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="form-group {{ $errors->has('fuelType') ? ' has-error' : '' }}">
                                        <label class="control-label col-md-3">FuelType
                                            <span class="required" aria-required="true"> * </span>
                                        </label>
                                        <div class="col-md-4">
                                            <select class="form-control" name="fuelType" id="fuel">
                                                <option value="">Select...</option>
                                                <option value="gas">Gas</option>
                                                <option value="electricity">Electricity</option>
                                                <option value="all">All</option>
                                            </select>

                                            @if ($errors->has('fuelType'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('fuelType') }}</strong>
                                            </span>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="form-group {{ $errors->has('discountcodeE') ? ' has-error' : '' }}" id="codee">
                                        <label class="control-label col-md-3">DiscountCodeE
                                            <!-- <span class="required" aria-required="true"> * </span> -->
                                        </label>
                                        <div class="col-md-4">
                                            <input name="discountcodeE" type="text" class="form-control">
                                            @if ($errors->has('discountcodeE'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('discountcodeE') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('discountcodeG') ? ' has-error' : '' }}" id="codeg">
                                        <label class="control-label col-md-3">DiscountCodeG
                                            <!-- <span class="required" aria-required="true"> * </span> -->
                                        </label>
                                        <div class="col-md-4">
                                            <input name="discountcodeG" type="text" class="form-control">
                                            @if ($errors->has('discountcodeG'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('discountcodeG') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('discountcodeP') ? ' has-error' : '' }}" id="codep">
                                        <label class="control-label col-md-3">DiscountCodeP
                                            <!-- <span class="required" aria-required="true"> * </span> -->
                                        </label>
                                        <div class="col-md-4">
                                            <input name="discountcodeP" type="text" class="form-control">
                                            @if ($errors->has('discountcodeP'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('discountcodeP') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group d-none  {{ $errors->has('productId') ? ' has-error' : '' }}" id="productid">
                                        <label class="control-label col-md-3">ProductId
                                            <!-- <span class="required" aria-required="true"> * </span> -->
                                        </label>
                                        <div class="col-md-4">
                                            <select class="form-control" name="productId[]" id="productlist" multiple>
                                                <option value="">Select ProductId</option>
                                            </select>
                                            @if ($errors->has('productId'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('productId') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group d-none  {{ $errors->has('comparisonType') ? ' has-error' : '' }}">
                                        <label class="control-label col-md-3">ComparisonType
                                            <!-- <span class="required" aria-required="true"> * </span> -->
                                        </label>
                                        <div class="col-md-4">
                                            <select class="form-control" name="comparisonType">
                                                <option value="">Select...</option>
                                                <option value="No limitation" selected>No limitation</option>
                                                <option value="Packs only">Packs only</option>
                                                <option value="Single Fuel + E and G separately">Single Fuel + E and G separately</option>
                                            </select>

                                            @if ($errors->has('comparisonType'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('comparisonType') }}</strong>
                                            </span>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="form-group d-none  {{ $errors->has('channel') ? ' has-error' : '' }}">
                                        <label class="control-label col-md-3">Channel
                                            <!-- <span class="required" aria-required="true"> * </span> -->
                                        </label>
                                        <div class="col-md-4">
                                            <select class="form-control" name="channel">
                                                <option value="">Select...</option>
                                                <option value="exclusive_to_comparators" selected>exclusive_to_comparators</option>
                                                <option value="non_exclusive">non_exclusive</option>
                                            </select>

                                            @if ($errors->has('channel'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('channel') }}</strong>
                                            </span>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="form-group d-none  {{ $errors->has('applicationVContractDuration') ? ' has-error' : '' }}">
                                        <label class="control-label col-md-3">Application V ContractDuration
                                            <!-- <span class="required" aria-required="true"> * </span> -->
                                        </label>
                                        <div class="col-md-4">
                                            <select class="form-control" name="applicationVContractDuration">
                                                <option value="">Select...</option>
                                                <option value="only_if_1_full_year_duration">only_if_1_full_year_duration</option>
                                                <option value="pro_rata">pro_rata</option>
                                            </select>

                                            @if ($errors->has('applicationVContractDuration'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('applicationVContractDuration') }}</strong>
                                            </span>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="form-group d-none  {{ $errors->has('serviceLevelPayment') ? ' has-error' : '' }}">
                                        <label class="control-label col-md-3">ServiceLevelPayment
                                            <!-- <span class="required" aria-required="true"> * </span> -->
                                        </label>
                                        <div class="col-md-4">
                                            <select class="form-control" name="serviceLevelPayment">
                                                <option value="">Select...</option>
                                                <option value="free" selected>free</option>
                                                <option value="domi">domi</option>
                                            </select>

                                            @if ($errors->has('serviceLevelPayment'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('serviceLevelPayment') }}</strong>
                                            </span>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="form-group d-none  {{ $errors->has('serviceLevelInvoicing') ? ' has-error' : '' }}">
                                        <label class="control-label col-md-3">ServiceLevelInvoicing
                                            <!-- <span class="required" aria-required="true"> * </span> -->
                                        </label>
                                        <div class="col-md-4">
                                            <select class="form-control" name="serviceLevelInvoicing">
                                                <option value="">Select...</option>
                                                <option value="free" selected>free</option>
                                                <option value="email">email</option>
                                            </select>

                                            @if ($errors->has('serviceLevelInvoicing'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('serviceLevelInvoicing') }}</strong>
                                            </span>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="form-group d-none  {{ $errors->has('serviceLevelContact') ? ' has-error' : '' }}">
                                        <label class="control-label col-md-3">ServiceLevelContact
                                            <!-- <span class="required" aria-required="true"> * </span> -->
                                        </label>
                                        <div class="col-md-4">
                                            <select class="form-control" name="serviceLevelContact">
                                                <option value="">Select...</option>
                                                <option value="free" selected>free</option>
                                                <option value="online">online</option>
                                            </select>

                                            @if ($errors->has('serviceLevelContact'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('serviceLevelContact') }}</strong>
                                            </span>
                                            @endif
                                        </div>

                                    </div>

                                    <div class="form-group d-none  {{ $errors->has('minimumSupplyCondition') ? ' has-error' : '' }}">
                                        <label class="control-label col-md-3">MinimumSupplyCondition
                                            <!-- <span class="required" aria-required="true"> * </span> -->
                                        </label>
                                        <div class="col-md-4">
                                            <input name="minimumSupplyCondition" type="text" class="form-control" onkeypress="return isNumberKey(event)" value="{{old('minimumSupplyCondition') ? old('minimumSupplyCondition') : 0}}">
                                            @if ($errors->has('minimumSupplyCondition'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('minimumSupplyCondition') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group d-none  {{ $errors->has('duration') ? ' has-error' : '' }}">
                                        <label class="control-label col-md-3">Duration
                                            <!-- <span class="required" aria-required="true"> * </span> -->
                                        </label>
                                        <div class="col-md-4">
                                            <!--<select class="form-control" name="duration">-->
                                            <!--    <option value="">Select...</option>-->
                                            <!--    <option value="1" selected>1</option>-->
                                            <!--    <option value="999">999</option>-->
                                            <!--</select>-->
                                            <input name="duration" type="text" class="form-control" onkeypress="return isNumberKey(event)" value="{{old('minimumSupplyCondition') ? old('minimumSupplyCondition') : '999'}}">
                                            @if ($errors->has('duration'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('duration') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group d-none  {{ $errors->has('applicability') ? ' has-error' : '' }}">
                                        <label class="control-label col-md-3">Applicability
                                            <!-- <span class="required" aria-required="true"> * </span> -->
                                        </label>
                                        <div class="col-md-4">
                                            <select class="form-control" name="applicability">
                                                <option value="">Select...</option>
                                                <option value="connection" selected>connection</option>
                                                <option value="customer">customer</option>
                                            </select>
                                            @if ($errors->has('applicability'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('applicability') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group d-none  {{ $errors->has('valueType') ? ' has-error' : '' }}">
                                        <label class="control-label col-md-3">ValueType
                                            <!-- <span class="required" aria-required="true"> * </span> -->
                                        </label>
                                        <div class="col-md-4">
                                            <select class="form-control" name="valueType">
                                                <option value="">Select...</option>
                                                <option value="fixed">fixed</option>
                                                <option value="usage">usage</option>
                                            </select>
                                            @if ($errors->has('valueType'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('valueType') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group d-none  {{ $errors->has('value') ? ' has-error' : '' }}">
                                        <label class="control-label col-md-3">Value
                                            <!-- <span class="required" aria-required="true"> * </span> -->
                                        </label>
                                        <div class="col-md-4">
                                            <input name="value" type="text" class="form-control">
                                            @if ($errors->has('value'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('value') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group d-none  {{ $errors->has('unit') ? ' has-error' : '' }}">
                                        <label class="control-label col-md-3">Unit
                                            <!-- <span class="required" aria-required="true"> * </span> -->
                                        </label>
                                        <div class="col-md-4">
                                            <select class="form-control" name="unit">
                                                <option value="">Select...</option>
                                                <option value="euro">euro</option>
                                                <option value="pct">pct</option>
                                                <option value="eurocent">eurocent</option>
                                            </select>
                                            @if ($errors->has('unit'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('unit') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group d-none  {{ $errors->has('applicableForExistingCustomers') ? ' has-error' : '' }}">
                                        <label class="control-label col-md-3">Applicable For ExistingCustomers
                                            <!-- <span class="required" aria-required="true"> * </span> -->
                                        </label>
                                        <div class="col-md-4">
                                            <select class="form-control" name="applicableForExistingCustomers">
                                                <option value="">Select...</option>
                                                <option value="TRUE">True</option>
                                                <option value="FALSE" selected>False</option>
                                            </select>
                                            @if ($errors->has('applicableForExistingCustomers'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('applicableForExistingCustomers') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group d-none  {{ $errors->has('nameNl') ? ' has-error' : '' }}">
                                        <label class="control-label col-md-3">NameNl
                                            <!-- <span class="required" aria-required="true"> * </span> -->
                                        </label>
                                        <div class="col-md-8">
                                            <textarea name="nameNl" type="text" class="form-control" id="summary-ckeditor">{{old('nameNl') ? old('nameNl') : ''}}</textarea>
                                            @if ($errors->has('nameNl'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('nameNl') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group d-none  {{ $errors->has('descriptionNl') ? ' has-error' : '' }}">
                                        <label class="control-label col-md-3">DescriptionNl
                                            <!-- <span class="required" aria-required="true"> * </span> -->
                                        </label>
                                        <div class="col-md-8">
                                            <textarea name="descriptionNl" type="text" class="form-control" id="summary-ckeditor-dn">{{old('descriptionNl') ? old('descriptionNl') : ''}}</textarea>
                                            @if ($errors->has('descriptionNl'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('descriptionNl') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group d-none  {{ $errors->has('nameFr') ? ' has-error' : '' }}">
                                        <label class="control-label col-md-3">NameFr
                                            <!-- <span class="required" aria-required="true"> * </span> -->
                                        </label>
                                        <div class="col-md-8">
                                            <textarea name="nameFr" type="text" class="form-control" id="summary-ckeditor-nf">{{old('nameFr') ? old('nameFr') : ''}}</textarea>
                                            @if ($errors->has('nameFr'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('nameFr') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group d-none  {{ $errors->has('descriptionFr') ? ' has-error' : '' }}">
                                        <label class="control-label col-md-3">DescriptionFr
                                            <!-- <span class="required" aria-required="true"> * </span> -->
                                        </label>
                                        <div class="col-md-8">
                                            <textarea name="descriptionFr" type="text" class="form-control" id="summary-ckeditor-df">{{old('descriptionFr') ? old('descriptionFr') : ''}}</textarea>
                                            @if ($errors->has('descriptionFr'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('descriptionFr') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions  d-none ">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button type="submit" class="btn btn-primary" id="submit" disabled>Submit</button>
                                            <button type="button" class="btn btn-secondary">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!-- END FORM-->
                        </div>
                    </div>
                    <!-- END VALIDATION STATES-->
                </div>
            </div>
        </div>
        @endsection
        <!-- // text editor -->
        <style type="text/css">
            .show-s {
                display: block !important;
            }
        </style>
        <!-- <script src="//cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script> -->
        @push('scripts')
        <script type="text/javascript">
        
            // number field
                function isNumberKey(evt) {
                    var charCode = (evt.which) ? evt.which : evt.keyCode
                    if (charCode > 31 && (charCode < 48 || charCode > 57))
                        return false;
                    return true;
                }
            jQuery(document).ready(function() {
                CKEDITOR.replace('summary-ckeditor');
                CKEDITOR.replace('summary-ckeditor-dn');
                CKEDITOR.replace('summary-ckeditor-nf');
                CKEDITOR.replace('summary-ckeditor-df');

                // $("#createdat").hide();
                $("#codeg").hide();
                $("#codep").hide();
                $("#codee").hide();
                // $('#productid').hide();

                
                // $(function() {
                //     $('#datepicker').datetimepicker();
                //     // format: 'D, d M Y H:i:s'
                //     format: 'dd-mm-yyyy'
                // });

                $('#datepicker').datepicker({
                    format: 'dd-mm-yyyy'
                });
                $('#datepicker1').datepicker({
                    format: 'dd-mm-yyyy'
                });


                $(document).on('change', '#fuel,#supplier,#customergroup', function() {
                    var supplier = $('#supplier').val();
                    var customergroup = $('#customergroup').val();
                    var fuel = $('#fuel').val();
                    if (fuel == 'gas') {
                        $("#codeg").show();
                        $("#codep").show();
                        $("#codee").hide();
                    } else if (fuel == 'electricity') {
                        $("#codeg").hide();
                        $("#codep").show();
                        $("#codee").show();
                    } else if (fuel == 'all') {
                        $("#codeg").show();
                        $("#codep").show();
                        $("#codee").show();
                    } else {
                        $("#codeg").hide();
                        $("#codep").hide();
                        $("#codee").hide();
                    }
                    if (supplier != "" && customergroup != "" && fuel != "") {
                        $.ajax({
                            url: '{{url("discount/product-list/")}}',
                            type: "GET",
                            data: {
                                "fuel": fuel,
                                "supplier": supplier,
                                "customergroup": customergroup,
                            },
                            success: function(data) {
                                $('#productlist').empty();
                                console.log(data);
                                var len = 0;
                                if (data != null) {
                                    len = data.length;
                                }
                                if (len > 0) {
                                    // Read data and create <option >
                                    $(".d-none.").addClass("show-s");
                                    for (var i = 0; i < len; i++) {

                                        var product = data[i];
                                        var option = "<option value='" + product + "'>" + product + "</option>";

                                        $("#productlist").append(option);
                                    }
                                } else {
                                    toastr.warning('Er is geen product beschikbaar voor de geselecteerde criteria');

                                }
                            },
                            error: function(e) {
                                console.log(e.message);
                            }
                        });
                    } else {
                        $('#productlist').empty();
                    }

                });

                // enable submit
                $(document).on('change', '#productlist', function() {
                    // alert($(this).val());
                    if ($(this).val() == null || $(this).val() == '') {
                        $('#submit').prop('disabled', true);
                    } else {
                        $('#submit').prop('disabled', false);
                    }
                });
            });
        </script>
        @endpush
@extends('layouts.app')

@section('content')
<div class="container-sec">
    <div class="row">
        <div class="col-md-3">
         @include('includes.sidebar')
        </div>
        
        <div class="col-md-9">
          
 
<!-- /****************************Dynamic data****************************** */ -->
              <!--<div class="panel panel-default">-->
              <!--  <div class="row">-->
              <!--    <div class="col-md-12">-->
              <!--        <div class="outer-sec-sync">-->
              <!--            <div class="heading-sec">-->
              <!--              <div class="col-md-5">-->
              <!--                <h4>Sync Dynamic data </h4>-->
              <!--              </div>-->
              <!--              <div class="col-md-4">-->
              <!--                  <h4>Last Synced At </h4> -->
              <!--              </div>-->
                        
              <!--            </div>-->
              <!--            <div class="content-sec">-->

              <!--              <div class="row border-sec">-->
              <!--                <div class="col-md-5">-->
              <!--                  Dynamic Residential data -->
              <!--                  <i class="fas fa-info-circle tool-sec-tip" rel="tooltip"  title="Sync Gas and Electricity of residential type. Syncing is possible if static data is synced before."></i>-->
                                 
              <!--                </div>-->
              <!--                <div class="col-md-4 dyn-resbackup">-->
              <!--                  @if(isset($dynamicRes->backupdate) && !empty($dynamicRes->backupdate)){{date("D,d M Y H:i:s",strtotime($dynamicRes->backupdate))}}-->
              <!--                  @else -->
              <!--                      {{date("D,d M Y H:i:s",strtotime($dynResSyn->updated_at))}}-->
              <!--                  @endif-->
              <!--                </div>-->
              <!--                <div class="col-md-2">-->
              <!--                        <span id="error_message" class="text-danger"></span>  -->
              <!--                        <span id="success_message7" class="text-success"></span> -->
              <!--                </div>-->
              <!--                <div class="col-md-1 syn-icon">-->
              <!--                  <a href="javascript:void(0)"><i class="fas fa-sync-alt" id="dynamicresident" title="Click to sync Residential data"></i><span id="loaderRd" style="display:none; width:10px; height:20px"><img id="load-img" src="{{url('images/Spinner-1s-61px.gif')}}" alt="loading" /></span></a>-->
              <!--                </div>-->
              <!--              </div>-->

              <!--              <div class="row border-sec">-->
              <!--                  <div class="col-md-5">-->
              <!--                    Dynamic Professional data-->
              <!--                  <i class="fa fa-info-circle tool-sec-tip" rel="tooltip" title="Sync Gas and Electricity of Professional type. Syncing is possible if static data is synced before."></i>-->
              <!--                  </div>-->
              <!--                  <div class="col-md-4 dyn-probackup">-->
              <!--                    @if(isset($dynamicPro->backupdate) && !empty($dynamicPro->backupdate)){{date("D,d M Y H:i:s",strtotime($dynamicPro->backupdate))}}-->
              <!--                    @else-->
              <!--                        {{date("D,d M Y H:i:s",strtotime($dynProSyn->updated_at))}}-->
              <!--                    @endif -->
              <!--                  </div>-->
              <!--                  <div class="col-md-2">-->
              <!--                          <span id="error_message" class="text-danger"></span>  -->
              <!--                          <span id="success_message8" class="text-success"></span> -->
              <!--                  </div>-->
              <!--                  <div class="col-md-1 syn-icon">-->
              <!--                    <a href="javascript:void(0)"><i class="fas fa-sync-alt" id="dynamicprofession" title="Click to sync Professional data"></i><span id="loaderPd" style="display:none; width:10px; height:20px"><img id="load-img" src="{{url('images/Spinner-1s-61px.gif')}}" alt="loading" /></span></a>-->
              <!--                  </div>-->
              <!--              </div>-->

              <!--            </div>-->
              <!--          </div>-->
              <!--      </div>-->
              <!--  </div>-->
              <!--</div>-->
 
  <!-- //********************************Discount************************** */ -->
            <?php date_default_timezone_set('Europe/Amsterdam'); ?>
              <div class="panel panel-default">
                <div class="row">
                  <div class="col-md-12">
                      <div class="outer-sec-sync">
                          <div class="heading-sec">
                            <div class="col-md-5">
                              <h4>Sync Discount</h4>
                            </div>
                            <div class="col-md-4">
                                <h4>Last Synced At</h4>
                            </div>
                        
                          </div>
                          <div class="content-sec">
                          
                          <div class="row border-sec">
                              <div class="col-md-5">
                                Discounts
                                <i class="fa fa-info-circle tool-sec-tip" rel="tooltip" title="Sync the Discounts here, but make sure to sync the Suppliers first (Static Data)"></i>
                              </div>
                              <div class="col-md-4 disc-backup">
                                @if(isset($discounts->backupdate) && !empty($discounts->backupdate)){{date("l, d F Y H:i:s",strtotime($discounts->backupdate))}}
                                @else
                                    {{date("l, d F Y H:i:s",strtotime($discSync->updated_at))}}
                                @endif 
                              </div>
                              <div class="col-md-2">
                                      <span id="error_message" class="text-danger"></span>  
                                      <span id="success_message12" class="text-success"></span> 
                              </div>
                              <div class="col-md-1 syn-icon">
                                <a href="javascript:void(0)"><i class="fas fa-sync-alt" id="discounts" title="Click to sync Discounts"></i><span id="loaderDisc" style="display:none; width:10px; height:20px"><img id="load-img" src="{{url('images/Spinner-1s-61px.gif')}}" alt="loading" /></span></a>
                                <span id="g_success_message12" style="display: none; color: #75ca42; ont-size: 12px;">Sync completed</span>
                              </div>
                          </div>

                          </div>
                        </div>
                    </div>
                </div>
              </div>

     <!-- //******************************* tax ***************************** */ -->
               <div class="panel panel-default">
               <div class="row">
                 <div class="col-md-12">
                     <div class="outer-sec-sync">
                         <div class="heading-sec">
                           <div class="col-md-5">
                             <h4>Sync Tax</h4>
                           </div>
                           <div class="col-md-4">
                               <h4>Last Synced At</h4>
                           </div>
                        
                         </div>
                         <div class="content-sec">
                          
                         <div class="row border-sec">
                             <div class="col-md-5">
                               Tax
                               <i class="fa fa-info-circle tool-sec-tip" rel="tooltip" title="Sync taxes of Gas and Electricity."></i>
                             </div>
                             <div class="col-md-4 tax-backup">
                               @if(isset($tax->backupdate) && !empty($tax->backupdate)){{date("D,d M Y H:i:s",strtotime($tax->backupdate))}}
                               @else
                                   {{date("l, d F Y H:i:s",strtotime($taxSyn->updated_at))}}
                               @endif
                             </div>
                             <div class="col-md-2">
                                     <span id="error_message" class="text-danger"></span> 
                                     <span id="success_message9" class="text-success"></span>
                             </div>
                             <div class="col-md-1 syn-icon">
                               <a href="javascript:void(0)"><i class="fas fa-sync-alt" id="tax" title="Click to sync Tax"></i><span id="loaderT" style="display:none; width:10px; height:20px"><img id="load-img" src="{{url('images/Spinner-1s-61px.gif')}}" alt="loading" /></span></a>
                               <span id="g_success_message9" style="display: none; color: #75ca42; ont-size: 12px;">Sync completed</span>
                             </div>
                         </div>

                         </div>
                       </div>
                   </div>
               </div>
              </div>
    <!-- //**************************** Netcost ****************************** */ -->
              <div class="panel panel-default">
               <div class="row">
                 <div class="col-md-12">
                     <div class="outer-sec-sync">
                         <div class="heading-sec">
                           <div class="col-md-5">
                             <h4>Sync Netcost</h4>
                           </div>
                           <div class="col-md-4">
                               <h4>Last Synced At</h4>
                           </div>
                        
                         </div>
                         <div class="content-sec">
                          
                         <div class="row border-sec">
                             <div class="col-md-5">
                               Netcost Electricity
                               <i class="fa fa-info-circle tool-sec-tip" rel="tooltip" title="Sync Netcost Electricity"></i>
                             </div>
                             <div class="col-md-4 nete-backup">
                               @if(isset($netcoste->backupdate) && !empty($netcoste->backupdate)){{date("l, d F Y H:i:s",strtotime($netcoste->backupdate))}}
                               @else
                                   {{date("l, d F Y H:i:s",strtotime($netcosteSyn->updated_at))}}
                               @endif
                             </div>
                             <div class="col-md-2">
                                     <span id="error_message" class="text-danger"></span> 
                                     <span id="success_message10" class="text-success"></span>
                             </div>
                             <div class="col-md-1 syn-icon">
                               <a href="javascript:void(0)"><i class="fas fa-sync-alt" id="netelectricity" title="Click to sync netcost"></i><span id="loaderNe" style="display:none; width:10px; height:20px"><img id="load-img" src="{{url('images/Spinner-1s-61px.gif')}}" alt="loading" /></span></a>
                               <span id="g_success_message10" style="display: none; color: #75ca42; ont-size: 12px;">Sync completed</span>
                             </div>
                         </div>

                         <div class="row border-sec">
                             <div class="col-md-5">
                               Netcost Gas
                               <i class="fa fa-info-circle tool-sec-tip" rel="tooltip" title="Sync Netcost Gas"></i>
                             </div>
                             <div class="col-md-4 netg-backup">
                               @if(isset($netcostg->backupdate) && !empty($netcostg->backupdate)){{date("l, d F Y H:i:s",strtotime($netcostg->backupdate))}}
                               @else
                                   {{date("l, d F Y H:i:s",strtotime($netcostgSyn->updated_at))}}
                               @endif
                             </div>
                             <div class="col-md-2">
                                     <span id="error_message" class="text-danger"></span> 
                                     <span id="success_message11" class="text-success"></span>
                             </div>
                             <div class="col-md-1 syn-icon">
                               <a href="javascript:void(0)"><i class="fas fa-sync-alt" id="netgas" title="Click to sync netcost of gas"></i><span id="loaderNg" style="display:none; width:10px; height:20px"><img id="load-img" src="{{url('images/Spinner-1s-61px.gif')}}" alt="loading" /></span></a>
                               <span id="g_success_message11" style="display: none; color: #75ca42; ont-size: 12px;">Sync completed</span>
                             </div>
                         </div>                         

                         </div>
                       </div>
                   </div>
               </div>
              </div>
<!-- //****************************** All Dynamic ********************************* */ -->
            <div class="panel panel-default">
                <div class="row">
                  <div class="col-md-12">
                      <div class="outer-sec-sync">
                          <div class="heading-sec">
                            <div class="col-md-5">
                              <h4>Sync all Dynamic data</h4>
                            </div>
                            <div class="col-md-4">
                                <h4>Last Synced At</h4>
                            </div>
                        
                          </div>
                          <div class="content-sec">
                            <div class="row border-sec">
                              <div class="col-md-5">
                                All the Dynamic data
                                <i class="fas fa-info-circle tool-sec-tip" rel="tooltip" title="Sync the Dynamic data here (Gas and Electricity). Make sure to sync the Static Data first."></i>
                              </div>
                              <div class="col-md-4 alldyn-backup">
                               
                                @if(isset($dynamiclast->backupdate) && !empty($dynamiclast->backupdate)){{date("l, d F Y H:i:s",strtotime($dynamiclast->backupdate))}}
                                @else
                                    {{date("l, d F Y H:i:s",strtotime($dynlastSyn->updated_at))}}
                                @endif
                              </div>
                              <div class="col-md-2">
                                      <span id="error_message" class="text-danger"></span>  
                                      <span id="success_message6" class="text-success"></span> 
                                    </div>
                              <div class="col-md-1 syn-icon">
                                <a href="javascript:void(0)"><i class="fas fa-sync-alt" id="dynamicdetails" title="Click to sync all the dynamic data"></i><span id="loaderAllD" style="display:none; width:10px; height:20px"><img id="load-img" src="{{url('images/Spinner-1s-61px.gif')}}" alt="loading" /></span></a>
                                <span id="g_success_message6" style="display: none; color: #75ca42; ont-size: 12px;">Sync completed</span>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
              </div>  
  
<!-- // **************************** Static **************************** -->
        
<!--<div class="panel panel-default">-->
<!--              <div class="row">-->
<!--                <div class="col-md-12">-->
<!--                    <div class="outer-sec-sync">-->
<!--                        <div class="head-sec">-->
<!--                          <div class="col-md-5">-->
<!--                            <h4>Sync Static data</h4>-->
<!--                          </div>-->
<!--                          <div class="col-md-4">-->
<!--                              <h4>Last Synced At</h4>-->
<!--                          </div>-->
                      
<!--                        </div>-->
<!--                        <div class="content-sec">-->
<!--                          <div class="row border-sec">-->
<!--                            <div class="col-md-5">-->
<!--                              Residential Static data-->
<!--                                <i class="fas fa-info-circle tool-sec-tip" rel="tooltip" title="Sync Gas and Electricity of residential type. Syncing is possible if the supplier is synced before."></i>-->
<!--                            </div>-->
<!--                            <div class="col-md-4 res-backup">-->
<!--                              @if(isset($staticRes->backup_date) && !empty($staticRes->backup_date)){{date("D,d M Y H:i:s",strtotime($staticRes->backup_date)) }}-->
<!--                              @else -->
<!--                                  {{ date("D,d M Y H:i:s",strtotime($staticResSyn->updated_at)) }}-->
<!--                              @endif -->
<!--                            </div>-->
<!--                            <div class="col-md-2">-->
<!--                                    <span id="error_message" class="text-danger"></span>  -->
<!--                                    <span id="success_message2" class="text-success"></span> -->
<!--                            </div>-->
<!--                            <div class="col-md-1 syn-icon">-->
<!--                              <a href="javascript:void(0)"><i class="fas fa-sync-alt" id="resident" title="Click to sync Residential data"></i><span id="loaderRs" style="display:none; width:10px; height:20px"><img id="load-img" src="{{url('images/Spinner-1s-61px.gif')}}" alt="loading" /></span></a>-->
<!--                            </div>-->
<!--                          </div>  -->

<!--                          <div class="row border-sec">-->
<!--                            <div class="col-md-5">-->
<!--                              Professional static data-->
<!--                                <i class="fas fa-info-circle tool-sec-tip" rel="tooltip" title="Sync Gas and Electricity. Syncing is possible if supplier is synced before."></i>-->
<!--                            </div>-->
<!--                            <div class="col-md-4 pro-backup">-->
<!--                              @if(isset($staticPro->backupdate) && !empty($staticPro->backupdate)){{date("D,d M Y H:i:s",strtotime( $staticPro->backupdate))}}-->
<!--                              @else-->
<!--                                  {{date("D,d M Y H:i:s",strtotime( $staticProSyn->updated_at))}}-->
<!--                              @endif -->
<!--                            </div>-->
<!--                            <div class="col-md-2">-->
<!--                                    <span id="error_message" class="text-danger"></span>  -->
<!--                                    <span id="success_message3" class="text-success"></span> -->
<!--                                  </div>-->
<!--                            <div class="col-md-1 syn-icon">-->
<!--                              <a href="javascript:void(0)"><i class="fas fa-sync-alt" id="profession" title="Click to sync Professional data"></i><span id="loaderProS" style="display:none; width:10px; height:20px"><img id="load-img" src="{{url('images/Spinner-1s-61px.gif')}}" alt="loading" /></span></a>-->
<!--                            </div>-->
<!--                          </div>-->

<!--                        </div>-->
<!--                      </div>-->
<!--                  </div>-->
<!--              </div>-->
<!--            </div>-->
  <!-- //****************************Packs******************** */ -->
            <!--<div class="panel panel-default">-->
            <!--  <div class="row">-->
            <!--    <div class="col-md-12">-->
            <!--      <div class="outer-sec-sync">-->
            <!--        <div class="head-sec">-->
            <!--            <div class="col-md-5">-->
            <!--              <h4>Sync Pack</h4>-->
            <!--            </div>-->
            <!--            <div class="col-md-4">-->
            <!--                <h4>Last Synced At</h4>-->
            <!--            </div>-->
                    
            <!--          </div>-->
            <!--        <div class="content-sec">-->
            <!--          <div class="row border-sec">-->
            <!--              <div class="col-md-5">-->
            <!--                Packs data-->
            <!--                    <i class="fas fa-info-circle tool-sec-tip" rel="tooltip" title="Packs have relation from individual Electricity and gas tables. Also from suppliers"></i>-->
            <!--              </div>-->
            <!--              <div class="col-md-4 pack-backup">-->
            <!--                @if(isset($packs->backupdate) && !empty($packs->backupdate)){{date("D,d M Y H:i:s",strtotime($packs->backupdate)) }}-->
            <!--                @else-->
            <!--                    {{date("D,d M Y H:i:s",strtotime($packsSyn->updated_at)) }}-->
            <!--                @endif -->
            <!--              </div>-->
            <!--              <div class="col-md-2">-->
            <!--                      <span id="error_message" class="text-danger"></span>  -->
            <!--                      <span id="success_message4" class="text-success"></span> -->
            <!--                    </div>-->
            <!--              <div class="col-md-1 syn-icon">-->
            <!--                  <a href="javascript:void(0)"><i class="fas fa-sync-alt" id="packs" title="Click to sync Packs"></i><span id="loaderPack" style="display:none; width:10px; height:20px"><img id="load-img" src="{{url('images/Spinner-1s-61px.gif')}}" alt="loading" />-->
            <!--                  </span></a>-->
            <!--              </div>-->
            <!--          </div>-->
            <!--        </div>-->
            <!--      </div>-->
            <!--    </div>-->
            <!--  </div>-->
            <!--</div>-->



<!-- //**************************** All Static ****************************** */ -->
          <div class="panel panel-default">
              <div class="row">
                <div class="col-md-12">
                    <div class="outer-sec-sync">
                        <div class="head-sec">
                          <div class="col-md-5">
                            <h4>Sync all Static data</h4>
                          </div>
                          <div class="col-md-4">
                              <h4>Last Synced At</h4>
                          </div>
                      
                        </div>
                        <div class="content-sec">
                          <div class="row border-sec">
                              <div class="col-md-5">
                                All the Static data
                                <i class="fas fa-info-circle tool-sec-tip" rel="tooltip" title="Sync the Static Data here (Suppliers, DGO, Residential and Professional Tables, Electricity and Gas, and Packs)"></i>
                              </div>
                              <div class="col-md-4 allstat-backup">
                                @if(isset($staticlast->backupdate) && !empty($staticlast->backupdate)){{date("l, d F Y H:i:s",strtotime($staticlast->backupdate)) }}
                                @else
                                    {{date("l, d F Y H:i:s",strtotime($staticlastSyn->updated_at)) }}
                                @endif 
                              </div>
                              <div class="col-md-2">
                                    <span id="error_message" class="text-danger"></span>  
                                    <span id="success_message1" class="text-success"></span> 
                              </div>
                              <div class="col-md-1 syn-icon">
                                <a href="javascript:void(0)">
                                  <i class="fas fa-sync-alt" id="static" title="Click to sync All the static data"></i>
                                  <span id="loaderS" style="display:none;"><img id="load-img" src="{{url('images/Spinner-1s-61px.gif')}}" alt="loading" /></span>
                                </a>
                                <span id="g_success_message1" style="display: none; color: #75ca42; ont-size: 12px;">Sync completed</span>
                              </div>
                          </div>  
                        </div>
                      </div>
                  </div>
              </div>
            </div> 
            <!-- //**************************** Postal code *********************** */ -->
       
            <div class="panel panel-default">
                <div class="row">
                  <div class="col-md-12">
                      <div class="outer-sec-sync">
                          <div class="head-sec">
                            <div class="col-md-5">
                              <h4>Sync Postal code</h4>
                            </div>
                            <div class="col-md-4">
                                <h4>Last Synced At</h4>
                            </div>
                        
                          </div>
                          <div class="content-sec">
                            <div class="row border-sec">
                              <div class="col-md-5">
                                Postal Codes
                                <i class="fas fa-info-circle tool-sec-tip" rel="tooltip" title="Sync the Postal codes here."></i>
                              </div>
                              <div class="col-md-4 post-backup">
                                @if(isset($postalcodes->backupdate) && !empty($postalcodes->backupdate)){{date("l, d F Y H:i:s",strtotime($postalcodes->backupdate)) }}
                                @else 
                                    {{date("l, d F Y H:i:s",strtotime($postalSyn->updated_at)) }}
                                @endif
                              </div>
                              <div class="col-md-2">
                                      <span id="error_message" class="text-danger"></span>  
                                      <span id="success_message5" class="text-success"></span> 
                              </div>
                              <div class="col-md-1 syn-icon">
                                  <a href="javascript:void(0)"><i class="fas fa-sync-alt" id="postcode" title="Click to sync Postalcodes"></i><span id="loaderPost" style="display:none; width:10px; height:20px"><img id="load-img" src="{{url('images/Spinner-1s-61px.gif')}}" alt="loading" /></span></a>
                                  <span id="g_success_message5" style="display: none; color: #75ca42; ont-size: 12px;">Sync completed</span>
                              </div>
                            </div> 
                          </div>
                        </div>
                    </div>
                </div>
              </div>
              
              
              <div class="panel panel-default">
                <div class="row">
                  <div class="col-md-12">
                      <div class="outer-sec-sync">
                          <div class="head-sec">
                            <div class="col-md-5">
                              <h4>Sync Estimate Consumption</h4>
                            </div>
                            <div class="col-md-4">
                                <h4>Last Synced At</h4>
                            </div>
                        
                          </div>
                          <div class="content-sec">
                            <div class="row border-sec">
                              <div class="col-md-5">
                                Estimate Consumption
                                <i class="fas fa-info-circle tool-sec-tip" rel="tooltip" title="Postal codes of electricity and gas"></i>
                              </div>
                              <div class="col-md-4 post-backup">
                               
                               
                                    {{date("l, d F Y H:i:s",strtotime($EstimateConsumption->updated_at)) }}
                               
                              </div>
                              <div class="col-md-2">
                                      <span id="error_message" class="text-danger"></span>  
                                      <span id="success_message5" class="text-success"></span> 
                              </div>
                              <div class="col-md-1 syn-icon">
                                  <a href="javascript:void(0)"><i class="fas fa-sync-alt" id="estimate" title="Click to sync Postalcodes"></i><span id="loaderesti" style="display:none; width:10px; height:20px"><img id="load-img" src="{{url('images/Spinner-1s-61px.gif')}}" alt="loading" /></span></a>
                                  <span id="success_message16" style="display: none; color: #75ca42; ont-size: 12px;">Sync completed</span>
                              </div>
                            </div> 
                          </div>
                        </div>
                    </div>
                </div>
              </div>
<!-- //******************************* Supplier ***************************** */ -->
<!--<div class="panel panel-default">-->
<!--                <div class="row">-->
<!--                  <div class="col-md-12">-->
<!--                      <div class="outer-sec-sync">-->
<!--                          <div class="head-sec">-->
<!--                            <div class="col-md-5">-->
<!--                              <h4>Sync Supplier</h4>-->
<!--                            </div>-->
<!--                            <div class="col-md-4">-->
<!--                                <h4>Last Synced At</h4>-->
<!--                            </div>-->
                        
<!--                          </div>-->
<!--                          <div class="content-sec">-->
                          
<!--                            <div class="row border-sec">-->
<!--                                <div class="col-md-5">-->
<!--                                  Supplier-->
<!--                                <i class="fas fa-info-circle tool-sec-tip" rel="tooltip" title="Sync Supplier. A base table" aria-hidden="true"></i>-->
<!--                                </div>-->
<!--                                <div class="col-md-4 supply-backup">-->
<!--                                  @if(isset($supplier->backupdate) && !empty($supplier->backupdate)){{date("D,d M Y H:i:s",strtotime($supplier->backupdate)) }}-->
<!--                                  @else -->
<!--                                      {{date("D,d M Y H:i:s",strtotime($supplySync->updated_at)) }}-->
<!--                                  @endif -->
<!--                                </div>-->
<!--                                <div class="col-md-2">-->
<!--                                        <span id="error_message" class="text-danger"></span>  -->
<!--                                        <span id="success_message13" class="text-success"></span> -->
<!--                                </div>-->
<!--                                <div class="col-md-1 syn-icon">-->
<!--                                  <a href="javascript:void(0)"><i class="fas fa-sync-alt" id="supplier"></i><span id="loaderSupply" style="display:none; width:10px; height:20px"><img id="load-img" src="{{url('images/Spinner-1s-61px.gif')}}" alt="loading" /></span></a>-->
<!--                                </div>-->
<!--                            </div>-->

<!--                          </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--              </div>-->
  <!-- //*****************************DGO********************************* */           -->
              <!--<div class="panel panel-default">-->
              <!--  <div class="row">-->
              <!--    <div class="col-md-12">-->
              <!--        <div class="outer-sec-sync">-->
              <!--            <div class="head-sec">-->
              <!--              <div class="col-md-5">-->
              <!--                <h4>Sync DGO</h4>-->
              <!--              </div>-->
              <!--              <div class="col-md-4">-->
              <!--                  <h4>Last Synced At</h4>-->
              <!--              </div>-->
                        
              <!--            </div>-->
              <!--            <div class="content-sec">-->
              <!--              <div class="row border-sec">-->
              <!--                <div class="col-md-5">-->
              <!--                  DGO-->
              <!--                  <i class="fas fa-info-circle tool-sec-tip" rel="tooltip" title="Sync DGO. A base table"></i>-->
              <!--                </div>-->
              <!--                <div class="col-md-4 dgo-backup">-->
              <!--                  @if(isset($dgo->updated_at)){{date("D,d M Y H:i:s",strtotime($dgo->updated_at)) }}@endif-->
              <!--                </div>-->
              <!--                <div class="col-md-2">-->
              <!--                        <span id="error_message" class="text-danger"></span>  -->
              <!--                        <span id="success_message14" class="text-success"></span> -->
              <!--                      </div>-->
              <!--                <div class="col-md-1 syn-icon">-->
              <!--                  <a href="javascript:void(0)"><i class="fas fa-sync-alt" id="dgo"></i><span id="loadDgo" style="display:none; width:10px; height:20px"><img id="load-img" src="{{url('images/Spinner-1s-61px.gif')}}" alt="loading" /></span></a>-->
              <!--                </div>-->
              <!--              </div>-->
              <!--            </div>-->
              <!--          </div>-->
              <!--      </div>-->
              <!--  </div>-->
              <!--</div>-->

<!-- /*******************************  Sync All **************************************** */ -->
<!--<div class="panel panel-default">-->
<!--                <div class="row">-->
<!--                  <div class="col-md-12">-->
<!--                      <div class="outer-sec-sync">-->
<!--                          <div class="head-sec">-->
<!--                            <div class="col-md-5">-->
<!--                              <h4>Sync All</h4>-->
<!--                            </div>-->
<!--                            <div class="col-md-4">-->
<!--                                <h4>Last Synced At</h4>-->
<!--                            </div>-->
                        
<!--                          </div>-->
<!--                          <div class="content-sec">-->
<!--                            <div class="row border-sec">-->
<!--                              <div class="col-md-5">-->
<!--                                Sync all tables-->
<!--                                <i class="fas fa-info-circle tool-sec-tip" rel="tooltip" title="Sync all the tables in one click"></i>-->
<!--                              </div>-->
<!--                              <div class="col-md-4 all-backup">-->
<!--                                @if(isset($discounts->backupdate) && !empty($discounts->backupdate)){{date("D,d M Y H:i:s",strtotime($discounts->backupdate))}}-->
<!--                                @else-->
<!--                                    {{date("D,d M Y H:i:s",strtotime($discSync->updated_at))}}-->
<!--                                @endif-->
<!--                              </div>-->
<!--                              <div class="col-md-2">-->
<!--                                      <span id="error_message" class="text-danger"></span>  -->
<!--                                      <span id="success_message15" class="text-success"></span> -->
<!--                                    </div>-->
<!--                              <div class="col-md-1 syn-icon">-->
<!--                                <a href="javascript:void(0)"><i class="fas fa-sync-alt" id="syncall" ></i><span id="loadAll" style="display:none; width:10px; height:20px"><img id="load-img" src="{{url('images/Spinner-1s-61px.gif')}}" alt="loading" /></span></a>-->
<!--                              </div>-->
<!--                            </div>-->
<!--                          </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--              </div>-->
      </div>
  </div>
</div>


@endsection
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous" ></script>
<script type="text/javascript">
   $(document).ready(function() {
     
        $('#resident').click(function () {
          swal({
                  title: "Are you sure to sync?",
                  text: "Make sure the existence of the base table and it is synced. If it exists !",
                  icon: "warning",
                  buttons: [
                    'No, cancel it',
                    'Yes, I am sure'
                  ],
                  dangerMode: true,
                }).then(function(isConfirm) {
                  if (isConfirm) {
                   
                     $('#resident').hide();
                      $('#loaderRs').show();
                        $.ajax({
                        url:"{{route('static-residential')}}",
                        type:'get',
                        cache:false,
                        success: function(response) {
                            $('#loaderRs').hide();
                            $('#resident').show();
                            $('#success_message2').fadeIn().html("Synced");
                              setTimeout(function(){  
                                $('#success_message2').fadeOut("Slow");  
                              }, 2000);
                            $('.res-backup').html(response);
                            console.log(response) ;
                        },
                        error: function(xhr, status, error){
                            swal({
                              title: 'Something Went Wrong',
                              text: 'An Error Occurred',
                              icon: 'error'
                            }).then(function() {
                                $('#loaderRs').hide();
                                $('#resident').show();
                            });
                          }
                        
                        });
                    
                  } else {
                    swal("Cancelled", "Your data has been synced", "error");
                  }
                });
          
        });

        $('#static').click(function () {
          swal({
                  title: "Proceed Syncing?",
                  text: "Sync the Static Data here (Suppliers, DGO, Residential and Professional Tables, Electricity and Gas, and Packs)",
                  icon: "warning",
                  buttons: [
                    'Cancel',
                    'Proceed'
                  ],
                  dangerMode: true,
                }).then(function(isConfirm) {
                  if (isConfirm) {
                    
                      $('#static').hide();
                      $('#loaderS').show();
                        $.ajax({
                        url:"{{route('static-sync')}}",
                        type:'get',
                        cache:false,
                        success: function(response) {
                          $('#loaderS').hide();
                          $('#static').show();
                          $('#success_message1').fadeIn().html("Synced");
                          $('#g_success_message1').fadeIn().html("Sync completed");
                              setTimeout(function(){  
                                $('#success_message1').fadeOut("Slow");  
                              }, 2000);
                              $('.allstat-backup').html(response);
                            console.log(response) ;
                        },
                        error: function(xhr, status, error){
                            swal({
                              title: 'Something Went Wrong',
                              text: 'An Error Occurred',
                              icon: 'error'
                            }).then(function() {
                                $('#loaderS').hide();
                                $('#static').show();
                            });
                          }
                        });
                   
                  } else {
                    swal("Cancelled", "Your data has been synced", "error");
                  }
                });
          
        });

        $('#profession').click(function () {
          swal({
                  title: "Are you sure to sync?",
                  text: "Make sure the existence of the base table and it is synced. If it exists !",
                  icon: "warning",
                  buttons: [
                    'No, cancel it',
                    'Yes, I am sure'
                  ],
                  dangerMode: true,
                }).then(function(isConfirm) {
                  if (isConfirm) {
                   
                      $('#profession').hide();
                      $('#loaderProS').show();
                        $.ajax({
                          url:"{{route('static-professional')}}",
                          type:'get',
                          cache:false,
                          success: function(response) {
                            $('#loaderProS').hide();
                            $('#profession').show();
                            $('#success_message3').fadeIn().html("Synced");
                              setTimeout(function(){  
                                $('#success_message3').fadeOut("Slow");  
                              }, 2000);
                              $('.pro-backup').html(response);
                            console.log(response) ;
                        },
                        error: function(xhr, status, error){
                            swal({
                              title: 'Something Went Wrong',
                              text: 'An Error Occurred',
                              icon: 'error'
                            }).then(function() {
                                $('#loaderProS').hide();
                                $('#profession').show();
                            });
                          }
                        });
                   
                  } else {
                    swal("Cancelled", "Your data has been synced", "error");
                  }
                });
          
        });
        $('#packs').click(function () {
          swal({
                  title: "Are you sure to sync?",
                  text: "Make sure the existence of the base table and it is synced. If it exists !",
                  icon: "warning",
                  buttons: [
                    'No, cancel it',
                    'Yes, I am sure'
                  ],
                  dangerMode: true,
                }).then(function(isConfirm) {
                  if (isConfirm) {
                    
                      $('#packs').hide();
                      $('#loaderPack').show();
                        $.ajax({
                        url:"{{route('sync-packs')}}",
                        type:'get',
                        cache:false,
                        success: function(response) {
                            $('#loaderPack').hide();
                            $('#packs').show();
                            $('#success_message4').fadeIn().html("Synced");
                              setTimeout(function(){  
                                $('#success_message4').fadeOut("Slow");  
                              }, 2000);
                              $('.pack-backup').html(response);
                            console.log(response) ;
                            
                        },
                        error: function(xhr, status, error){
                            swal({
                              title: 'Something Went Wrong',
                              text: 'An Error Occurred',
                              icon: 'error'
                            }).then(function() {
                                $('#loaderPack').hide();
                                $('#packs').show();
                            });
                          }
                        });
                    
                  } else {
                    swal("Cancelled", "Your data has been synced", "error");
                  }
                });
          
        });
        $('#dynamicdetails').click(function () {
          swal({
                  title: "Proceed Syncing?",
                  text: "Sync the Dynamic data here (Gas, Electricity). Make sure to sync the Static Data first.",
                  icon: "warning",
                  buttons: [
                    'Cancel',
                    'Proceed'
                  ],
                  dangerMode: true,
                }).then(function(isConfirm) {
                  if (isConfirm) {
                    
                      $('#dynamicdetails').hide();
                      $('#loaderAllD').show();
                        $.ajax({
                        url:"{{route('sync-dynamicData')}}",
                        type:'get',
                        cache:false,
                        success: function(response) {
                            $('#loaderAllD').hide();
                            $('#dynamicdetails').show();
                            $('#success_message6').fadeIn().html("Synced");
                            $('#g_success_message6').fadeIn().html("Sync completed");
                              setTimeout(function(){  
                                $('#success_message6').fadeOut("Slow");  
                              }, 2000);
                              $('.alldyn-backup').html(response);
                            console.log(response) ;
                        },
                        error: function(xhr, status, error){
                            swal({
                              title: 'Something Went Wrong',
                              text: 'An Error Occurred',
                              icon: 'error'
                            }).then(function() {
                                $('#loaderAllD').hide();
                                $('#dynamicdetails').show();
                            });
                          }
                        });
                   
                  } else {
                    swal("Cancelled", "Your data has been synced", "error");
                  }
                });
          
        });
        $('#postcode').click(function () {
          swal({
                  title: "Proceed Syncing?",
                  text: "Sync the Postal codes here.",
                  icon: "warning",
                  buttons: [
                    'Cancel',
                    'Proceed'
                  ],
                  dangerMode: true,
                }).then(function(isConfirm) {
                  if (isConfirm) {
                    
                        $('#postcode').hide();
                        $('#loaderPost').show();
                          $.ajax({
                          url:"{{route('sync-postalcodes')}}",
                          type:'get',
                          cache:false,
                          success: function(response) {
                              $('#loaderPost').hide();
                              $('#postcode').show();
                              $('#success_message5').fadeIn().html("Synced");
                              $('#g_success_message5').fadeIn().html("Sync completed");
                                setTimeout(function(){  
                                  $('#success_message5').fadeOut("Slow");  
                                }, 2000);
                                $('.post-backup').html(response);
                              console.log(response) ;
                          },
                          error: function(xhr, status, error){
                            swal({
                              title: 'Something Went Wrong',
                              text: 'An Error Occurred',
                              icon: 'error'
                            }).then(function() {
                                $('#loaderPost').hide();
                                $('#postcode').show();
                            });
                          }
                          });
                    
                  } else {
                    swal("Cancelled", "Your data has been synced", "error");
                  }
                });
          
        });
        $('#netelectricity').click(function () {
          swal({
                  title: "Proceed Syncing?",
                  text: "Sync the Netcost Electricity Data here",
                  icon: "warning",
                  buttons: [
                    'No, cancel it',
                    'Yes, I am sure'
                  ],
                  dangerMode: true,
                }).then(function(isConfirm) {
                  if (isConfirm) {
                    
                      $('#netelectricity').hide();
                      $('#loaderNe').show();
                        $.ajax({
                        url:"{{route('sync-netcostE')}}",
                        type:'get',
                        cache:false,
                        success: function(response) {
                            $('#loaderNe').hide();
                            $('#netelectricity').show();
                            $('#success_message10').fadeIn().html("Synced");
                            $('#g_success_message10').fadeIn().html("Sync completed");
                              setTimeout(function(){  
                                $('#success_message10').fadeOut("Slow");  
                              }, 2000);
                              $('.nete-backup').html(response);
                            console.log(response) ;    
                        },
                          error: function(xhr, status, error){
                            swal({
                              title: 'Something Went Wrong',
                              text: 'An Error Occurred',
                              icon: 'error'
                            }).then(function() {
                                $('#loaderNe').hide();
                                $('#netelectricity').show();
                            });
                          }
                        });
                   
                  } else {
                    swal("Cancelled", "Your data has been synced", "error");
                  }
                });
        });
        $('#dynamicresident').click(function () {
          swal({
                  title: "Are you sure to sync?",
                  text: "Make sure the existence of the base table and it is synced. If it exists !",
                  icon: "warning",
                  buttons: [
                    'No, cancel it',
                    'Yes, I am sure'
                  ],
                  dangerMode: true,
                }).then(function(isConfirm) {
                  if (isConfirm) {
                    
                      $('#dynamicresident').hide();
                      $('#loaderRd').show();
                        $.ajax({
                        url:"{{route('sync-dynResident')}}",
                        type:'get',
                        cache:false,
                        success: function(response) {
                          $('#loaderRd').hide();
                          $('#dynamicresident').show();
                          $('#success_message7').fadeIn().html("Synced");
                              setTimeout(function(){  
                                $('#success_message7').fadeOut("Slow");  
                              }, 2000);
                              $('.dyn-resbackup').html(response);
                            console.log(response) ;
                        },
                          error: function(xhr, status, error){
                            swal({
                              title: 'Something Went Wrong',
                              text: 'An Error Occurred',
                              icon: 'error'
                            }).then(function() {
                                $('#loaderRd').hide();
                                $('#dynamicresident').show();
                            });
                          }
                        });
                    
                  } else {
                    swal("Cancelled", "Your data has been synced", "error");
                  }
                });
          
        }); 
        $('#dynamicprofession').click(function () {
          swal({
                  title: "Are you sure to sync?",
                  text: "Make sure the existence of the base table and it is synced. If it exists !",
                  icon: "warning",
                  buttons: [
                    'No, cancel it',
                    'Yes, I am sure'
                  ],
                  dangerMode: true,
                }).then(function(isConfirm) {
                  if (isConfirm) {
                    
                      $('#dynamicprofession').hide();
                      $('#loaderPd').show();
                        $.ajax({
                        url:"{{route('sync-dynProfession')}}",
                        type:'get',
                        cache:false,
                        success: function(response) {
                          $('#loaderPd').hide();
                          $('#dynamicprofession').show();
                          $('#success_message8').fadeIn().html("Synced");
                              setTimeout(function(){  
                                $('#success_message8').fadeOut("Slow");  
                              }, 2000);
                              $('.dyn-probackup').html(response);
                            console.log(response) ;
                          },
                          error: function(xhr, status, error){
                            swal({
                              title: 'Something Went Wrong',
                              text: 'An Error Occurred',
                              icon: 'error'
                            }).then(function() {
                                $('#loaderPd').hide();
                                $('#dynamicprofession').show();
                            });
                          }
                      });
                    
                  } else {
                    swal("Cancelled", "Your data has been synced", "error");
                  }
                });
          
        });
        $('#tax').click(function () {
          swal({
                  title: "Proceed Syncing?",
                  text: "Sync tax data here",
                  icon: "warning",
                  buttons: [
                    'No, cancel it',
                    'Yes, I am sure'
                  ],
                  dangerMode: true,
                }).then(function(isConfirm) {
                  if (isConfirm) {
                    
                      $('#tax').hide();
                      $('#loaderT').show();
                        $.ajax({
                        url:"{{route('sync-tax')}}",
                        type:'get',
                        cache:false,
                        success: function(response) {
                          $('#loaderT').hide();
                          $('#tax').show();
                          $('#success_message9').fadeIn().html("Synced");
                          $('#g_success_message9').fadeIn().html("Sync completed");
                              setTimeout(function(){  
                                $('#success_message9').fadeOut("Slow");  
                              }, 2000);
                              $('.tax-backup').html(response);
                          console.log(response) ;
                            
                        },
                          error: function(xhr, status, error){
                            swal({
                              title: 'Something Went Wrong',
                              text: 'An Error Occurred',
                              icon: 'error'
                            }).then(function() {
                                $('#loaderT').hide();
                                $('#tax').show();
                            });
                          }
                        });
                    
                  } else {
                    swal("Cancelled", "Your data has been synced", "error");
                  }
                });
          
        });
        $('#netgas').click(function () {
          swal({
                  title: "Proceed Syncing?",
                  text: "Sync the Netcost Gas here",
                  icon: "warning",
                  buttons: [
                    'No, cancel it',
                    'Yes, I am sure'
                  ],
                  dangerMode: true,
                }).then(function(isConfirm) {
                  if (isConfirm) {
                   
                      $('#netgas').hide();
                      $('#loaderNg').show();
                      $.ajax({
                      url:"{{route('sync-netcostG')}}",
                      type:'get',
                      cache:false,
                      success: function(response) {
                        $('#loaderNg').hide();
                        $('#netgas').show();
                        $('#success_message11').fadeIn().html("Synced");
                        $('#g_success_message11').fadeIn().html("Sync completed");
                            setTimeout(function(){  
                              $('#success_message11').fadeOut("Slow");  
                            }, 2000);
                            $('.netg-backup').html(response);
                          console.log(response) ;
                      },
                        error: function(xhr, status, error){
                          swal({
                            title: 'Something Went Wrong',
                            text: 'An Error Occurred',
                            icon: 'error'
                          }).then(function() {
                              $('#loaderNg').hide();
                              $('#netgas').show();
                          });
                        }
                      
                      });
                    
                  } else {
                    swal("Cancelled", "Your data has been synced", "error");
                  }
                });
        });
        $('#discounts').click(function () {
          swal({
                  title: "Proceed Syncing? ",
                  text: "Sync the Discounts here, but make sure to sync the Suppliers first (Static Data)",
                  icon: "warning",
                  buttons: [
                    'Cancel',
                    'Proceed'
                  ],
                  dangerMode: true,
                }).then(function(isConfirm) {
                  if (isConfirm) {
                   
                      $('#discounts').hide();
                      $('#loaderDisc').show();
                        $.ajax({
                        url:"{{route('sync-discounts')}}",
                        type:'get',
                        cache:false,
                        success: function(response) {
                          $('#loaderDisc').hide();
                          $('#discounts').show();
                          $('#success_message12').fadeIn().html("Synced");
                          $('#g_success_message12').fadeIn().html("Sync completed");
                              setTimeout(function(){  
                                $('#success_message12').fadeOut("Slow");  
                              }, 2000);
                              $('.disc-backup').html(response);
                            console.log(response) ;
                        },
                        error: function(xhr, status, error){
                          swal({
                            title: 'Something Went Wrong',
                            text: 'An Error Occurred',
                            icon: 'error'
                          }).then(function() {
                              $('#loaderDisc').hide();
                              $('#discounts').show();
                          });
                        }
                        });
                   
                  } else {
                    swal("Cancelled", "Your data has been synced", "error");
                  }
                });
        });         

        $('#supplier').click(function () {
          swal({
                  title: "Are you sure to sync?",
                  text: "Make sure the existence of the base table and it is synced. If it exists !",
                  icon: "warning",
                  buttons: [
                    'No, cancel it',
                    'Yes, I am sure'
                  ],
                  dangerMode: true,
                }).then(function(isConfirm) {
                  if (isConfirm) {
                    
                      $('#supplier').hide();
                      $('#loaderSupply').show();
                        $.ajax({
                        url:"{{route('sync-supplier')}}",
                        type:'get',
                        cache:false,
                        success: function(response) {
                          $('#loaderSupply').hide();
                          $('#supplier').show();
                          $('#success_message13').fadeIn().html("Synced");
                              setTimeout(function(){  
                                $('#success_message13').fadeOut("Slow");  
                              }, 2000);
                              $('.supply-backup').html(response);
                            console.log(response) ;
                        },
                        error: function(xhr, status, error){
                          swal({
                            title: 'Something Went Wrong',
                            text: 'An Error Occurred',
                            icon: 'error'
                          }).then(function() {
                              $('#loaderSupply').hide();
                              $('#supplier').show();
                          });
                        }
                        });
                    
                  } else {
                    swal("Cancelled", "Your data has been synced", "error");
                  }
                });
        });

        // $('#dgo').click(function () {
        //   $('#dgo').hide();
        //   $('#loadDgo').show();
        //     $.ajax({
        //      url:"{{route('sync-dgo')}}",
        //      type:'get',
        //      cache:false,
        //      success: function(response) {
        //       $('#loadDgo').hide();
        //       $('#dgo').show();
        //       $('#success_message14').fadeIn().html("Synced");
        //           setTimeout(function() {  
        //             $('#success_message14').fadeOut("Slow");  
        //           }, 2000);
        //         console.log(response) ;
        //       }
        //     });
        // });
        
           $('#estimate').click(function () {
          swal({
                  title: "Are you sure to sync?",
                  text: "All the Estimate consumption data will sync here !",
                  icon: "warning",
                  buttons: [
                    'No, cancel it!',
                    'Yes, I am sure!'
                  ],
                  dangerMode: true,
                }).then(function(isConfirm) {
                  if (isConfirm) {
                   
                      $('#estimate').hide();
                      $('#loaderesti').show();
                        $.ajax({
                        url:"{{route('estimate-consumption')}}",
                        type:'get',
                        cache:false,
                        success: function(response) {
                          $('#loaderesti').hide();
                          $('#estimate').show();
                          $('#success_message16').fadeIn().html("Synced");
                              setTimeout(function(){  
                                $('#success_message1').fadeOut("Slow");  
                              }, 2000);
                              $('.allstat-backup').html(response);
                            console.log(response) ;
                        },
                        error: function(xhr, status, error){
                            swal({
                              title: 'Something Went Wrong!',
                              text: 'An Error Occurred!',
                              icon: 'error'
                            }).then(function() {
                                $('#loaderS').hide();
                                $('#static').show();
                            });
                          }
                        });
                   
                  } else {
                    swal("Cancelled", "Your Data is not synced :)", "error");
                  }
                });
          
        });


      $('#dgo').click(function () {
          
          swal({
                  title: "Are you sure to sync?",
                  text: "Make sure the existence of the base table and it is synced. If it exists !",
                  icon: "warning",
                  buttons: [
                    'No, cancel it',
                    'Yes, I am sure'
                  ],
                  dangerMode: true,
                }).then(function(isConfirm) {
                  if (isConfirm) {
                    
                      $('#dgo').hide();
                      $('#loadDgo').show();
                        $.ajax({
                        url:"{{route('sync-dgo')}}",
                        type:'get',
                        cache:false,
                        success: function(response) {
                          $('#loadDgo').hide();
                          $('#dgo').show();
                          $('#success_message14').fadeIn().html("Synced");
                              setTimeout(function() {  
                                $('#success_message14').fadeOut("Slow");  
                              }, 2000);
                              $('.dgo-backup').html(response);
                            console.log(response) ;
                          },
                        error: function(xhr, status, error){
                          swal({
                            title: 'Something Went Wrong',
                            text: 'An Error Occurred',
                            icon: 'error'
                          }).then(function() {
                              $('#loadDgo').hide();
                              $('#dgo').show();
                          });
                        }
                        });
                   
                  } else {
                    swal("Cancelled", "Your data has been synced", "error");
                  }
                });
        
        
             });
             /******************sync all *****************/
      $('#syncall').click(function () {
            swal("Sync all tables excluding PostalCode?", {
                  title: 'Are you sure to Sync',
                  icon: "warning",
                  buttons: {
                    catch: {
                      text: "Include PostalCode!",
                      value: "catch",
                    },
                    cancel: "No, cancel it",
                    Yes: true,
                  },
                })
                .then((value) => {
                  switch (value) {
                
                    case "Yes":
                      swal("Sync in progress", "Sync Except Postal code!", "success");
                      $('#syncall').hide();
                      $('#loadAll').show();
                        $.ajax({
                        url:"{{route('sync-exceptpostal')}}",
                        type:'get',
                        cache:false,
                        success: function(response) {
                          $('#loadAll').hide();
                          $('#syncall').show();
                          $('#success_message15').fadeIn().html("Synced");
                              setTimeout(function() {  
                                $('#success_message15').fadeOut("Slow");  
                              }, 2000);
                              $('.all-backup').html(response);
                            console.log(response) ;
                          },
                        error: function(xhr, status, error){
                          swal({
                            title: 'Something Went Wrong',
                            text: 'An Error Occurred',
                            icon: 'error'
                          }).then(function() {
                              $('#loadAll').hide();
                              $('#syncall').show();
                          });
                        }
                        });
                      break;
                
                    case "catch":
                      swal("Sync in progress", "Postal code has been added", "success");
                      $('#syncall').hide();
                      $('#loadAll').show();
                        $.ajax({
                        url:"{{route('sync-all')}}",
                        type:'get',
                        cache:false,
                        success: function(response) {
                          $('#loadAll').hide();
                          $('#syncall').show();
                          $('#success_message15').fadeIn().html("Synced");
                              setTimeout(function() {  
                                $('#success_message15').fadeOut("Slow");  
                              }, 2000);
                              $('.all-backup').html(response);
                            console.log(response) ;
                          },
                        error: function(xhr, status, error){
                          swal({
                            title: 'Something Went Wrong',
                            text: 'An Error Occurred',
                            icon: 'error'
                          }).then(function() {
                              $('#loadAll').hide();
                              $('#syncall').show();
                          });
                        }
                        });
                      break;
                
                    default:
                      swal("Cancelled Your Data  has been synced", "error");
                  }
                });
        
             });
   });


  $(document).ready(function(){
      $("[rel=tooltip]").tooltip({ placement: 'top'});
  });
   
</script>
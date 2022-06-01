@extends('layouts.app')

@section('content')
<div class="container-sec">
    <div class="row">
        <div class="col-md-3">
         @include('includes.sidebar')
        </div>
        
        <div class="col-md-9">
        <div class="panel panel-default">
        
       <!--  <div class="row">
          <div class="col-md-12"> -->

            
            <div class="border-sec">
              <div class="outer-sec">
                <div class="table_sec">
                  <select id="table">
                  <option selected>Table</option>
                  <option value="1">Dynamic-electric-professionals</option>
                  <option value="2">Dynamic-electric-residentials</option>
                  <option value="3">Dynamic-gas-professionals</option>
                  <option value="4">Dynamic-gas-residentials</option>
                       
                  <option value="11">Netcoste</option>
                  <option value="12">Netcostg</option>
                  <option value="13">Tax-electricities</option>
                  <option value="14">Tax-gas</option>
                  <option value="15">Suppliers</option>
                  <option value="16">Discount</option>
                  
                  <option value="5">Static-electric-residentials</option>
                  <option value="6">Static-elec-professionals</option>
                  <option value="7">Static-gas-professionals</option>
                  <option value="8">Static-gas-residentials</option>
                  <option value="9">Static-pack-professionals</option>
                  <option value="10">Static-pack-residentials</option>
                  <option value="17">Postalcode-dgo-electricities</option>
                  <option value="18">Postalcode-dgo-gases</option>
                  </select>
                </div>
                  <div class="bacup_date_sec">
                    <select id="backup-date">
                  <option value="" selected>Select Backup dates</option>            
                  </select>
                  </div>
                  <div class="button-sec">
                    <button id="backup">Download Table</button>
                    <a href="{{route('backup.index')}}">Restore all</a>
                  </div>
                   <div class="button-sec">
                    <img style="display:none;" id="loading" width="200px" src="{{url('images/loading.gif')}}">
                  </div>

                </div>

              </div>
            
          </div>
        </div>
<!--     </div>
    
    
</div> -->


                    <!-- <form class="m-form" method="POST" action="" enctype="multipart/form-data">
                    {{ csrf_field() }}
                                

                                    <div class="form-group row {{ $errors->has('backupdate') ? ' has-danger' : '' }}">
                                        <label for="backup" class="col-3 col-form-label">
                                            Backup Date
                                        </label>
                                        <div class="col-8">
                                            <select class="form-control m-input m-input--solid" id="packageType"
                                                    name="backupdate"
                                                    required="required">
                                                <option>--select--</option>
                                                @foreach($discount as $value )
                                                    <option value="{{$value->backupdate}}">{{$value->backupdate}}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('backupdate'))
                                                <span id="first_name-error"
                                                    class="form-control-feedback">{{ $errors->first('backupdate') }}</span>
                                            @endif
                                        </div>
                                 </div>
                    </form>        -->


@endsection

<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
<script type="text/javascript">
   

   jQuery(document).ready(function(){

     $('#table').change(function(e){
       e.preventDefault();
          

     $('#backup-date').empty();
    
      jQuery.ajax({
                  url: "{{ url('get-backupdate') }}",
                  method: 'get',
                  data: {
                     table_id: jQuery('#table').val()                    
                  },
                  success: function(result){

                    $.each(result, function(key, value) {   
                      $('#backup-date')
                        .append($("<option></option>")
                        .attr("value",value.backupdate)
                        .text(value.backupdate)); 
                    });
                     console.log(result);
                  }
                  
                  });      
  

    });

    
    $('#backup').click(function(){

      var table=$('#table').val();
      var backupdate=$('#backup-date').val();
      if (table != "" && backupdate != "") {
        var origin   = window.location.origin;
    
        var url =origin+'/'+'sync-backup?table='+table+'&backupdate='+backupdate;
        window.open(url);
      } else {
        swal({
              title: 'Choose a Table',
              text: 'Something Went Wrong',
              icon: 'warning'
            })
      }

    });

   });

</script>
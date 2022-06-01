@extends('layouts.app')

@section('content')
<div class="container-sec">
  <div class="row">
    <div class="col-md-3">
      @include('includes.sidebar')
    </div>

    <div class="col-md-9">
      <div class="row">
        <div class="col-md-5 col-md-offset-7">
          <div class="button-sec">
            <button id="backupall" href="{{route('backup.full')}}" class="btn btn-primary" id="backup">Backup All tables <i style="display: none" class="fa fa-spinner fa-spin"></i> </button>
          </div>
        </div>
      </div>

      <div class="panel panel-default">

        <div class="row">
          <div class="col-md-12">
            <div class="outer-sec-sync">
              <div class="heading-sec">
                <h4> All Tables in one Backup</h4>
              </div>
              <div class="content-sec">
              @php $activeID  = $activeRestore ? $activeRestore->id : 0; @endphp
                @if (isset($backupdate))
                   
                @foreach ($backupdate as $backup)

                <form action="{{ route('restore-all') }}" method="post">
                  {{ csrf_field() }}

                  <div class="row border-sec row-{{$backup->id}} ">
                    <div class="col-md-7">
                      <input type="hidden" name="id" value="{{$backup->id}}">

                      Back up on {{$backup ? date("D, d M Y H:i:s",strtotime($backup->backupdate)) : ''}}
                    </div>
                    <div class="col-md-2">
                      <span id="success_message" class="text-success">
                      @if($activeID == $backup->id) {{ intVal($backup->counter*100/19) }} % completed @endif
                      </span>
                    </div>
                    <div class="col-md-3 syn-icon">
                      <button class="btn-submit btn btn-primary" type="button" value="Restore" data-value="{{$backup->id}}"><span>@if($activeID == $backup->id) Continue Restore @else Restore  @endif </span><i style="display: none" class="fa fa-spinner fa-spin"></i> </button>
                    </div>
                  </div>

                </form>

                @endforeach

                @endif
              </div>
            </div>
          </div>
        </div>
      </div>


    </div>


    @endsection
    @push('scripts')
    <script type="text/javascript">
      jQuery(document).ready(function() {
        

        $(document).on('click', '#backupall', function(e) {
          e.preventDefault();
          var $spinner = $(this).find('i'); // $('i',$(this));
          var url = $(this).attr('href');
          $spinner.show();
          $.get(url, function(res){
            $spinner.hide();
            swal("Backup Completed", {
                  title: 'Sucessfull',
                  icon: "success",
                  buttons: {
                    //cancel: "No, cancel it!!",
                    Yes: true,
                  },
                }).then((value) => {
                  location.reload();
                });

          
          }).fail(function() {
            $spinner.hide();
          });

        });

        $(document).on('click', '.btn-submit', function(e) {
          e.preventDefault();
         
          var $button = $(this);
          var $repater = $button.closest('.border-sec');
          var backupId = $button.data('value');
          var $spinner = $button.find('i'); // $('i',$button);
          $spinner.show();

          $('.text-success').html('');
          $('.btn-submit span').html('Restore');
          $('.btn-submit').attr('disabled', true);

          $.post('{{ route("restore-all") }}', {
            id: backupId
          }, function(sucesss) {
            $spinner.hide();
            $('.btn-submit').attr('disabled', false);
            $('.text-success', $repater).fadeIn().html("Restored");
            setTimeout(function() {
              $('.text-success', $repater).fadeOut("Slow");
            }, 2000);
          }, 'json').fail(function() {
            // alert('error');
            swal({
              title: 'Something Went Wrong',
              text: 'An Error Occurred',
              icon: 'error'
            })
            $('.btn-submit').attr('disabled', false);
            $button.find('span').html('Continue Restore');
            $spinner.hide();

          });

        });

        @if($activeRestore && $activeRestore-> counter > 1)
        $('.btn-submit').attr('disabled', false);
        @endif




        setInterval(function() {
          $.get('{{route("restore.progress")}}', function(res) {
            if(res.id && res.progress!=100){
              $('.text-success', $('.row-'+res.id)).html(res.progress+" % completed");
            }
            console.log(res);
          },'json');
        }, 20000);


      });
    </script>
    @endpush
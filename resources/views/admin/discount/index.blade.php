@extends('layouts.app')
<!-- <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet"> -->
@section('content')
<div class="container-sec">
    <div class="row">
        <div class="col-md-3">
            @include('includes.sidebar')
        </div>
        <div class="col-md-9">
           
            @if (count($discount) > 0)
            <table class="table table-hover" id="users-table">
                <thead class="list-head">
                    <tr>
                         <th></th>
                        <th>Id</th>
                        
                        <th>StartDate</th>
                        <th>EndDate</th>
                        <th>CustomerGroup</th>
                        <th>NameNl</th>
                        <th>ProductId</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i=1; @endphp
                    @foreach($discount as $discounts)
                    
                   
                    <tr>
                        <td> {{$i++}} </td>
                        @if(isset($discounts['fields']['Id']))<td> {{$discounts['fields']['Id']}} </td>@endif
                        
                        
                        <td> {{$discounts['fields']['StartDate']}} </td>
                        <td> {{$discounts['fields']['EndDate']}} </td>
                        <td> {{$discounts['fields']['CustomerGroup']}} </td>
                        <td> {{$discounts['fields']['NameNl']}} </td>
                        <td> {{$discounts['fields']['ProductId']}} </td>
                        <td> <a href="{{route('discount.edit',['id'=>$discounts['id']])}}"><i class="fa fa-eye" rel="tooltip" title="duplicate"></i></a>
                            
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="paginate"> </div>
            @else

            <div class="alert alert-warning">
                <strong>Sorry!</strong> No User Data Found.
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script type="text/javascript">
    // $(document).ready(function() {
    //     $('#users-table').DataTable({
    //         // processing: true,
    //         serverSide: true,
    //         ajax: {
    //         url: '{{url('usersearch/data')}}',
    //         type: 'GET',
    //         dataFilter: function(data) {
    //             var json = jQuery.parseJSON( data );
    //             json.recordsTotal = json.total;
    //             json.recordsFiltered = json.total;
    //             json.data = json.list;

    //             return JSON.stringify( json ); // return JSON string
    //         }
    //     }
    // ajax: '{!! route('usersearch.data') !!}',
    // columns: [
    //     { data: 'id', name: 'id' },
    //     { data: 'uuid', name: 'uuid' },
    //     { data: 'firstname', name: 'firstname' },
    //     { data: 'lastname', name: 'lastname' },
    //     { data: 'postalcode', name: 'postalcode' },
    //     { data: 'region', name: 'region' }
    // ]

    // });
    // });
</script>
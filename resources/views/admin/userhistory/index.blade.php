@extends('layouts.app')
<!-- <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet"> -->
@section('content')
<div class="container-sec">
    <div class="row">
        <div class="col-md-3">
            @include('includes.sidebar')
        </div>
        <div class="col-md-9">
            <div class="row" style="padding:24px 0">
                <form action="{{route('usersearch.index')}}" method="GET">
                    <div class="col-md-12">
                        <input type="text" name="keyword" value="{{request()->get('keyword', '')}}" placeholder="Keyword search">
                        <select name="type">
                            <option value="">Select a contact type</option>
                            <option value="customer">Customer</option>
                            <option value="hot prospect">Hot Prospect</option>
                        </select>
                        
                        <button class="btn btn-primary" id="find" type="submit">Filter result</button>
                    </div>

                </form>
            </div>
            @if (count($usersearch) > 0)
            <table class="table table-hover" id="users-table">
                <thead class="list-head">
                    <tr>
                        <th>Sl no</th>
                        <th>UUID</th>
                        <th>Firstname</th>
                        <th>Lastname</th>
                        <th>PostalCode</th>
                        <th>Region</th>
                        <th>Contact Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usersearch as $user)
                    <tr>
                        <td> {{$number++}} </td>
                        <td> {{$user->uuid}} </td>
                        <td> {{$user->firstname}} </td>
                        <td> {{$user->lastname}} </td>
                        <td> {{$user->postalcode}} </td>
                        <td> {{$user->region}} </td>
                        <td> {{$user->contact_type}} </td>
                        <td> <a href="{{route('usersearch.show',$user->id)}}"><i class="fa fa-eye" rel="tooltip" title="View user details"></i></a>
                            <a id="user-delete" onclick="return confirm('Are you sure to delete?')" href="{{route('usersearch.delete',$user->id)}}" style="padding: 5px ;"><i class="fa fa-trash" rel="tooltip" title="Delete user details"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="paginate">{{ $usersearch->links() }} </div>
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
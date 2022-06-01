@extends('layouts.app')

@section('content')
<div class="container-sec">
    <div class="row">
        <div class="col-md-3">
         @include('includes.sidebar')
        </div>
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                         <h5> {{ Auth::user()->name }} ,You are logged in!</h5>
                    <!--You are logged in!-->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <h3 class="text-center mt-5">List of users</h3>
            @if(count($users) > 0)
            @foreach($users as $user)
            <div class="card">
                <div class="card-header">{{$user->name}}</div>
                <div class="card-body">{{$user->email}}</div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</div>
@endsection

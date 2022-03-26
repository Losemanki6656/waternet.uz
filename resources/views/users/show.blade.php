@extends('layouts.master')


@section('content')

<div class="card-body position-relative">
    <div class="row flex-between-end">
        <div class="col-auto align-self-center">
            <h5> Show User</h5>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Name:</strong>
            {{ $user->name }}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Email:</strong>
            {{ $user->email }}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Roles:</strong>
            @if(!empty($user->getRoleNames()))
                @foreach($user->getRoleNames() as $v)
                    <label class="badge bg-success">{{ $v }}</label>
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection
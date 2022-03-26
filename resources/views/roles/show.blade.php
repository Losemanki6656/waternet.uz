@extends('layouts.master')


@section('content')

<div class="card-body position-relative">
    <div class="row flex-between-end">
        <div class="col-auto align-self-center">
            <h5>Show Role</h5>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <label>Name:</label>
            <span class="badge bg-warning">  {{ $role->name }}</span>
            
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <label>Permissions:</label>
            @if(!empty($rolePermissions))

                @foreach($rolePermissions as $v)
                    <label class="badge bg-secondary">{{ $v->name }}</label>
                @endforeach

            @endif
        </div>
    </div>
</div>
@endsection
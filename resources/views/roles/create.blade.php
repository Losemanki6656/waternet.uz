@extends('layouts.master')


@section('content')


<div class="card-body position-relative">
    <div class="row flex-between-end">
        <div class="col-auto align-self-center">
            <h5>Create New Role</h5>
        </div>
    </div>
</div>


@if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif


{!! Form::open(array('route' => 'roles.store','method'=>'POST')) !!}

<div class="row flex-between-end">
    <div class="container">
        <div class="col-3">
            <div class="mb-3">
                <label for="lastname"> Name: </label> {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
            </div>
            <div class="mb-3">
                <label for="lastname"> Permission: </label>
                <br/>
                @foreach($permission as $value)
                    <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                    {{ $value->name }}</label>
                <br/>
                @endforeach
            </div>
            <div class="mb-3">
                <a href="{{ route('roles.index') }}" class="btn btn-secondary" type="button">Back </a>  
                <button type="submit" class="btn btn-success">Submit</button>       
            </div>
        </div>
    </div>
</div>

{!! Form::close() !!}


@endsection
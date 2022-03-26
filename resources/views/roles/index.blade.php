@extends('layouts.master')


@section('content')

<div class="card-body position-relative">
    <div class="row flex-between-end">
    <div class="col-auto align-self-center">
        <h5>Role Management </h5>
    </div>
    <div class="col-auto align-self-center">
        @can('role-create')
            <a href="{{ route('roles.create') }}" class="btn btn-info me-1 mb-1" type="button">
                <span class="fas fa-plus me-1" data-fa-transform="shrink-3"></span>Create New Role
            </a>
        @endcan
    </div>
    </div>
</div>



@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
@endif

<div class="card mb-3">
    <div class="card-header border-bottom">
        <div class="row flex-between-end">
        <div class="col-auto align-self-center">
            <select class="form-select form-select-sm">
                <option value="1">10</option>
                <option value="2">50</option>
                <option value="3">100</option>
            </select>
        </div>
        <div class="col-auto align-self-center">
            <input class="form-control search-input fuzzy-search" type="search" placeholder="Search..." aria-label="Search" />
        </div>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive scrollbar">
        <table class="table mb-0 fs--1 border-200 table-borderless">
            <thead class="bg-light">
            <tr class="text-800 bg-200">
                <th class="text-nowrap" width="180">No</th>
                <th class="text-center text-nowrap">Name</th>
                <th class="text-center text-nowrap" width = "350px">Action</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($roles as $key => $role)
                    <tr class="border-bottom border-200">
                        
                        <td >
                            {{ ++$i }}
                        </td>
                        <td class="text-center">
                            {{ $role->name }}
                        </td>
                        </td>
                            <td class="text-center">

                                <a class="btn btn-outline-info me-1 mb-1" href="{{ route('roles.show',$role->id) }}">Show</a>
                                @can('role-edit')
                                    <a class="btn btn-outline-secondary me-1 mb-1" href="{{ route('roles.edit',$role->id) }}">Edit</a>
                                @endcan
                                @can('role-delete')
                                    {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
                                        {!! Form::submit('Delete', ['class' => 'btn btn-outline-danger me-1 mb-1']) !!}
                                    {!! Form::close() !!}
                                @endcan
                         </td>   
                    </tr>  
                @endforeach         
            </tbody>
        </table>
        </div>
    </div>
</div>

{!! $roles->render() !!}


@endsection
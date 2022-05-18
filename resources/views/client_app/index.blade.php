@extends('layouts.master')


@section('content')

<div class="container-fluid">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-8 col-sm-12">
                <h2>Tovarlar</h2>
            </div>            
            <div class="col-lg-7 col-md-4 col-sm-12 text-right">
                <ul class="breadcrumb justify-content-end">
                    <a href="{{ route('users_create') }}" class="btn btn-primary me-1 mb-1" type="button">
                        <span class="fa fa-plus me-1"></span> Add Photo
                    </a>
                </ul>
            </div>
        </div>
    </div>

<div class="card">
    <div class="card-body">
        
        <div class="table-responsive scrollbar">
        <table class="table mb-0 fs--1 border-200 table-borderless">
            <thead class="bg-light">
            <tr class="text-800 bg-200">
                <th class="text-nowrap" width="180">No</th>
                <th class="text-center text-nowrap">Name</th>
                <th class="text-center text-nowrap">Email </th>
                <th class="text-center text-nowrap">Roles</th>
                <th class="text-center text-nowrap">Action</th>
            </tr>
            </thead>
            <tbody>      
            </tbody>
        </table>
        </div>
    </div>
</div>



@endsection
@extends('layouts.masterfull')
@section('content')

    @if (\Session::has('msg'))  
        @if (Session::get('msg') == 1)
        <div class="alert alert-success" id="success-alert">A simple success alert—check it out!</div>
        @endif
    @endif

    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">City</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Home</a>
                            </li>
                            <li class="breadcrumb-item active">Cities
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-body">         
        <div class="card">
            <div class="card-header">
                <div class="col-md-3 col-6">
                    <fieldset>
                        <div class="input-group">
                            <input type="search" class="form-control" placeholder="Search ..." aria-label="Amount">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button"><i class="feather icon-search"></i></button>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="card-header-right">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addtask">
                        <i class="feather icon-plus-circle"></i> Region qo'shish
                    </button>
                    <!-- Modal -->
                    <div class="modal fade text-left" id="addtask" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-primary white">
                                    <h5 class="modal-title" id="myModalLabel160">Region</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{route('add_sity')}}" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <h6><label>Region nomi:</label></h6>
                                            <input class="form-control" type="text" name="name" placeholder="Region..." required>
                                        </div>   
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-primary" type="submit"> <i class="feather icon-save"></i> Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>            
                </div>
            </div>
        <div class="card-content">
            <div class="table-responsive mt-1">
                <table class="table table-hover-animation mb-0">
                    <thead class="bg-light">
                    <tr class="text-800 bg-200">
                        <th>Region</th>
                        <th>Mijozlar</th>
                        <th width = "270px" style="min-width: 270px">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($sities as $sity)
                            <tr>
                                <td>{{$sity->name}}</td>
                                <td>
                                    {{$sity->clients->count()}}
                                </td>
                                <td>
                                    <button type="button" class="btn btn-icon btn-flat-dark btn-sm" data-toggle="modal" title="Tahrirlash" data-target="#edmodal{{$sity->id}}">
                                        <i class="feather icon-edit"></i></button>                         
                                    <button type="button" class="btn btn-icon btn-flat-danger btn-sm" title="O'chirish" data-toggle="modal" data-target="#delmodal{{$sity->id}}">
                                        <i class="feather icon-trash"></i></button> 
                                </td>
                            </tr> 
                        @endforeach         
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>

@endsection

@push('scripts')
@endpush

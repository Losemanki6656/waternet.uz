@extends('layouts.master')
@section('content')

    @if (\Session::has('msg'))  
        @if (Session::get('msg') == 1)
        <div class="alert alert-success" id="success-alert">A simple success alert—check it out!</div>
        @endif
    @endif

    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-5 col-md-8 col-sm-12">
                    <h2>Region</h2>
                </div>            
                <div class="col-lg-7 col-md-4 col-sm-12 text-right">
                    <ul class="breadcrumb justify-content-end">
                        <li class="breadcrumb-item"><a href=""><i class="icon-home"></i></a></li>                            
                        <li class="breadcrumb-item active">Regionlar</li>
                    </ul>
                </div>
            </div>
        </div>
  
        <div class="card">   
        <ul class="nav nav-tabs">
            <li class="nav-item"><a class="nav-link" href="{{route('regions')}}"><i class="fa fa-home"></i> Regionlar</a></li>
            <li class="nav-item"><a class="nav-link active show" href="{{route('cities')}}"><i class="fa fa-user"></i> Shaxarlar</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane show active" id="Profile-withicon">
                <div class="header">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addcity">
                        <i class="fa fa-plus-circle"></i> Shahar qo'shish
                    </button>
    
                    <div class="modal fade" id="addcity" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="title" id="defaultModalLabel">Shaxar qo'shish</h4>
                                </div>
                                <form action="{{route('add_city')}}" method="post">
                                    @csrf
                                    <div class="modal-body"> 
                                        <div class="form-group">
                                            <h6><label>Regionni tanlang:</label></h6>
                                            <select class="form-control" name="sity_id">
                                                @foreach ($regions as $region)
                                                     <option value="{{$region->id}}">{{$region->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <h6><label>Shaxar nomi:</label></h6>
                                            <input class="form-control" type="text" name="area_name" required>
                                        </div>  
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal"> Chiqish</button>
                                        <button class="btn btn-primary" type="submit"> Saqlash</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div> 
                </div>      
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr class="text-800 bg-200">
                                <th width="60">ID</th>
                                <th>Region nomi</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($areas as $area)
                                    <tr>
                                        <td>{{$loop->index + 1}}</td>
                                        <td>
                                            {{$area->region->name}}
                                        </td>
                                        <td>
                                            {{$area->name}}
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#edit{{$area->id}}"><i class="fa fa-edit"></i> <span></span></button>
                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete{{$area->id}}"><i class="fa fa-trash-o"></i> <span></span></button>
                                        </td>
                                    </tr> 
                                    <div class="modal fade" id="edit{{$area->id}}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="title" id="defaultModalLabel">Taxrirlash</h4>
                                                </div>
                                                <form action="{{route('edit_city',['id' => $area->id ])}}" method="post">
                                                    @csrf
                                                    <div class="modal-body"> 
                                                        <div class="form-group">
                                                            <h6><label>Regionni tanlang:</label></h6>
                                                            <select class="form-control" name="sity_id">
                                                                @foreach ($regions as $region)
                                                                     <option value="{{$region->id}}">{{$region->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <h6><label>Shaxar nomi:</label></h6>
                                                            <input class="form-control" type="text" name="area_name" value="{{$area->name}}" required>
                                                        </div>  
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal"> Chiqish</button>
                                                        <button class="btn btn-primary" type="submit"> Taxrirlash</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="modal fade" id="delete{{$area->id}}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="title" id="defaultModalLabel">O'chirish</h4>
                                                </div>
                                                <form action="{{route('delete_city',['id' => $area->id ])}}" method="post">
                                                    @csrf
                                                    <div class="modal-body"> 
                                                        <div class="form-group">
                                                            <h6><label>{{$area->name}} shahrini o'chirishni xoxlaysizmi ?</label></h6>
                                                        </div>  
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal"> Chiqish</button>
                                                        <button class="btn btn-danger" type="submit"> Xa, O'chirish</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div> 
                                @endforeach         
                            </tbody>
                        </table>
                    </div>
                </div>     
            </div>
        </div>
        </div>

   
    </div>
@endsection

@push('scripts')
@endpush

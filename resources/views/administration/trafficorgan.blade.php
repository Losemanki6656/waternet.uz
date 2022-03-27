@extends('layouts.master')
@section('content')

<div class="container-fluid">

    <div class="block-header">
    </div>

    <div class="row clearfix">
        <div class="col-12">
            <div class="card top_report">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="body">
                            <div class="clearfix">
                                <div class="float-left">
                                    <i class="fa fa-2x fa-user text-col-green"></i>
                                </div>
                                <div class="number float-right text-right">
                                    <h6>Direktor ismi</h6>
                                    <span class="font700">{{$organization->director_name}}</span>
                                </div>
                            </div>
                            <div class="progress progress-xs progress-transparent custom-color-green mb-0 mt-3">
                                <div class="progress-bar" data-transitiongoal="28"></div>
                            </div>
                            <small class="text-muted">19% compared to last week</small>
                        </div>
                    </div>
                 
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="body">
                            <div class="clearfix">
                                <div class="float-left">
                                    <i class="fa fa-2x fa-phone text-col-red"></i>
                                </div>
                                <div class="number float-right text-right">
                                    <h6>Tel raqami</h6>
                                    <span class="font700">{{$organization->phone}}</span>
                                </div>
                            </div>
                            <div class="progress progress-xs progress-transparent custom-color-red mb-0 mt-3">
                                <div class="progress-bar" data-transitiongoal="41"></div>
                            </div>
                            <small class="text-muted">19% compared to last week</small>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="body">
                            <div class="clearfix">
                                <div class="float-left">
                                    <i class="fa fa-2x fa-thumbs-up text-col-yellow"></i>
                                </div>
                                <div class="number float-right text-right">
                                    <h6>Tarif nomi</h6>
                                    <span class="font700">{{$organization->traffic->name}}</span>
                                </div>
                            </div>
                            <div class="progress progress-xs progress-transparent custom-color-yellow mb-0 mt-3">
                                <div class="progress-bar" data-transitiongoal="75"></div>
                            </div>
                            <small class="text-muted">19% compared to last week</small>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="body">
                            <div class="clearfix">
                                <div class="float-left">
                                    <i class="fa fa-2x fa-dollar text-col-blue"></i>
                                </div>
                                <div class="number float-right text-right">
                                    <h6>Magazin balansi</h6>
                                    <span class="font700">{{$organization->balance}} so'm</span>
                                </div>
                            </div>
                            <div class="progress progress-xs progress-transparent custom-color-blue mb-0 mt-3">
                                <div class="progress-bar" data-transitiongoal="87"></div>
                            </div>
                            <small class="text-muted">19% compared to last week</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <div class="card">
            <div class="header">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addprice">
                    <i class="fa fa-plus-circle"></i> Tarif qo'shish
                </button>

                <div class="modal fade" id="addprice" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="title" id="defaultModalLabel">Tarifni qo'shish</h4>
                            </div>
                            <form action="{{route('add_traffic_organization',['id' => $organization->id])}}" method="post">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label style="margin-bottom: 0">Tariflar:</label>
                                        <select class="form-control" name="traffic_id" required>
                                            @foreach ($traffics as $item)
                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        </select>        
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col">
                                                <label style="margin-bottom: 0">Qachondan:</label>
                                                <input class="form-control" type="date" value="{{now()->format('Y-m-d')}}" name="date_from" required>
                                            </div>
                                            <div class="col">
                                                <label style="margin-bottom: 0">Qachongacha:</label>
                                                <input class="form-control" type="date" name="date_to" required>
                                            </div>
                                        </div>
                                       
                                    </div>
                                    <div class="form-group">
                                        <label style="margin-bottom: 0">Izoh:</label>
                                        <textarea class="form-control" type="text" name="comment"> </textarea>
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
                            <th>Tarif nomi</th>
                            <th>Qachondan</th>
                            <th>Qachongacha</th>
                            <th>Narxi</th>
                            <th>Izoh</th>
                            <th width = "130px">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($trafficorgan as $traffic)
                                <tr>
                                    
                                    <td>
                                        {{$traffic->traffic->name}}
                                    </td>
                                    <td>
                                        {{$traffic->date_from}}
                                    </td>
                                    <td>
                                        {{$traffic->date_to}}
                                    </td>
                                    <td>
                                        {{$traffic->price}}
                                    </td> 
                                    <td>
                                        {{$traffic->comment}}
                                    </td>
                                    <td>
                                        @if ($trafficorgan->count() == $loop->index + 1)
                                             <button type="button" class="btn btn-dark"><i class="fa fa-edit"></i> <span></span></button>
                                             <button type="button" class="btn btn-danger"><i class="fa fa-trash"></i> <span></span></button>
                                        @endif
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
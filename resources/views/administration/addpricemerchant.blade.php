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
                </div>
            </div>
        </div>
    </div>

        <div class="card">
            <div class="header">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addprice">
                    <i class="fa fa-plus-circle"></i> Balansni to'ldirish
                </button>

                <div class="modal fade" id="addprice" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="title" id="defaultModalLabel">Balansni to'ldirish</h4>
                            </div>
                            <form action="{{route('add_price_organization',['id' => $organization->id])}}" method="post">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label style="margin-bottom: 0">To'lov usuli:</label>
                                        <select class="form-control" name="payment" required>
                                            <option value="1">Naqd</option>
                                            <option value="2">Plastik</option>
                                            <option value="3">Pul ko'chirish</option>
                                        </select>        
                                    </div>
                                    <div class="form-group">
                                        <label style="margin-bottom: 0">Summa:</label>
                                        <input class="form-control" type="number" name="price" required>
                                    </div>

                                    <div class="form-group">
                                        <label style="margin-bottom: 0">Izoh:</label>
                                        <textarea class="form-control" type="text" name="comment" placeholder="Izoh..."> </textarea>
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
                            <th>Miqdori</th>
                            <th>To'lov usuli</th>
                            <th>Izoh</th>
                            <th>Vaqti</th>
                            <th width = "130px">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($priceorgan as $price)
                                <tr>
                                    
                                    <td>
                                        {{$price->price}}
                                    </td>
                                    <td>
                                        @if ($price->payment == 1)
                                            Naqd
                                        @elseif ($price->payment == 2)
                                            Plastik
                                        @else
                                            Pul ko'chirish
                                        @endif
                                    </td>
                                    <td>
                                        {{$price->comment}}
                                    </td>
                                    <td>
                                        {{$price->created_at}}
                                    </td>
                                    <td>
                                        @if ($priceorgan->count() == $loop->index + 1)
                                             <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#editprice{{$price->id}}"><i class="fa fa-edit"></i> <span></span></button>
                                             <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteprice{{$price->id}}"><i class="fa fa-trash"></i> <span></span></button>
                                        @endif
                                    </td>
                                    <div class="modal fade" id="editprice{{$price->id}}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="title" id="defaultModalLabel">Taxrirlash</h4>
                                                </div>
                                                <form action="{{route('edit_price_organization',['id' => $price->id])}}" method="post">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label style="margin-bottom: 0">To'lov usuli:</label>
                                                            <select class="form-control" name="payment" required>
                                                                <option value="1">Naqd</option>
                                                                <option value="2">Plastik</option>
                                                                <option value="3">Pul ko'chirish</option>
                                                            </select>        
                                                        </div>
                                                        <div class="form-group">
                                                            <label style="margin-bottom: 0">Summa:</label>
                                                            <input class="form-control" type="number" value="{{$price->price}}" name="price" required>
                                                        </div>
                    
                                                        <div class="form-group">
                                                            <label style="margin-bottom: 0">Izoh:</label>
                                                            <textarea class="form-control" type="text" value="{{$price->comment}}" name="comment"> </textarea>
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
                                    
                                    <div class="modal fade" id="deleteprice{{$price->id}}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="title" id="defaultModalLabel">O'chirish</h4>
                                                </div>
                                                <form action="{{route('delete_price_organization',['id' => $price->id])}}" method="post">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label style="margin-bottom: 0">O'chirishni xoxlaysizmi ?</label>
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
                                </tr> 
                            @endforeach         
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


</div>

@endsection
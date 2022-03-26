@extends('layouts.master')
@section('content')

<div class="container-fluid">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-8 col-sm-12">
                <h2>{{$client->fullname}}</h2>
            </div>            
            <div class="col-lg-7 col-md-4 col-sm-12 text-right">
                <ul class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href=""><i class="icon-home"></i></a></li>                            
                    <li class="breadcrumb-item active">Mijozlar</li>
                </ul>
            </div>
        </div>
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
                                    <h6>Mijoz balansi</h6>
                                    <span class="font700">{{$client->balance}} so'm</span>
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
                                    <i class="fa fa-2x fa-bar-chart-o text-col-green"></i>
                                </div>
                                <div class="number float-right text-right">
                                    <h6>Idish qarzi</h6>
                                    <span class="font700">{{$client->container}} ta</span>
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
                                    <i class="fa fa-2x fa-shopping-cart text-col-red"></i>
                                </div>
                                <div class="number float-right text-right">
                                    <h6>Zakazlar soni</h6>
                                    <span class="font700">{{$soldproducts->count()}} ta</span>
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
                                    <h6>Umumiy to'lovlar miqdori</h6>
                                    <span class="font700">{{$summ}} so'm</span>
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

    <div class="row clearfix">
        <div class="col-lg-6 col-md-12">
            <div class="card">
                <div class="header">
                   <h2> Pul tushumlari </h2>
                </div>
                <div class="body">
                    <div class="table-responsive mt-3">
                        <table class="table m-b-0 table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Miqdori</th>
                                    <th>To'lov usuli</th>
                                    <th>Kim oldi </th>
                                    <th>Izoh</th>
                                    <th>Olingan vaqt</th>
                                    <th width='100'>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                                @foreach ($clientprices as $prices)
                                    <tr>
                                        <td>{{ $loop->index + 1}}</td>
                                        <td>{{$prices->amount}}</td>
                                        <td>
                                            @if ($prices->payment == 1)
                                                Naqd
                                            @elseif ($prices->payment == 2)
                                                Plastik
                                            @else
                                                Pul ko'chirish
                                            @endif
                                        </td>
                                        <td>{{$prices->user->name}}</td>
                                        <td>{{$prices->comment}}</td>
                                        <td>{{$prices->created_at->format('Y-m-d')}}</td>
                                        <td>
                                            @if ($clientprices->count() == $loop->index + 1)
                                                <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#priceedit{{$prices->id}}"><i class="fa fa-edit" ></i> <span></span></button>
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#pricedelete{{$prices->id}}"><i class="fa fa-trash-o" ></i> <span></span></button>
                                            @endif
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="priceedit{{$prices->id}}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="title" id="defaultModalLabel">Taxrirlash</h4>
                                                </div>
                                                <form action="{{route('client_price_edit',['id' => $prices->id])}}" method="post">
                                                    @csrf
                                                    <div class="modal-body">
    
                                                        <div class="form-group">
                                                            <h6><label>To'lov ususli:</label></h6>
                                                            <select class="form-control" name="payment" id="tolov-usuli" >
                                                                <option value="1">Naqd</option>
                                                                <option value="2">Plastik</option>
                                                                <option value="3">Pul ko'chirish</option>
                                                            </select>
                                                        </div>
    
                                                        <div class="form-group">
                                                            <h6><label>Summa:</label></h6>
                                                            <input class="form-control" type="input" name="amount" value="{{$prices->amount}}" required>
                                                        </div>                                        
                                                        <div class="form-group">
                                                            <h6><label>Izoh:</label></h6>
                                                            <textarea class="form-control" name="comment" id="" rows="2" required>{{$prices->comment}}</textarea>
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
                                    <div class="modal fade" id="pricedelete{{$prices->id}}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="title" id="defaultModalLabel">O'chirish</h4>
                                                </div>
                                                <form action="{{route('client_price_delete',['id' => $prices->id])}}" method="post">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <h6><label>O'chirishni xoxlaysizmi ?</label></h6>
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
        <div class="col-lg-6 col-md-12">
            <div class="card">
                <div class="header">
                    <h2>Qaytargan idishlari</h2>
                </div>
                <div class="body">
                    <div class="table-responsive mt-3">
                        <table class="table m-b-0 table-bordered">
                            <thead>
                                <tr>
                                    <th>Tovar</th>
                                    <th>Soni</th>
                                    <th>Yaroqsiz</th>
                                    <th>Kim oldi</th>
                                    <th>Izoh</th>
                                    <th>Olingan vaqt</th>
                                    <th width='100'>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                                @foreach ($clientcontainer as $container)
                                    <tr>
                                        <td>{{$container->product->name}}</td>
                                        <td>{{$container->count}}</td>
                                        <td>{{$container->invalid_count}}</td>
                                        <td>{{$container->user->name}}</td>
                                        <td>{{$container->comment}}</td>
                                        <td>{{$container->created_at->format('Y-m-d')}}</td>
                                        <td>
                                            @if ($clientcontainer->count() == $loop->index + 1)
                                                <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#container_edit{{$container->id}}"><i class="fa fa-edit" ></i> <span></span></button>
                                                 <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#container_delete{{$container->id}}"><i class="fa fa-trash-o" ></i> <span></span></button>
                                            @endif
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="container_edit{{$container->id}}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="title" id="defaultModalLabel">Taxrirlash</h4>
                                                </div>
                                                <form action="{{route('client_container_edit',['id' => $container->id])}}" method="post">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <h6><label>Maxsulot:</label></h6>
                                                            <select class="form-control" name="product_id" id="tolov-usuli" required>
                                                                <option value="">Tanlanmadi</option>
                                                                @foreach ($products as $product)
                                                                     <option value="{{$product->id}}">{{$product->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
    
                                                        <div class="form-group">
                                                            <h6><label>Qaytargan soni:</label></h6>
                                                            <input class="form-control" type="number" name="count" value="{{$container->count}}" required>
                                                        </div>        
                                                        <div class="form-group">
                                                            <h6><label>Yaroqsiz idish soni:</label></h6>
                                                            <input class="form-control" type="number" name="invalid_count" value="{{$container->invalid_count}}" required>
                                                        </div>                                   
                                                        <div class="form-group">
                                                            <h6><label>Izoh:</label></h6>
                                                            <textarea class="form-control" name="comment" id="" rows="2">{{$container->comment}}</textarea>
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
                                    <div class="modal fade" id="container_delete{{$container->id}}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="title" id="defaultModalLabel">O'chirish</h4>
                                                </div>
                                                <form action="{{route('client_container_delete',['id' => $container->id])}}" method="post">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <h6><label>O'chirishni xoxlaysizmi ?</label></h6>
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


    <div class="card">
        <div class="body">
            <div class="table-responsive mt-3">
                <table class="table m-b-0 table-bordered">
                    <thead>
                        <tr>
                            <th>Maxsulot</th>
                            <th>Buyurtma miqdori</th>
                            <th>Narxi </th>
                            <th>Buyurtma vaqti</th>
                            <th>Olgan miqdori</th>
                            <th>Olgan narxi</th>
                            <th>Qaytargan idishlari</th>
                            <th>To'lov usuli</th>
                            <th>Umumiy summa</th>
                            <th>Yetkazildi izoh</th>
                            <th>Yetkazilgan vaqt</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                        @foreach ($soldproducts as $soldproduct)
                            @if ($soldproduct->order_status == 1 || $soldproduct->order_status == 2)
                                <tr>
                                    <td>{{$soldproduct->product->name}}</td>
                                    <td>{{$soldproduct->order_count}}</td>
                                    <td>{{$soldproduct->order_price}}</td>
                                    <td>{{$soldproduct->order_date}}</td>
                                    <td>{{$soldproduct->count}}</td>
                                    <td>{{$soldproduct->price}}</td>
                                    <td>{{$soldproduct->container}}</td>
                                    <td>
                                        @if ($soldproduct->payment == 1)
                                            Naqd
                                        @elseif ($soldproduct->payment == 2)
                                            Plastik
                                        @else
                                            Pul ko'chirish
                                        @endif
                                    </td>
                                    <td>{{$soldproduct->amount}}</td>
                                    <td>{{$soldproduct->comment}}</td>
                                    <td>{{$soldproduct->created_at}}</td>
                                </tr>      
                            @endif
                        @endforeach    
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')


@endsection
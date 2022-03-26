@extends('layouts.master')
@section('content')

<div class="container-fluid">

    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-8 col-sm-12">
                <h2>{{$order->client->fullname}}</h2>
            </div>            
            <div class="col-lg-7 col-md-4 col-sm-12 text-right">
                <ul class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href=""><i class="icon-home"></i></a></li>                            
                    <li class="breadcrumb-item active">Mijoz</li>
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
                                    <span class="font700">{{$order->client->balance}}</span>
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
                                    <span class="font700">{{$order->client->container}}</span>
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
                                    <h6>Zakaz soni</h6>
                                    <span class="font700">{{$order->product_count}}</span>
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
                                    <h6>Tovar narxi</h6>
                                    <span class="font700">{{$order->price}}</span>
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

    
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-8 col-md-12">
                <form action="{{route('success_order',['id' => $order->id])}}" method="post">
                    @csrf
                    <div class="card Sales_Overview">
                        <div class="header">
                            <h2>Tovar yetqazilganligini tasdiqlash:</h2>
                        </div>
                        <div class="body">
                                <div class="row clearfix">
                                    <div class="col-lg-3 col-md-6">
                                        <b>Tovar turi:</b>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" value="{{$order->product->name}}" disabled>
                                        </div>       
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="row">
                                            <div class="col">
                                                <div class="input-group mb-3">
                                                    <b>Sotilgan soni:</b>
                                                    <div class="input-group mb-3">
                                                        <input type="number" class="form-control" onchange="summa()" id="product_count" name="product_count" value="{{$order->product_count}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="input-group mb-3">
                                                    <b>Narxi:</b>
                                                    <div class="input-group mb-3">
                                                        <input type="number" class="form-control" onchange="summa()" id="price" name="price" value="{{$order->price}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <b>Zakaz holati:</b>
                                        <select class="form-control" name="order_status" id="order-stat">
                                            <option value="1">Yetqazildi</option>
                                            <option value="2">Olib ketildi</option>
                                            <option value="3">Bekor qilindi</option>
                                            <option value="4">Manzil topilmadi</option>
                                            <option value="5">Manzilda xech kim yo'q</option>
                                        </select>
                                    </div>
                                   
                                </div>   
                                <div class="row clearfix">
                                    @if ($order->container_status == 0)
                                    <div class="col-lg-6 col-md-6">
                                        <div class="row">
                                            <div class="col"> 
                                                <b>Qaytargan idishlari:</b>
                                                <div class="input-group mb-3">
                                                    <input type="number" class="form-control" name="container" value="0">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <b>Yaroqsiz idishlar:</b>
                                                <div class="input-group mb-3">
                                                    <input type="number" class="form-control" name="invalid_container_count" value="0">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                        <input type="hidden" class="form-control" name="container" value="0">
                                        <input type="hidden" class="form-control" name="invalid_container_count" value="0">
                                    @endif
                                    <div class="col-lg-6 col-md-6">
                                        <div class="row">
                                            <div class="col"> 
                                                <b id="amount">Bergan summasi: {{$order->price * $order->product_count}} dan</b>
                                                <div class="input-group mb-3">
                                                    <input type="number" class="form-control" id="take_amount" name="amount" value="0">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <b>To'lov usuli:</b>
                                                <select class="form-control" name="payment" onchange="onsel()" id="tolov-usuli" >
                                                    <option value="1">Naqd</option>
                                                    <option value="2">Plastik</option>
                                                    <option value="3">Pul ko'chirish</option>
                                                </select>
                                                
                                            </div>
                                        </div>
                                        
                                    </div>
                                   
                                 
                                
                                </div>   
                                <div class="row clearfix">
                                    <div class="col-lg-6 col-md-6">
                                        <b>Comment:</b>
                                            <div class="input-group mb-3">
                                                <textarea class="form-control" name="comment"></textarea>
                                            </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="input-group mb-3">
                                            <button class="btn btn-success" type="submit" style="margin-top: 23px"><i class="fa fa-save"></i> Saqlash</button>
                                        </div>                                    
                                    </div>
                                </div>                

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')

<script>
    function onsel(){
        if(document.getElementById("tolov-usuli").value == 3)
            {  
                var x = document.getElementById("price").value;
                var y = document.getElementById("product_count").value;
                var z = x * y;
                $("#take_amount").val(z);
                $("#take_amount").attr('readonly', true);
                
        } else {
            
                var x = document.getElementById("product_count").value;
                var y = document.getElementById("price").value;
                var z = x * y;
                $("#take_amount").val(0);
                $("#take_amount").attr('readonly', false);
        }
    }
</script>>

<script>
    function summa() {
        var x = document.getElementById("product_count").value;
        var y = document.getElementById("price").value;
        var z = x * y;
        document.getElementById("amount").innerHTML = "Bergan summasi:  " + z;
    }
</script>

@endsection
@extends('layouts.master')
@section('content')


<div class="container-fluid">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-8 col-sm-12">
                <h2>Tariflar</h2>
            </div>            
            <div class="col-lg-7 col-md-4 col-sm-12 text-right">
                <ul class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href=""><i class="icon-home"></i></a></li>                            
                    <li class="breadcrumb-item active">Tariflar</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        @foreach ($traffics as $traffic)
            <div class="col-lg-3 col-md-6"> 
                <div class="card w_social2 overflowhidden">
                        <div class="pw_img">
                            <div class="card pricing2">
                                <div class="body">
                                    <div class="pricing-plan">
                                        <img src="../assets/images/space-ship.png" alt="" class="pricing-img">
                                        <h2 class="pricing-header">{{$traffic->name}}</h2>
                                        <ul class="pricing-features">
                                            <li> {{$traffic->annotation}}</li>
                                            @if ($traffic->clients_count != 0)
                                                <li>Klient: {{$traffic->clients_count}} ta</li>
                                            @endif
                                            @if ($traffic->sms_count!=0)
                                                 <li>Sms: {{$traffic->sms_count}} ta</li>
                                            @endif
                                            @if ($traffic->products_count!=0)
                                                 <li>Tovar: {{$traffic->products_count}} ta</li>
                                            @endif
                                            @if ($traffic->users_count!=0)
                                                <li>Xodim: {{$traffic->users_count}} ta</li>
                                            @endif
                                          
                                        </ul>
                                        <span class="pricing-price"><sup>so'm</sup>{{$traffic->price}}<sub>/1 oyga</sub></span>
                                        <a href="javascript:void(0);" class="btn btn-outline-primary">Ulanish</a>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        @endforeach
    </div>
</div>


@endsection
@extends('layouts.master')
@section('content')

<div class="container-fluid">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-8 col-sm-12">
                <h2>Pul tushumlari</h2>
            </div>            
            <div class="col-lg-7 col-md-4 col-sm-12 text-right">
                <ul class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href=""><i class="icon-home"></i></a></li>                            
                    <li class="breadcrumb-item active">Umumiy</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="body">
            <div class="table-responsive mt-3">
                <table class="table m-b-0 table-bordered">
                    <thead>
                        <tr>
                            <th>Mijoz</th>
                            <th>Topshirdi</th>
                            <th>Maxsulot</th>
                            <th>Buyurtma miqdori</th>
                            <th>Olgan miqdori</th>
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
                                    <td>
                                        @if ($soldproduct->client)
                                        {{$soldproduct->client->fullname}}
                                    @else
                                    Mijoz topilmadi
                                    @endif</td>
                                    <td>{{$soldproduct->user->name}}</td>
                                    <td>{{$soldproduct->product->name}}</td>
                                    <td>{{$soldproduct->order_count}}</td>
                                    <td>{{$soldproduct->count}}</td>
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
    
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12">
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
                                    </tr>
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

@section('scripts')


@endsection
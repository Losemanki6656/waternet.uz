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
                            <th>#</th>
                            <th>Mijoz</th>
                            <th>Topshirdi</th>
                            <th>Maxsulot</th>
                            <th>Buyurtma miqdori</th>
                            <th>Olgan miqdori</th>
                            <th>To'lov usuli</th>
                            <th>Umumiy summa</th>
                            <th>Yetkazildi izoh</th>
                            <th>Yetkazilgan vaqt</th>
                            <th>Balans</th>
                            <th>Qarz</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                        @foreach ($soldproducts as $soldproduct)
                            @if ($soldproduct->order_status == 1 || $soldproduct->order_status == 2)
                                <tr>
                                    <td>{{$loop->index + 1}}</td>
                                    <td>{{$soldproduct->client->fullname}}</td>
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
                                    <td>{{$soldproduct->client_price}}</td>
                                    <td>{{$soldproduct->price_sold}}</td>
                                </tr>      
                            @endif
                        @endforeach    
                        <tr>
                            <td colspan="4">Jami</td>
                            <td>{{$soldproducts->sum('order_count')}}</td>
                            <td>{{$soldproducts->sum('count')}}</td>
                            <td></td>
                            <td>{{$soldproducts->sum('amount')}}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>{{$soldproducts->sum('price_sold')}}</td>
                        </tr>  
                    </tbody>
                </table>
            </div>
        </div>
    </div>
   
</div>
@endsection

@section('scripts')


@endsection
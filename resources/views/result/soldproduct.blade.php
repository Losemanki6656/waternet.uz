@extends('layouts.master')
@section('content')

<div class="container-fluid">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-8 col-sm-12">
                <h2>Yetqazilgan zakaslar</h2>
            </div>            
            <div class="col-lg-7 col-md-4 col-sm-12 text-right">
                <ul class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href=""><i class="icon-home"></i></a></li>                            
                    <li class="breadcrumb-item active">Zakaslar</li>
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
                            <th>Tel</th>
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
                                    <td>{{$loop->index + 1}}</td>
                                    <td>{{$soldproduct->fullname}}</td>
                                    <td>{{$soldproduct->phone}}</td>
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
                        <tr>
                            <td colspan="4">Jami</td>
                            <td>{{$soldproducts->sum('order_count')}}</td>
                            <td>{{$soldproducts->sum('order_price')}}</td>
                            <td></td>
                            <td>{{$soldproducts->sum('count')}}</td>
                            <td>{{$soldproducts->sum('price')}}</td>
                            <td>{{$soldproducts->sum('container')}}</td>
                            <td></td>
                            <td>{{$soldproducts->sum('amount')}}</td>
                            <td></td>
                            <td></td>
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
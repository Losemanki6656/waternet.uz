@extends('layouts.master')
@section('content')

<div class="container-fluid">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-8 col-sm-12">
                <h2>Zakazlar</h2>
            </div>            
            <div class="col-lg-7 col-md-4 col-sm-12 text-right">
                <ul class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href=""><i class="icon-home"></i></a></li>                            
                    <li class="breadcrumb-item active">Zakazlar</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="header">
        </div>

        <div class="body">
            <div class="table-responsive">
                <table class="table m-b-0 table-bordered">
                    <thead>
                        <tr>
                            <th width="60">#</th>
                            <th>FIO</th>
                            <th>Tel raqami</th>
                            <th>Manzil </th>
                            <th>Tovar nomi</th>
                            <th>Miqdori</th>
                            <th>Narxi</th>
                            <th>Vaqti</th>
                            <th>Izoh</th>
                            <th>Operator</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{(($orders->currentPage() * 10) - 10) + $loop->index + 1}}</td>
                            
                                    @if ($order->client)
                                        <td>{{$order->client->fullname}}</td>
                                        <td>{{$order->client->phone}}</td>
                                        <td>{{$order->client->city->name}}, {{$order->client->area->name}}, {{$order->client->address}}</td>
                                    @else
                                        <td colspan="3"> Mijoz topilmadi</td>
                                    @endif
                                <td>{{$order->product->name}}</td>
                                <td>{{$order->product_count}}</td>
                                <td>{{$order->price}}</td>
                                <td>{{$order->created_at}}</td>
                                <td>{{$order->comment}}</td>
                                <td>{{$order->user->name}}</td>
                            </tr> 
                        @endforeach    
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
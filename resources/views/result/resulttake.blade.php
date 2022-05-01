@extends('layouts.master')
@section('content')


    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-5 col-md-8 col-sm-12">
                    <h2>Tovar chiqarish</h2>
                </div>            
                <div class="col-lg-7 col-md-4 col-sm-12 text-right">
                    <ul class="breadcrumb justify-content-end">
                        <li class="breadcrumb-item"><a href=""><i class="icon-home"></i></a></li>                            
                        <li class="breadcrumb-item active">Tovar chiqarish</li>
                    </ul>
                </div>
            </div>
        </div>
  
        <div class="card">
            <div class="header">
            </div>      
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr class="text-800 bg-200">
                            <th>#</th>
                            <th>Kimga</th>
                            <th>Tovar nomi</th>
                            <th>Miqdori</th>
                            <th>Olgan vaqti</th>
                            <th>Kim berdi</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($takeproduct as $takeproduct)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>
                                        {{$takeproduct->received->name}}
                                    </td>
                                    <td>
                                        {{$takeproduct->product->name}}
                                    </td>
                                    <td>
                                        {{$takeproduct->product_count}}
                                    </td>                            
                                    <td>{{$takeproduct->created_at}}</td>
                                    
                                    <td>{{$takeproduct->sent->name}}</td>
                                </tr> 
                            @endforeach   
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>
                                        {{$takeproduct->received->name}}
                                    </td>
                                    <td>
                                        {{$takeproduct->product->name}}
                                    </td>
                                    <td>
                                        {{$takeproduct->product_count}}
                                    </td>                            
                                    <td>{{$takeproduct->created_at}}</td>
                                    
                                    <td>{{$takeproduct->sent->name}}</td>
                                </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>        

   
    </div>
@endsection

@push('scripts')
@endpush

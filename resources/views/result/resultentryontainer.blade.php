@extends('layouts.master')
@section('content')

    @if (\Session::has('msg'))  
        @if (Session::get('msg') == 1)
        <div class="alert alert-success" id="success-alert">A simple success alert—check it out!</div>
        @endif
    @endif

    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-5 col-md-8 col-sm-12">
                    <h2>Idish kiritish</h2>
                </div>            
                <div class="col-lg-7 col-md-4 col-sm-12 text-right">
                    <ul class="breadcrumb justify-content-end">
                        <li class="breadcrumb-item"><a href=""><i class="icon-home"></i></a></li>                            
                        <li class="breadcrumb-item active">Idish kiritish</li>
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
                            <th>Tovar nomi</th>
                            <th>Kimdan</th>
                            <th>Qancha</th>
                            <th>Qabul qildi</th>
                            <th>Qachon</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($entrycontainer as $entrycon)
                                <tr>                
                                    <td>
                                        {{$entrycon->product->name}}
                                    </td>
                                    <td>
                                        {{$entrycon->user->name}}
                                    </td>
                                    <td>
                                        {{$entrycon->product_count}}
                                    </td>                            
                                    <td>{{$entrycon->received->name}}</td>
                                    <td>{{$entrycon->created_at}}</td>
                                </tr> 
                            @endforeach         
                        </tbody>
                    </table>
                </div>
            </div>
        </div>         

   
    </div>
@endsection

@push('scripts')
@endpush
@extends('layouts.master')
@section('content')

    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-5 col-md-8 col-sm-12">
                    <h2>SmsManager</h2>
                </div>            
                <div class="col-lg-7 col-md-4 col-sm-12 text-right">
                    <ul class="breadcrumb justify-content-end">
                        <li class="breadcrumb-item"><a href=""><i class="icon-home"></i></a></li>                            
                        <li class="breadcrumb-item active">Yuborilgan smslar</li>
                    </ul>
                </div>
            </div>
        </div>
  
        <div class="card">   
            <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link" href="{{route('send_message')}}"><i class="fa fa-home"></i> Sms yuborish</a></li>
                <li class="nav-item"><a class="nav-link active show" href="{{route('success_message')}}"><i class="fa fa-user"></i> Yuborilgan smslar </a></li>
                <li class="nav-item"><a class="nav-link" href="{{route('sms_text')}}"><i class="fa fa-comment"></i> SmsText </a></li>
            </ul>
        <div class="tab-content">            
            <div class="tab-pane show active">
                
        <div class="card">
            <div class="header">
                <div class="row clearfix">
                    <div class="col-lg-3 col-md-6">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="icon-calendar"></i></span>
                            </div>
                            <input data-provide="datepicker" data-date-autoclose="true" value="{{now()->format('m/d/Y')}}" class="form-control">
                            <button class="btn btn-primary"><i class="fa fa-filter"></i></button>
                        </div>     
                    </div>
                </div>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width = "80">#</th>
                                <th>Kimga</th>
                                <th style="max-width: 400px">Sms</th>
                                <th>Kimdan</th>
                                <th>Qachon</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                            @foreach ($smsmanagers as $smsmanager)
                                <tr>
                                    <td>{{(($smsmanagers->currentPage() * 10) - 10) + $loop->index + 1}}</td>
                                    <td> @if ($smsmanager->client)
                                        {{$smsmanager->client->fullname}}
                                    @else
                                         Mijoz topilmadi
                                    @endif
                                        </td>
                                    <td>{{$smsmanager->sms_text}}</td>
                                    <td>{{$smsmanager->user->name}}</td>
                                    <td>{{$smsmanager->created_at->format('Y-m-d')}}</td>
                                </tr> 
                            @endforeach    
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content mt-3">             
                    <ul class="pagination mb-0">
                        {{ $smsmanagers->withQueryString()->links() }}
                    </ul> 
                </div>
            </div>
        </div>
            </div>

        </div>
    </div>

   
    </div>
@endsection

@push('scripts')
@endpush

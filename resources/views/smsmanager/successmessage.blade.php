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
                        <form action="{{route('success_message')}}" method="get">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-calendar"></i></span>
                                </div>
                                <input type="date" name="data" value="{{request('data')}}" class="form-control">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-filter"></i></button>
                            </div>   
                        </form>
                    </div>
                </div>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th width = "80">#</th>
                                <th width="200px" class="text-center">Kimga</th>
                                <th class="text-center" style="max-width: 300px">Sms</th>
                                <th width="200px">Kimdan</th>
                                <th width="200px">Qachon</th>
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

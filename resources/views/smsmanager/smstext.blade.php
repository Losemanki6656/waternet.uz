@extends('layouts.master')
@section('content')

    @if (\Session::has('msg'))  
        @if (Session::get('msg') == 1)
        <div class="alert alert-success" id="success-alert">Sms muvaffaqqiyatli yuborildi!</div>
        @endif
    @endif

    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-5 col-md-8 col-sm-12">
                    <h2>SmsManager</h2>
                </div>            
                <div class="col-lg-7 col-md-4 col-sm-12 text-right">
                    <ul class="breadcrumb justify-content-end">
                        <li class="breadcrumb-item"><a href=""><i class="icon-home"></i></a></li>                            
                        <li class="breadcrumb-item active">Sms yuborish</li>
                    </ul>
                </div>
            </div>
        </div>
  
        <div class="card">   
            <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link" href="{{route('send_message')}}"><i class="fa fa-home"></i> Sms yuborish</a></li>
                <li class="nav-item"><a class="nav-link" href="{{route('success_message')}}"><i class="fa fa-user"></i> Yuborilgan smslar </a></li>
                <li class="nav-item"><a class="nav-link active show" href="{{route('sms_text')}}"><i class="fa fa-comment"></i> SmsText </a></li>
            </ul>
            <div class="tab-content">            
                <div class="tab-pane show active">
                    <div class="card">
                    </div>
                </div>
            </div>
    </div>

   
    </div>
@endsection

@push('scripts')
@endpush

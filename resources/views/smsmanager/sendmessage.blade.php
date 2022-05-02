@extends('layouts.master')
@section('content')

    @if (\Session::has('msg'))  
        @if (Session::get('msg') >= 1)
            <div class="alert alert-success">Sms muvaffaqqiyatli yuborildi!</div>
        @else
            <div class="alert alert-danger">Sms uchun ajratilgan tarif limiti tugadi!</div>
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
                <li class="nav-item"><a class="nav-link active show" href="{{route('send_message')}}"><i class="fa fa-home"></i> Sms yuborish</a></li>
                <li class="nav-item"><a class="nav-link" href="{{route('success_message')}}"><i class="fa fa-user"></i> Yuborilgan smslar </a></li>
                <li class="nav-item"><a class="nav-link" href="{{route('sms_text')}}"><i class="fa fa-comment"></i> SmsText </a></li>
            </ul>
            <div class="tab-content">            
                <div class="tab-pane show active">
                    <div class="card">
                        <div class="header" style="padding-bottom: 0">
                            <div class="row clearfix">
                                <div class="col-lg-3 col-md-6">
                                    <div class="input-group mb-3">
                                        <select class="form-control show-tick select2" id="sity_select" name="city_id" data-placeholder="Regionni tanlang" required>
                                            <option value=""></option>
                                            @foreach ($sities as $sity)
                                                <option value={{$sity->id}} @if($sity->id == request('city_id')) selected @endif>{{$sity->name}}</option> 
                                            @endforeach
                                        </select>
                                    </div>     
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="input-group mb-3">
                                        <select class="form-control show-tick select2" id="area_select" name="area_id" data-placeholder="Adresni tanlang" required>
                                            <option value=""></option>
                                            @foreach ($areas as $area)
                                                <option value={{$area->id}} @if($area->id == request('area_id')) selected @endif >{{$area->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>    
                                </div>

                                @push('scripts')
                                    <script>
                                        $('#sity_select').change(function (e) {
                                            let city_id = $(this).val();
                                            let paginate = $('#select_paginate').val();
                                            let url = '{{ route('send_message') }}';
                                            window.location.href = `${url}?city_id=${city_id}&paginate=${paginate}`;
                                        })

                                        $('#area_select').change(function (e) {
                                            let area_id = $(this).val();
                                            let city_id = $('#sity_select').val();
                                            let paginate = $('#select_paginate').val();
                                            let url = '{{ route('send_message') }}';
                                            window.location.href = `${url}?city_id=${city_id}&area_id=${area_id}&paginate=${paginate}`;
                                        })
                                    </script>                       
                                @endpush

                                <div class="col-lg-3 col-md-6">
                                    <div class="input-group mb-3">
                                        <button class="btn btn-primary" data-toggle="modal" data-target="#sendsms-modal"><i class="fa fa-send"></i> <span> Xabar yuborish</span></button>
                                    </div>    
                                </div>
                                
                                <div class="modal fade" id="sendsms-modal" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="title" id="defaultModalLabel"> Sms Yuborish</h4>
                                            </div>
                                            <form>
                                                @csrf
                                                <div class="modal-body">
                                                    
                                                    <div class="form-group">
                                                        <label style="margin-bottom: 0">Sms Text:</label>
                                                        <textarea form="sendsms" class="form-control" type="text" name="text" placeholder="Sms..."> </textarea>
                                                    </div> 
                                                   
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"> Chiqish</button>
                                                    <button class="btn btn-primary" type="submit" value="Submit" form="sendsms"><i class="fa fa-send"></i> Yuborish</button>
                                                </div>
                                            </form>
                                        </div>
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
                                            <th>FIO</th>
                                            <th>Tel raqami</th>
                                            <th>Adres</th>
                                            <th>Balans</th>
                                            <th>Idish qarzi</th>
                                            <th>Operator</th>
                                            <th>Qo'shilgan vaqti</th>
                                            <th>Aktivligi</th>
                                            <th>
                                                <label class="fancy-checkbox">
                                                    <input class="select-all" type="checkbox" name="checkbox">
                                                    <span></span>
                                                </label>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <form id="sendsms" action="{{route('send_sms')}}" method="post">
                                            @csrf
                                            @foreach ($clients as $client)
                                                <tr>
                                                    <td>{{(($clients->currentPage() * 10) - 10) + $loop->index + 1}}</td>
                                                    <td>{{$client->fullname}}</td>
                                                    <td>{{$client->phone}}</td>
                                                    <td>{{$client->city->name}}, {{$client->area->name}}</td>
                                                    <td>{{$client->balance}}</td>
                                                    <td>{{$client->container}}</td>
                                                    <td>{{$client->user->name}}</td>
                                                    <td>{{$client->created_at->format('Y-m-d')}}</td>
                                                    <td><span class="badge badge-primary">{{$client->created_at->format('Y-m-d')}}</span></td>
                                                    <td style="width: 50px;">
                                                        <label class="fancy-checkbox">
                                                            <input class="checkbox-tick" type="checkbox" name="checkbox[{{$client->id}}]">
                                                            <span></span>
                                                        </label>
                                                    </td>
                                                </tr> 
                                            @endforeach 
                                        </form>   
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col d-flex justify-content mt-3">
                                    <h6 class="mt-2 mr-2">Show</h6>
                                    <select class="form-control" style="width: 80px" name="select_paginate" id="select_paginate">
                                        <option value="10" @if (request('paginate') == 10) selected @endif>10</option>
                                        <option value="50" @if (request('paginate') == 50) selected @endif>50</option>
                                        <option value="100" @if (request('paginate') == 100) selected @endif>100</option>
                                        <option value="{{$client_count}}" @if (request('paginate') == $client_count) selected @endif>All</option>
                                    </select> <h6 class="mt-2 ml-2">entries</h6>
                                </div>
                                <div class="col d-flex justify-content-end mt-3">
                                    {{ $clients->withQueryString()->links() }}
                                </div>
                                @push('scripts')
                                    <script>
                                        $('#select_paginate').change(function (e) {
                                            let area_id = $('#area_select').val();
                                            let city_id = $('#sity_select').val();
                                            let paginate = $(this).val();
                                            let url = '{{ route('send_message') }}';
                                            window.location.href = `${url}?city_id=${city_id}&area_id=${area_id}&paginate=${paginate}`;
                                        })
                                    </script>                       
                                @endpush
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

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
                            <th width = "80">#</th>
                            <th>Tovar nomi</th>
                            <th>Kimdan</th>
                            <th>Miqdori</th>
                            <th>Yaroqsiz</th>
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
                                        {{$entrycon->client->fullname}}
                                    </td>
                                    <td>
                                        {{$entrycon->container}}
                                    </td> 
                                    <td>
                                        {{$entrycon->invalid_container_count}}
                                    </td>                            
                                    <td>{{$entrycon->user->name}}</td>
                                    <td>{{$entrycon->created_at}}</td>
                                </tr> 
                            @endforeach   
                            <tr>                
                                <td colspan="3">
                                    Jami:
                                </td>
                                <td>
                                    {{$summ_con}}
                                </td> 
                                <td>
                                    {{$summ_con_in}}
                                </td>                            
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

@push('scripts')
@endpush

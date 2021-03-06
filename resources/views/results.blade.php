@extends('layouts.master')
@section('content')


    <div class="container-fluid">
       
        <div class="block-header">
            <div class="row">
                <div class="col-lg-5 col-md-8 col-sm-12">
                    <h2>Xisobotlar</h2>
                </div>            
                <div class="col-lg-7 col-md-4 col-sm-12 text-right">
                    <ul class="breadcrumb justify-content-end">
                        <li class="breadcrumb-item"><a href=""><i class="icon-home"></i></a></li>                            
                        <li class="breadcrumb-item active">Xisobotlar</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="body taskboard">
            <div class="dd" data-plugin="nestable">
                <ol class="dd-list">                 
                        <div class="dd-handle">
                             <ul class="list-unstyled team-info">
                                <li><a href="{{route('results')}}" class="btn btn-primary mr-3"><i class="fa fa-calendar"></i> Xisobot</a></li>
                                <li><button class="btn btn-warning mr-3"><i class="fa fa-money"></i> Tushum</button></li>
                                <li><button class="btn btn-dark mr-3"><i class="fa fa-users"></i> Xodimlar</button></li>
                                <li><a href="{{route('dolgs')}}" class="btn btn-danger mr-3"><i class="fa fa-info-circle"></i> Qarzdorlar</a></li>
                            </ul>
                        </div>
                    </li>
                </ol>
            </div>
        </div>
          
        

        <div class="card" style="margin-top: 20px">
            <div class="header" style="padding-bottom: 1">
                <form action="{{route('results')}}">
                    <div class="row">
                        <div class="col-lg-2 col-md-6">
                            <input type="date" 
                            @if (request('date1'))
                                value="{{request('date1')}}"
                            @else
                                value="{{now()->format('Y-m-d')}}"
                            @endif 
                             name="date1" class="form-control">
                        </div>
                        <div class="col-lg-2 col-md-6">
                            <input type="date" 
                            @if (request('date2'))
                                value="{{request('date2')}}"
                            @else
                                value="{{now()->format('Y-m-d')}}"
                            @endif 
                                name="date2" class="form-control">
                        </div>
                        <div class="col-lg-2 col-md-6">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-filter"></i> Filter</button>
                        </div>
                        <div class="col-lg-6 col-md-6 text-right">
                            <button type="button" onclick="ExportToExcel('xlsx')" class="btn btn-primary" ><i class="fa fa-file-excel-o"></i> Export</button>
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="body">
                <div class="table-responsive">
                    <table class="table mb-0 table-bordered" id="table">
                        <thead>
                            <tr>
                                <th>FIO</th>
                                <th>Roli</th>
                                <th>Zakas oldi</th>
                                <th>Tovar oldi</th>
                                <th>Tovar sotdi</th>
                                <th>Summa</th>
                                <th>Idish oldi</th>
                                <th>Idish qaytardi</th>
                                <th>Naqd pul</th>
                                <th>Plastik</th>
                                <th>Pul.k</th>
                                <th>Qarz</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $user)
                                <tr>
                                    <td style="font-weight: bold;">
                                        {{$user->name}}
                                    </td>
                                    <td style="font-weight: bold;">
                                        @if ($roles[$user->id] == 4)
                                            Director
                                        @endif
                                        @if ($roles[$user->id] == 2)
                                            Warehouse Manager
                                        @endif
                                        @if ($roles[$user->id] == 3)
                                            Driver
                                        @endif
                                        @if ($roles[$user->id] == 1)
                                            Operator
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{route('result_orders',['date1' => request('date1'),'date2' => request('date2'),'id' => $user->id ])}}">
                                            {{$order[$user->id]}}</a>
                                    </td>
                                    <td>
                                        <a href="{{route('result_take',['date1' => request('date1'),'date2' => request('date2'),'id' => $user->id])}}">{{$takeproduct[$user->id]}}</a>
                                    </td>
                                    <td>
                                        <a href="{{route('resultsold',['date1' => request('date1'),'date2' => request('date2'),'id' => $user->id])}}">{{$soldproducts[$user->id]}}</a>
                                    </td>
                                    <td>
                                        <a href="{{route('summresult',['date1' => request('date1'),'date2' => request('date2'),'id' => $user->id])}}">{{$soldsumm[$user->id]}}</a>
                                    </td>
                                    <td>
                                        <a href="{{route('resultentrycontainer',['date1' => request('date1'),'date2' => request('date2'),'id' => $user->id])}}">{{$entrycon[$user->id]}}</a>
                                    </td>
                                    <td>
                                        {{$takecon[$user->id]}}
                                    </td>
                                    <td>
                                        <a href="{{route('payment1',['date1' => request('date1'),'date2' => request('date2'),'id' => $user->id])}}">{{$payment1[$user->id]}}</a>
                                    </td>
                                    <td>
                                        <a href="{{route('payment2',['date1' => request('date1'),'date2' => request('date2'),'id' => $user->id])}}">{{$payment2[$user->id]}}</a>
                                    </td>
                                    <td>
                                        <a href="{{route('payment3',['date1' => request('date1'),'date2' => request('date2'),'id' => $user->id])}}">{{$payment3[$user->id]}}</a>
                                    </td>
                                    <td>
                                        <a href="{{route('dolgresult',['date1' => request('date1'),'date2' => request('date2'),'id' => $user->id])}}">{{$amount[$user->id]}}</a>
                                    </td>
                                </tr>  
                            @endforeach
                            <td colspan="2" class="text-center" style="font-weight: bold; text-align: right;"> Jami:</td>
                            <td style="font-weight: bold;">{{$summorder}}</td>
                            <td style="font-weight: bold;">{{$summtakeproduct}}</td>
                            <td style="font-weight: bold;">{{$summsoldproducts}}</td>
                            <td style="font-weight: bold;">{{$summsoldsumm}}</td>
                            <td style="font-weight: bold;">{{$summentrycon}}</td>
                            <td style="font-weight: bold;">{{$takesumm}}</td>
                            <td style="font-weight: bold;">{{$summpayment1}}</td>
                            <td style="font-weight: bold;">{{$summpayment2}}</td>
                            <td style="font-weight: bold;">{{$summpayment3}}</td>
                            <td style="font-weight: bold;">{{$dolgsumm}}</td>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content mt-3">             
                    <ul class="pagination mb-0">
                    </ul> 
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
<script>
    function ExportToExcel(type, fn, dl) {
       var elt = document.getElementById('table');
       var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
       return dl ?
         XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
         XLSX.writeFile(wb, fn || ('Results.' + (type || 'xlsx')));
    }
</script>
@endsection



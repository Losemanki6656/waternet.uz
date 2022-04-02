@extends('layouts.master')
@section('content')


    <div class="container-fluid">
       
        <div class="block-header">
            <div class="row">
                <div class="col-lg-5 col-md-8 col-sm-12">
                    <h2>Qarzdorlar</h2>
                </div>            
                <div class="col-lg-7 col-md-4 col-sm-12 text-right">
                    <ul class="breadcrumb justify-content-end">
                        <li class="breadcrumb-item"><a href=""><i class="icon-home"></i></a></li>                            
                        <li class="breadcrumb-item active">Qarzdorlar</li>
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
                <div class="row">
                    <div class="col-lg-2 col-md-6">
                    </div>
                    <div class="col-lg-2 col-md-6">
                    </div>
                    <div class="col-lg-2 col-md-6">
                    </div>
                    <div class="col-lg-6 col-md-6 text-right">
                        <button class="btn btn-primary"><i class="fa fa-file-excel-o"></i> Export</button>
                    </div>
                </div>    
            </div>
            <div class="body">
                <table class="table mb-0 table-bordered">
                    <thead>
                        <tr>
                            <th width="60">#</th>
                            <th class="text-center">FIO</th>
                            <th class="text-center">Tel raqami</th>
                            <th class="text-center">Addres</th>
                            <th class="text-center">Balans</th>
                            <th class="text-center">Idish qarzi</th>
                            <th class="text-center">Operator</th>
                            <th width="100">Aktivligi</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                        @foreach ($clients as $client)
                            <tr>
                                <td>{{(($clients->currentPage() * 10) - 10) + $loop->index + 1}}</td>
                                <td class="text-center">{{$client->fullname}}</td>
                                <td class="text-center">
                                    <h6>{{$client->phone}}</h6>
                                    <span class="text-muted">{{$client->phone2}}</span>
                                </td>
                                <td class="text-center">
                                    <h6 class="margin-0 text-center">
                                        @if ($client->street != ' ')
                                            {{$client->street}},
                                        @endif
                                        @if ($client->home_number != ' ')
                                            {{$client->home_number}},     
                                        @endif
                                        @if ($client->entrance != ' ')
                                            {{$client->entrance}},     
                                        @endif
                                        @if ($client->floor != ' ')
                                            {{$client->floor}},  
                                        @endif
                                        @if ($client->apartment_number != ' ')
                                            {{$client->apartment_number}} 
                                        @endif
                                    </h6>
                                    <h6 class="mb-0" style="font-size: 14px;">
                                        @if ($client->address != ' ')
                                            {{$client->address}}
                                        @endif
                                    </h6>
                                    <span class="text-muted">
                                        {{$client->city->name}}, 
                                        {{$client->area->name}}
                                    </span>
                                </td>
                                <td class="text-center">{{$client->balance}}</td>
                                <td class="text-center">{{$client->container}}</td>
                                <td class="text-center">{{$client->user->name}}</td>
                                <td class="text-center">
                                        @if ($client->updated_at->diffInDays() > 14)
                                            <div class="p-2 l-blush text-white" data-toggle="tooltip" data-placement="bottom" title="{{$client->updated_at->diffInDays() + 1}} kun davomida aktiv emas">{{$client->updated_at->format('d-m-Y')}}</div>
                                        @else 
                                            @if ($client->updated_at->diffInDays() >= 7 && $client->updated_at->diffInDays() <= 14)
                                                <div class="p-2 l-amber text-white" data-toggle="tooltip" data-placement="bottom" title="{{$client->updated_at->diffInDays() + 1}} kun davomida aktiv emas"> {{$client->updated_at->format('d-m-Y')}}</div>    
                                            @else
                                                <div class="p-2 l-green text-dark" data-toggle="tooltip" data-placement="bottom" title="{{$client->updated_at->diffInDays() + 1}} kun davomida aktiv emas">{{$client->updated_at->format('d-m-Y')}}</div>
                                            @endif        
                                        @endif

                                </td class="text-center">
                            </tr> 
                        @endforeach    
                    </tbody>
                </table>
                <div class="d-flex justify-content mt-3">             
                    <ul class="pagination mb-0">
                        {{ $clients->withQueryString()->links() }}
                    </ul> 
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

<script>
    // ---------horizontal-navbar-menu-----------
		var tabsNewAnim = $('#navbar-animmenu');
		var selectorNewAnim = $('#navbar-animmenu').find('li').length;
		//var selectorNewAnim = $(".tabs").find(".selector");
		var activeItemNewAnim = tabsNewAnim.find('.active');
		var activeWidthNewAnimWidth = activeItemNewAnim.innerWidth();
		var itemPosNewAnimLeft = activeItemNewAnim.position();
		$(".hori-selector").css({
			"left":itemPosNewAnimLeft.left + "px",
			"width": activeWidthNewAnimWidth + "px"
		});
		$("#navbar-animmenu").on("click","li",function(e){
			$('#navbar-animmenu ul li').removeClass("active");
			$(this).addClass('active');
			var activeWidthNewAnimWidth = $(this).innerWidth();
			var itemPosNewAnimLeft = $(this).position();
			$(".hori-selector").css({
				"left":itemPosNewAnimLeft.left + "px",
				"width": activeWidthNewAnimWidth + "px"
			});
		});
</script>
@endsection



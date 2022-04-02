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
                            <input data-provide="datepicker" data-date-autoclose="true" value="{{request('date1')}}" name="date1" class="form-control">
                        </div>
                        <div class="col-lg-2 col-md-6">
                            <input data-provide="datepicker" data-date-autoclose="true" value="{{request('date2')}}" name="date2" class="form-control">
                        </div>
                        <div class="col-lg-2 col-md-6">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-filter"></i> Filter</button>
                        </div>
                        <div class="col-lg-6 col-md-6 text-right">
                            <button class="btn btn-primary"><i class="fa fa-file-excel-o"></i> Export</button>
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="body">
                <div class="table-responsive">
                    <table class="table mb-0 table-bordered">
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
                                        <a href="{{route('result_orders')}}">{{$order[$user->id]}}</a>
                                    </td>
                                    <td>
                                        <a href="{{route('result_take')}}">{{$takeproduct[$user->id]}}</a>
                                    </td>
                                    <td>
                                        <a href="{{route('resultsold')}}">{{$soldproducts[$user->id]}}</a>
                                    </td>
                                    <td>
                                        <a href="{{route('summresult')}}">{{$soldsumm[$user->id]}}</a>
                                    </td>
                                    <td>
                                        <a href="{{route('resultentrycontainer')}}">{{$entrycon[$user->id]}}</a>
                                    </td>
                                    <td>
                                        0
                                    </td>
                                    <td>
                                        <a href="{{route('payment1')}}">{{$payment1[$user->id]}}</a>
                                    </td>
                                    <td>
                                        <a href="{{route('payment2')}}">{{$payment2[$user->id]}}</a>
                                    </td>
                                    <td>
                                        <a href="{{route('payment3')}}">{{$payment3[$user->id]}}</a>
                                    </td>
                                    <td>
                                        <a href="{{route('dolgresult')}}">{{$amount[$user->id]}}</a>
                                    </td>
                                </tr>  
                            @endforeach
                            <td colspan="2" class="text-center" style="font-weight: bold; text-align: right;"> Jami:</td>
                            <td style="font-weight: bold;">{{$summorder}}</td>
                            <td style="font-weight: bold;">{{$summtakeproduct}}</td>
                            <td style="font-weight: bold;">{{$summsoldproducts}}</td>
                            <td style="font-weight: bold;">{{$summsoldsumm}}</td>
                            <td style="font-weight: bold;">{{$summentrycon}}</td>
                            <td style="font-weight: bold;">0</td>
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
<script>
       function setlocation(event){ 
      event.preventDefault(); 
      var myWindow=window.open("{{route('location')}}", 'Select Client Location', 'width=auto,height=auto')
    }

      function setlocation1(event, l1, l2){ 
            event.preventDefault(); 
            var myWindow=window.open('set_location_edit.asp?lat='+l1+'&lng='+l2+'', 'Joylashuvni tanlash', 'width=800,height=500')
        }

    function dotReplace(event){
                event.taget.value=event.target.value.replaceAll(",", ".")
            }
</script>

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



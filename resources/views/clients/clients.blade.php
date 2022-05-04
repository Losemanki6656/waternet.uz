@extends('layouts.master')
@section('content')

    @if (\Session::has('msg'))  
        @if (Session::get('msg') == 'erorder')
            <div class="alert alert-danger" id="success-alert">Ushbu mijozga bunday maxsulotdan zakaz olingan!</div>
        @endif
        @if (Session::get('msg') == 'ertraf')
        <div class="alert alert-danger" id="success-alert">Mijozlar bo'yicha ajratilgan tarif limiti tugadi!</div>
    @endif
    @endif
    
    <div class="container-fluid">
       
        <div class="block-header">
            <div class="row">
                <div class="col-lg-5 col-md-8 col-sm-12">
                    <h2>Mijozlar</h2>
                </div>            
                <div class="col-lg-7 col-md-4 col-sm-12 text-right">
                    <a type="button" href="{{route('add_client_page')}}" class="btn btn-primary" ><i class="fa fa-plus"></i> <span> Mijoz qo'shish</span></a>
                </div>
            </div>
        </div>
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
                            <select class="form-control show-tick select2" id="area_select" name="area_id" data-placeholder="Shaharni tanlang" required>
                                <option value=""></option>
                                @foreach ($areas as $area)
                                    <option value={{$area->id}} @if($area->id == request('area_id')) selected @endif >{{$area->name}}</option>
                                @endforeach
                            </select>
                        </div>    
                    </div>
                    <div class="col-lg-3 col-md-6">
                    </div>
                    <div class="col-lg-3 col-md-6">        
                        <form action="{{route('clients')}}" method="get">
                            @csrf
                            <div class="input-group mb-3">
                                <input class="form-control" value="{{request()->query('search')}}" name="search" type="search" placeholder="Qidirish ..." aria-label="Search" />
                            </div>    
                         </form>
                    </div>
                </div>
            </div>

            @push('scripts')
                <script>
                    $('#sity_select').change(function (e) {
                        let city_id = $(this).val();
                        let url = '{{ route('clients') }}';
                        window.location.href = `${url}?city_id=${city_id}`;
                    })

                    $('#area_select').change(function (e) {
                        let area_id = $(this).val();
                        let city_id = $('#sity_select').val();
                        let url = '{{ route('clients') }}';
                        window.location.href = `${url}?city_id=${city_id}&area_id=${area_id}`;
                    })
                </script>                       
            @endpush

            <div class="body">
                <div class="table-responsive">
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
                                <th width="150">Action</th>
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
                                            @if ($client->city)
                                                {{$client->city->name}},
                                            @endif   
                                            @if ($client->area)
                                                {{$client->area->name}} 
                                            @endif
                                        </span>
                                    </td>
                                    <td class="text-center">{{$client->balance}}</td>
                                    <td class="text-center">{{$client->container}}</td>
                                    <td class="text-center">{{$client->user->name}}</td>
                                    <td class="text-center">
                                            @if ($client->updated_at->diffInDays() > 14)
                                                <div class="p-3 mb-2 bg-danger text-dark" data-toggle="tooltip" data-placement="bottom" title="{{$client->updated_at->diffInDays() + 1}} kun davomida aktiv emas">{{$client->updated_at->format('d-m-Y')}}</div>
                                            @else 
                                                @if ($client->updated_at->diffInDays() >= 7 && $client->updated_at->diffInDays() <= 14)
                                                    <div class="p-3 mb-2 bg-warning text-dark" data-toggle="tooltip" data-placement="bottom" title="{{$client->updated_at->diffInDays() + 1}} kun davomida aktiv emas"> {{$client->updated_at->format('d-m-Y')}}</div>    
                                                @else
                                                    <div class="p-3 mb-2 bg-success text-dark" data-toggle="tooltip" data-placement="bottom" title="{{$client->updated_at->diffInDays() + 1}} kun davomida aktiv emas">{{$client->updated_at->format('d-m-Y')}}</div>
                                                @endif        
                                            @endif

                                    </td class="text-center">
                                    <td class="text-center">
                                        @if ($client->location != '0')
                                            <a type="button" target="_blank" href="{{route('view_location',['id' => $client->id])}}" title="Lokatsiyasi" class="btn btn-warning" >
                                                <i class="fa fa-map-marker"></i> <span></span></a> 
                                        @else
                                            <button type="button" class="btn btn-outline-warning" title="Lokatsiyasi" disabled>
                                                <i class="fa fa-map-marker"></i> <span></span></button>
                                        @endif
                                            <button type="button" class="btn btn-danger" 
                                                data-target="#order{{$client->id}}" data-toggle="modal" data-placement="bottom" title="Zakas olish">
                                                <i class="fa fa-shopping-cart"></i> <span></span></button>

                                                <button type="button"  class="btn btn-success" 
                                                    data-toggle="modal" title="Pul qo'shish" data-target="#clietnprice{{$client->id}}">
                                                    <i class="fa fa-credit-card"></i> <span></span></button>

                                        <a href="" class="btn btn-primary" data-toggle="dropdown">
                                            <i class="fa  fa-sliders"></i>
                                        </a>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="javascript:void(0);"  style="color: rgb(255, 168, 7)" data-toggle="modal" data-target="#container{{$client->id}}"><i class="fa fa-download"></i> Idish qaytarish</a>
                                            <a class="dropdown-item" href="{{route('soldproducts',['id' => $client->id])}}" style="color: rgb(0,123,255)"><i class="fa fa-cube"></i> Xisobot</a>
                                            <a class="dropdown-item" href="javascript:void(0);"  data-toggle="modal" data-target="#edit{{$client->id}}"><i class="fa fa-edit"></i> Taxrirlash</a>
                                            <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#delclient{{$client->id}}" style="color: rgb(220,53,69)"><i class="fa fa-trash" ></i> O'chirish</a>
                                        </div>      
                                    </td>
                                </tr> 
                                <div class="modal fade" id="container{{$client->id}}" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="title" id="defaultModalLabel">Idish qaytarish</h4>
                                            </div>
                                            <form action="{{route('client_container',['id' => $client->id])}}" method="post">
                                                @csrf
                                                <div class="modal-body">

                                                    <div class="form-group">
                                                        <h6><label>Maxsulot:</label></h6>
                                                        <select class="form-control" name="product_id" id="tolov-usuli" required>
                                                            <option value="">Tanlanmadi</option>
                                                            @foreach ($products as $product)
                                                                 <option value="{{$product->id}}">{{$product->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <h6><label>Qaytargan soni:</label></h6>
                                                        <input class="form-control" type="number" name="count" value="0" required>
                                                    </div>        
                                                    <div class="form-group">
                                                        <h6><label>Yaroqsiz idish soni:</label></h6>
                                                        <input class="form-control" type="number" name="invalid_count" value="0" required>
                                                    </div>                                   
                                                    <div class="form-group">
                                                        <h6><label>Izoh:</label></h6>
                                                        <textarea class="form-control" name="comment" id="" rows="2"></textarea>
                                                    </div>  
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"> Chiqish</button>
                                                    <button class="btn btn-primary" type="submit"> Saqlash</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="order{{$client->id}}" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="title" id="defaultModalLabel">Zakaz olish</h4>
                                            </div>
                                            <form action="{{route('add_order',['id' => $client->id])}}" method="post">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <h6><label>Tovar nomi:</label></h6>
                                                        <select class="form-control show-tick select2" id="prod_sel{{$client->id}}"
                                                         name="product_id" onchange="onsel({{$client->id}})" required>
                                                            @foreach ($products as $product)
                                                                <option data-amount="{{$product->price}}" value={{$product->id}}>{{$product->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>  
                                                    <div class="form-group">
                                                        <h6><label>Narxi:</label></h6>
                                                        <input class="form-control" type="text" id="sena_product_order{{$client->id}}" name="sena" @if ($products->count())
                                                        value="{{$products[0]->price}}"
                                                        @endif  required>
                                                    </div> 
                                                    <div class="form-group">
                                                        <h6><label>Soni:</label></h6>
                                                        <input class="form-control" type="number" name="count" required>
                                                    </div>                                         
                                                    <div class="form-group">
                                                        <h6><label>Izoh:</label></h6>
                                                        <textarea class="form-control" name="izoh" id="" rows="2" ></textarea>
                                                    </div>  
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"> Chiqish</button>
                                                    <button class="btn btn-primary" type="submit"> Saqlash</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div> 

                                <div class="modal fade" id="clietnprice{{$client->id}}" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="title" id="defaultModalLabel">Pul qo'shish</h4>
                                            </div>
                                            <form action="{{route('client_price',['id' => $client->id])}}" method="post">
                                                @csrf
                                                <div class="modal-body">

                                                    <div class="form-group">
                                                        <h6><label>To'lov ususli:</label></h6>
                                                        <select class="form-control" name="payment" id="tolov-usuli" >
                                                            <option value="1">Naqd</option>
                                                            <option value="2">Plastik</option>
                                                            <option value="3">Pul ko'chirish</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <h6><label>Summa:</label></h6>
                                                        <input class="form-control" type="input" name="amount" placeholder="Summa ..." required>
                                                    </div>                                        
                                                    <div class="form-group">
                                                        <h6><label>Izoh:</label></h6>
                                                        <textarea class="form-control" name="comment" id="" rows="2"></textarea>
                                                    </div>  
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"> Chiqish</button>
                                                    <button class="btn btn-primary" type="submit"> Saqlash</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="edit{{$client->id}}" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="title" id="defaultModalLabel">Taxrirlash</h4>
                                            </div>
                                            <form action="{{route('client_edit',['id' => $client->id])}}" method="post">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label style="margin-bottom: 0">FIO:</label>
                                                        <input class="form-control" type="input" value="{{$client->fullname}}" name="fullname" required>
                                                    </div> 
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label style="margin-bottom: 0">Region:</label>
                                                                <select class="form-control" name="city_id" >
                                                                    <option value="">--Tanlash--</option>
                                                                    @foreach ($sities as $city)
                                                                        <option value="{{$city->id}}" @if($city->id == $client->city_id) selected @endif>{{$city->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label style="margin-bottom: 0">Shahar:</label>
                                                                <select class="form-control" name="area_id">
                                                                    <option value="">--Tanlash--</option>
                                                                    @foreach ($ars as $ar)
                                                                        <option value="{{$ar->id}}" @if($ar->id == $client->area_id) selected @endif>{{$ar->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>  
                                                        </div>
                                                    </div> 
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label style="margin-bottom: 0">Ko'cha:</label>
                                                                <input class="form-control" type="input" value="{{$client->street}}" name="street">
                                                            </div> 
                                                        </div>
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <button type="button" class="btn btn-warning" onclick="setlocation(event)" id="select_location" style="margin-top: 20px">
                                                                    <i class="fa fa-map-marker"></i> Lokatsiya</button>
                                                                <input type="hidden" onchange="dotReplace(event)" value="0" class="form-control" id="location" name="location">
                                                            </div> 
                                                        </div>
                                                    </div> 

                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label style="margin-bottom: 0">Dom:</label>
                                                                <input class="form-control" type="input" value="{{$client->home_number}}" name="home_number">
                                                            </div> 
                                                        </div>
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label style="margin-bottom: 0">Xonadon:</label>
                                                                <input class="form-control" type="input" value="{{$client->apartment_number}}" name="apartment_number">
                                                            </div> 
                                                        </div>
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label style="margin-bottom: 0">Podezd:</label>
                                                                <input class="form-control" type="input" value="{{$client->entrance}}" name="entrance">
                                                            </div> 
                                                        </div>
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label style="margin-bottom: 0">Etaj:</label>
                                                                <input class="form-control" type="input" value="{{$client->floor}}" name="floor">
                                                            </div> 
                                                        </div>
                                                    </div> 

                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label style="margin-bottom: 0">Tel raqami:</label>
                                                                <input class="form-control phone-number" type="input" value="{{$client->phone}}" name="phone" required>
                                                            </div> 
                                                        </div>
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label style="margin-bottom: 0">Qo'shimcha:</label>
                                                                <input class="form-control phone-number" type="input" value="{{$client->phone2}}" name="phone2">
                                                            </div> 
                                                        </div>
                                                    </div> 
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label style="margin-bottom: 0">Login:</label>
                                                                <input class="form-control" type="input" value="{{$client->login}}" name="login" required>
                                                            </div> 
                                                        </div>
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label style="margin-bottom: 0">Parol:</label>
                                                                <input class="form-control" type="input" value="{{$client->password}}" name="password" required>
                                                            </div> 
                                                        </div>
                                                    </div>                                   
                                                    <div class="form-group">
                                                       <label style="margin-bottom: 0">Izoh (manzil):</label>
                                                        <textarea class="form-control" name="address" id="" rows="2">{{$client->address}}</textarea>
                                                    </div>  
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"> Chiqish</button>
                                                    <button class="btn btn-primary" type="submit"> Saqlash</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="delclient{{$client->id}}" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="title" id="defaultModalLabel">O'chirish</h4>
                                            </div>
                                            <form action="{{route('delete_client',['id' => $client->id])}}" method="post">
                                                @csrf
                                                <div class="modal-body">
                                                    <h6><label>{{$client->fullname}} ni o'chirmoqchimisz ?</label></h6>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"> Chiqish</button>
                                                    <button class="btn btn-danger" type="submit">Xa, O'chirish</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach    
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <form action="{{route('clients')}}" method="get">
                        <div class="col d-flex justify-content mt-3">
                            <input type="number" class="form-control" name="page" value="{{request()->query('page')}}" placeholder="Page ...">
                        </div>
                    </form>
                    <div class="col d-flex justify-content-end mt-3">
                        {{ $clients->withQueryString()->links() }}
                    </div>
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
    
    function dotReplace(event){
                event.taget.value=event.target.value.replaceAll(",", ".")
            }
</script>
<script>
     function onsel(){
        if(document.getElementById("tolov-usuli").value == 3)
            {  
                var x = document.getElementById("price").value;
                var y = document.getElementById("product_count").value;
                var z = x * y;
                $("#amount").val(z);
                $("#amount").attr('disabled', true);
                
            }
    }
</script>
<script>
       $(document).ready(function(){  
        $('.phone-number').inputmask('(99)9999999');  
    });
</script>
<script>
    function onsel(id) {
        const $this = $("#prod_sel" + id);
            const dataVal = $this.find(':selected').data('amount'); 
            $('#sena_product_order' + id).val(dataVal);
        }
</script>
@endsection


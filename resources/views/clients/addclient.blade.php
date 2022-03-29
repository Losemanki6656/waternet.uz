@extends('layouts.master')
@section('content')

    @if (\Session::has('msg'))  
        @if (Session::get('msg') == 'success')
        <div class="alert alert-success" id="success-alert">Yangi mijoz muvaffaqqiyatli qo'shildi !</div>
        @endif
    @endif
    @error('login')
        <div class="alert alert-danger">Bunday loginli mijoz mavjud!</div>
    @enderror   

    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-5 col-md-8 col-sm-12">
                    <h2>Mijozlar</h2>
                </div>            
                <div class="col-lg-7 col-md-4 col-sm-12 text-right">
                    <ul class="breadcrumb justify-content-end">
                        <li class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>                            
                        <li class="breadcrumb-item active">Mijoz qo'shish</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-8 col-md-12">
                <form action="{{route('add_client')}}" method="post">
                    @csrf
                    <div class="card Sales_Overview">
                        <div class="header">
                            <h2>Mijoz qo'shish</h2>
                            <ul class="header-dropdown">
                                <li> <a type="button" onclick="addregion()" id="addregion" style="color: rgb(65, 15, 245)"><i class="fa fa-plus"></i> Region qo'shish</a></li>
                            </ul>
                        </div>
                        <div class="body">
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-6">
                                        <b>Mijoz ismini kiriting:</b>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-user"></i></span>
                                                </div>
                                                <input type="text" class="form-control" name="fullname" value="{{ Request::old('fullname') }}" style="padding-bottom: 10px" placeholder="FIO.." required>
                                            </div>
                                    </div>
                                </div>   
                                <div class="row clearfix">
                                    <div class="col-lg-6 col-md-6">
                                        <b>Regionni tanlang:</b>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-map-marker"></i></span>
                                                </div>
                                                <select class="form-control show-tick select2" name="sity_id" data-placeholder="Regionni tanlang" required>
                                                    <option value=""></option>
                                                    @foreach ($sities as $sity)
                                                        <option value={{$sity->id}}>{{$sity->name}}</option> 
                                                    @endforeach
                                                </select>
                                                
                                            </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <b>Adres:</b>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-map-marker"></i></span>
                                                </div>
                                                <select class="form-control show-tick select2" name="area_id"  data-placeholder="Adresni tanlang" required>
                                                    <option value=""></option>
                                                    @foreach ($areas as $area)
                                                        <option value={{$area->id}}>{{$area->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-6 col-md-6">
                                        <b>Ko'cha yoki maxalla:</b>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" name="ulitsa" value="{{ Request::old('ulitsa') }}" style="padding-bottom: 10px" placeholder="Majburiy emas">
                                            </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="row">
                                            <div class="col">
                                                <b>Uy raqami:</b>
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" name="home_number" value="{{ Request::old('home_number') }}" style="padding-bottom: 10px" placeholder="Majburiy emas">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <b>Xonadon №:</b>
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" name="kv_number" value="{{ Request::old('kv_number') }}" style="padding-bottom: 10px" placeholder="Majburiy emas">
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>   
                                <div class="row clearfix">
                                    
                                    <div class="col-lg-6 col-md-6">
                                        <div class="row">
                                            <div class="col">
                                                <b>Podezd:</b>
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" name="podezd" value="{{ Request::old('podezd') }}" style="padding-bottom: 10px" placeholder="Majburiy emas">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <b>Etaj:</b>
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" name="etaj" value="{{ Request::old('etaj') }}" style="padding-bottom: 10px" placeholder="Majburiy emas">
                                                </div>
                                            </div>
                                            
                                        </div>
                                        
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="row">
                                            <div class="col"> 
                                                <b>Bonus qo'shish:</b>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fa fa-gift"></i></span>
                                                    </div>
                                                    <input type="number" class="form-control" value="{{ Request::old('bonus') }}"  name="bonus" style="padding-bottom: 11px" placeholder="0">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="input-group mb-3">
                                                    <button type="button" class="btn btn-warning" onclick="setlocation(event)" id="select_location" style="margin-top: 23px">
                                                        <i class="fa fa-map-marker"></i> Lokatsiya</button>
                                                
                                                    <input type="hidden" onchange="dotReplace(event)" value="0" class="form-control" id="location" name="location">

                                                </div>
                                            </div>
                                        </div>
                                    
                                    </div>
                                
                                </div>   
                                <div class="row clearfix">
                                    <div class="col-lg-6 col-md-6">
                                        <b>Izoh(manzil):</b>
                                            <div class="input-group mb-3">
                                                <textarea class="form-control" name="address">{{ Request::old('address') }}</textarea>
                                            </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="row">
                                            <div class="col"> 
                                                <b>Login:</b>
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" id="login" name="login" style="padding-bottom: 11px">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <b>Parol:</b>
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" id="password" name="password" style="padding-bottom: 11px">
                                                </div>
                                            </div>
                                        </div>
                                    
                                    </div>
                                </div>        
                                <div class="row clearfix">
                                    <div class="col-lg-9 col-md-6">
                                        <div class="row">
                                            <div class="col-6">
                                                <b>Tel raqami:</b>
                                                <div class="input-group mb-3"> 
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control phone-number" id="phone1" onchange="login_pass()" value="{{ Request::old('phone1') }}" name="phone1" style="padding-bottom: 11px" required>
                                                </div>
                                            </div>
                                            <div class="col">
                                                    <div class="input-group mb-3"> 
                                                        <button class="btn btn-info" onclick="addNumber()" id="plusnumber" style="margin-top: 23px"><i class="fa fa-plus"></i></button>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="input-group mb-3"> 
                                            <button class="btn btn-success" type="submit" style="margin-top: 23px"><i class="fa fa-save"></i> Saqlash</button>
                                        </div>            
                                    </div>
                                </div>
                                <div class="row clearfix" id="addnumber" style="display: none">
                                    <div class="col-lg-9 col-md-6">
                                        <div class="row">
                                            <div class="col">
                                                <b>Qo'shimcha tel:</b>
                                                <div class="input-group mb-3"> 
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control phone-number" value="{{ Request::old('phone2') }}" name="phone2" style="padding-bottom: 11px">
                                                </div>
                                            </div>
                                            <div class="col">
                                                    <div class="input-group mb-3"> 
                                                        <button class="btn btn-danger" type="button" onclick="minusNumber()" id="minusnumber" style="margin-top: 23px"><i class="fa fa-minus-circle"></i></button>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>                

                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-4 col-md-12" style="display: none" id="addregiondiv">
               
                    <div class="card">
                        <div class="header">
                            <h2 class="text-center">Region qo'shish</h2>
                        </div>
                        <div class="body">
                            <form action="{{route('add_region')}}" method="post">
                                @csrf
                                <div class="row clearfix" id="addnumber">
                                    <div class="col-lg-12 col-md-6">
                                        <b>Region nome:</b>
                                        <div class="input-group mb-3"> 
                                            <input type="text" class="form-control" name="region_name" style="padding-bottom: 11px" placeholder="Region nomini kiriting" required>
                                        </div>       
                                    </div>
                                </div>
                                <div class="row clearfix" id="addnumber">
                                    <div class="col-lg-12 col-md-6">   
                                            <div class="input-group mb-3"> 
                                                <button class="btn btn-success" type="submit"><i class="fa fa-check-circle"></i> Saqlash</button>
                                            </div>        
                                    </div>   
                                </div>
                            </form>
                            <form action="{{route('add_city')}}" method="post">
                                @csrf
                                <div class="row clearfix" id="addnumber">
                                    <div class="col-lg-12 col-md-6">
                                        <b>Regionni tanlang:</b>
                                        <div class="input-group mb-3"> 
                                            <select class="form-control show-tick select2" name="sity_id" data-placeholder="Regionni tanlang" required>
                                                <option value=""></option>
                                                @foreach ($sities as $sity)
                                                    <option value={{$sity->id}}>{{$sity->name}}</option> 
                                                @endforeach
                                            </select>
                                        </div>       
                                    </div>
                                </div>
                                <div class="row clearfix" id="addnumber">
                                    <div class="col-lg-12 col-md-6">
                                        <b>Regionga qarashli manzil:</b>
                                        <div class="input-group mb-3"> 
                                            <input type="text" class="form-control" style="padding-bottom: 11px" name="area_name" placeholder="shahar, tuman, mahalla ..." required>
                                        </div>       
                                    </div>
                                </div>
                                <div class="row clearfix" id="addnumber">
                                    <div class="col-lg-12 col-md-6">   
                                            <div class="input-group mb-3"> 
                                                <button class="btn btn-secondary mr-3" type="button" id="closeregionbutton" onclick="closeregion()" ><i class="fa fa-minus-circle"></i> Bekor qilish</button>
                                                <button class="btn btn-success" type="submit"><i class="fa fa-check-circle"></i> Saqlash</button>
                                            </div>        
                                    </div>   
                                </div>
                            </form>
                        </div>   
                    </div>
               </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

<script>
    function addNumber() {
        var numberdiv = document.getElementById("addnumber");
        var plusbutton = document.getElementById("plusnumber");
        numberdiv.style.display = "block";
        plusbutton.disabled = true;
    }

    function minusNumber() {
        var numberdiv = document.getElementById("addnumber");
        var plusbutton = document.getElementById("plusnumber");
        numberdiv.style.display = "none";
        plusbutton.disabled = false;
    }

    function addregion() {
        var addregiondiv = document.getElementById("addregiondiv");
        var addregionbutton = document.getElementById("addregion");
        addregiondiv.style.display = "block";
        addregionbutton.disabled = true;
    }

    function closeregion() {
        var addregiondiv = document.getElementById("addregiondiv");
        var addregionbutton = document.getElementById("addregion");
        addregiondiv.style.display = "none";
        addregionbutton.disabled = false;
    }

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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>  

<script>
    $(document).ready(function(){  
        $('.phone-number').inputmask('(99)9999999');  
    });

    function login_pass() {
        var x = document.getElementById("phone1").value;

        var newstr = x.replace('(', '');
            newstr = newstr.replace(')', '');

                $("#login").val(newstr);
                $("#password").val(newstr);
    }

</script>

@endsection

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<html lang="en">
<head>
<title>Waternet</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="description" content="Mplify Bootstrap 4.1.1 Admin Template">
<meta name="author" content="ThemeMakker, design by: ThemeMakker.com">


<link rel="stylesheet" href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/animate-css/animate.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/font-awesome/css/font-awesome.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/multi-select/css/multi-select.css')}}">

<link rel="stylesheet" href="{{asset('assets/vendor/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/chartist/css/chartist.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.css')}}">

<link rel="stylesheet" href="{{asset('assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}">

<!-- Select2 -->
<link rel="stylesheet" href="{{asset('assets/vendor/select2/select2.css')}}" />

<!-- MAIN CSS -->
<link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/blog.css')}}">

<link rel="stylesheet" href="{{asset('assets/css/ecommerce.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/color_skins.css')}}">

<!-- Demo CSS not Include in project -->
<style>
    .demo-card label{ display: block; position: relative;}
    .demo-card .col-lg-4{ margin-bottom: 30px;}
</style>

</head>
<body class="theme-blue">

<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="m-t-30"><img src="{{asset('assets/images/thumbnail.png')}}" width="20" height="30" ></div>
        <p>Please wait...</p>
    </div>
</div>
<!-- Overlay For Sidebars -->
<div class="overlay" style="display: none;"></div>

<div id="wrapper">

    <nav class="navbar navbar-fixed-top">
        <div class="container-fluid">

            <div class="navbar-brand">
                <a href="/">
                    <img src="{{asset('assets/images/thumbnail.png')}}" width="20" height="30" style="margin-left: 10px">
                    <span class="name"> Waternet</span>
                </a>
            </div>
            
            <div class="navbar-right">
                <ul class="list-unstyled clearfix mb-0">
                    <li>
                        <div class="navbar-btn btn-toggle-show">
                            <button type="button" class="btn-toggle-offcanvas"><i class="lnr lnr-menu fa fa-bars"></i></button>
                        </div>                        
                        <a href="javascript:void(0);" class="btn-toggle-fullwidth btn-toggle-hide"><i class="fa fa-bars"></i></a>
                    </li>
                    <li>
                        <form id="navbar-search" class="navbar-form search-form" method="get">
                            @csrf
                            <input name="search" class="form-control" placeholder="Search here..." value="{{request()->query('search')}}"  type="text">
                            <button type="submit" class="btn btn-default"><i class="icon-magnifier"></i></button>
                        </form>
                    </li>
                    <li>
                        <div id="navbar-menu">
                            <ul class="nav navbar-nav">
                                <li>
                                    <a href="javascript:void(0);" class="mega_menu icon-menu" title="Mega Menu">Mega</a>
                                </li>
                                @if (Auth::user()->id != 1)
                                    <li class="dropdown">
                                        <a href="javascript:void(0);" class="dropdown-toggle icon-menu" data-toggle="dropdown">
                                            <i class="icon-bell"></i>
                                            <span class="notification-dot"></span>
                                        </a>
                                        <ul class="dropdown-menu animated bounceIn notifications">
                                            <li class="header">
                                                <strong>Tarif - {{$info_org->traffic->name}}</strong> 
                                                <p>
                                                    <code class="text-white">{{$info_org->date_traffic}} gacha</code>
                                                </p>
                                            </li>
                                            
                                            <li>
                                                <a href="javascript:void(0);">
                                                    <div class="media">
                                                        <div class="media-left">
                                                            <i class="icon-users text-success"></i>
                                                        </div>
                                                        <div class="media-body">
                                                            <p class="text">Mijozlar soni: <strong> {{$info_org->clients_count}} ta mavjud</strong></p>
                                                            <span class="timestamp">Tarif bo'yicha: {{$info_org->traffic->clients_count}} ta</span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);">
                                                    <div class="media">
                                                        <div class="media-left">
                                                            <i class="icon-envelope-open text-warning"></i>
                                                        </div>
                                                        <div class="media-body">
                                                            <p class="text">Smslar soni: <strong> {{$info_org->sms_count}} ta yuborilgan</strong></p>
                                                            <span class="timestamp">Tarif bo'yicha: {{$info_org->traffic->sms_count + $info_org->location}} ta</span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);">
                                                    <div class="media">
                                                        <div class="media-left">
                                                            <i class="icon-bag text-danger"></i>
                                                        </div>
                                                        <div class="media-body">
                                                            <p class="text">Tovarlar soni: <strong> {{$info_org->products_count}} ta mavjud</strong></p>
                                                            <span class="timestamp">Tarif bo'yicha: {{$info_org->traffic->products_count}} ta</span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);">
                                                    <div class="media">
                                                        <div class="media-left">
                                                            <i class="icon-user text-primary"></i>
                                                        </div>
                                                        <div class="media-body">
                                                            <p class="text">Xodimlar soni: <strong> {{$info_org->users_count}} ta mavjud</strong></p>
                                                            <span class="timestamp">Tarif bo'yicha: {{$info_org->traffic->users_count}} ta</span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);">
                                                    <div class="media">
                                                        <div class="media-left">
                                                            <i class="fa fa-money text-info"></i>
                                                        </div>
                                                        <div class="media-body">
                                                            <p class="text">Balans: <strong> {{$info_org->balance}} so'm</strong></p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="footer"><a href="{{route('traffic_merchant')}}" class="more">Tarifni o'zgartirish</a></li>
                                        </ul>
                                    </li>
                                @endif
                                
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle icon-menu" data-toggle="dropdown"><i class="icon-flag"></i><span class="notification-dot"></span></a>
                                    <ul class="dropdown-menu animated bounceIn task">
                                        <li class="header"><strong>Project</strong></li>
                                        <li class="body">
                                            <ul class="menu tasks list-unstyled">
                                                <li>
                                                    <a href="javascript:void(0);">
                                                        <span class="text-muted">Clockwork Orange <span class="float-right">29%</span></span>
                                                        <div class="progress">
                                                            <div class="progress-bar l-turquoise" role="progressbar" aria-valuenow="29" aria-valuemin="0" aria-valuemax="100" style="width: 29%;"></div>
                                                        </div>
                                                    </a>
                                                </li>
                                                                  
                                            </ul>
                                        </li>
                                        <li class="footer"><a href="javascript:void(0);">View All</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle icon-menu" data-toggle="dropdown"><i class="fa fa-language"></i></a>
                                    <ul class="dropdown-menu animated flipInX choose_language">                                        
                                        <li><a href="javascript:void(0);">O'zbekcha</a></li>
                                        <li><a href="javascript:void(0);">Русский</a></li>
                                        <li><a href="javascript:void(0);">English</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle icon-menu" data-toggle="dropdown">
                                        <img class="rounded-circle" src="{{asset('assets/images/user-small.png')}}" width="30" alt="">
                                    </a>
                                    <div class="dropdown-menu animated flipInY user-profile">
                                        <div class="d-flex p-3 align-items-center">
                                            <div class="drop-left m-r-10">
                                                <img src="{{asset('assets/images/user-small.png')}}" class="rounded" width="50" alt="">
                                            </div>
                                            <div class="drop-right">
                                                <h4>{{Auth::user()->name}}</h4>
                                                <p class="user-name">{{Auth::user()->email}}</p>
                                            </div>
                                        </div>
                                        <div class="m-t-10 p-3 drop-list">
                                            <ul class="list-unstyled">
                                                <li><a href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="icon-power"></i>Logout</a></li>

                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                    @csrf
                                                </form>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div id="leftsidebar" class="sidebar">
        <div class="sidebar-scroll">
            <nav id="leftsidebar-nav" class="sidebar-nav">
                <ul id="main-menu" class="metismenu">
                    
                        @can('bosh-menu')
                            <li class="heading">Main</li>
                            
                            <li class="{{ url()->current() == route('statistics')? 'active' : ''}}">
                                <a href="{{route('statistics')}}"><i class="fa fa-home"></i><span>Statistika</span>
                                </a>
                            </li>
                        @endcan
                        @can('clients')
                            <li class="{{ url()->current() == route('clients')? 'active' : ''}}">
                                <a href="{{route('clients')}}"><i class="fa fa-address-card"></i><span>Mijozlar</span>
                                </a>
                            </li> 
                        @endcan
                        @can('orders')
                            <li class="{{ url()->current() == route('orders')? 'active' : ''}}">
                                <a href="{{route('orders')}}"><i class="fa fa-shopping-bag"></i><span>Zakazlar</span>
                                </a>
                            </li> 
                        @endcan
                        @can('products')
                            <li class="{{ url()->current() == route('products')? 'active' : ''}}">
                                <a href="{{route('products')}}"><i class="fa fa-archive"></i><span>Tovarlar</span>
                                </a>
                            </li>
                        @endcan
                        @can('regions')
                            <li class="{{strpos(url()->current(),'regions')? 'active' : ''}}">
                                <a href="{{route('regions')}}" ><i class="fa fa-map"></i><span>Regionlar</span>
                                </a>
                            </li> 
                        @endcan
                        @can('users')
                            <li class="{{ url()->current() == route('users')? 'active' : ''}}">
                                <a href="{{route('users')}}" ><i class="fa fa-users"></i><span>Xodimlar</span>
                                </a>
                            </li>  
                        @endcan
                        @can('smsmanager')
                            <li class="{{strpos(url()->current(),'smsmanager')? 'active' : ''}}">
                                <a href="{{route('send_message')}}" ><i class="fa fa-comment"></i><span>SmsManager</span>
                                </a>
                            </li> 
                        @endcan
                        @can('results')
                            <li class="{{ url()->current() == route('results')? 'active' : ''}}">
                                <a href="{{route('results')}}"><i class="fa fa-check-circle"></i><span>Hisobotlar</span>
                                </a>
                            </li> 
                        @endcan
                        @can('sklad')
                            <li class="{{strpos(url()->current(),'warehouse')? 'active' : ''}}">
                                <a href="{{route('entry_products')}}" ><i class="fa fa-cube"></i><span>Sklad</span>
                                </a>
                            </li>
                        @endcan
                        <li class="{{strpos(url()->current(),'admin-traffics')? 'active' : ''}}">
                            <a href="{{route('admin_traffics')}}" ><i class="fa fa-warning"></i><span>Tariflar</span>
                            </a>
                        </li>
                        @can('admin')
                            <li class="heading">Administration</li>

                            <li class="{{strpos(url()->current(),'reklama')? 'active' : ''}}">
                                <a href="{{route('organizations')}}" ><i class="icon-layers"></i><span>Reklama</span>
                                </a>
                            </li>

                            <li class="{{strpos(url()->current(),'organizations')? 'active' : ''}}">
                                <a href="{{route('organizations')}}" ><i class="fa fa-cubes"></i><span>Magazinlar</span>
                                </a>
                            </li>
                            <li class="{{strpos(url()->current(),'traffics')? 'active' : ''}}">
                                <a href="{{route('traffics')}}" ><i class="fa fa-warning"></i><span>Tariflar</span>
                                </a>
                            </li>
                            <li class="{{strpos(url()->current(),'users-admin')? 'active' : ''}}">
                                <a href="{{route('users_admin')}}" ><i class="fa fa-users"></i><span>Users</span>
                                </a>
                            </li>
                            <li class="{{strpos(url()->current(),'client-app')? 'active' : ''}}">
                                <a href="{{route('client_app')}}" ><i class="fa fa-users"></i><span>App Photos</span>
                                </a>
                            </li>
                            
                            <li class="{{strpos(url()->current(),'organization-app')? 'active' : ''}}">
                                <a href="{{route('organization_app')}}" ><i class="fa fa-users"></i><span>App Orgnization Swipers</span>
                                </a>
                            </li>

                            <li class="{{strpos(url()->current(),'admin-app-cart')? 'active' : ''}}">
                                <a href="{{route('organization_app_cart')}}" ><i class="fa fa-users"></i><span>App Orgnization Swipers</span>
                                </a>
                            </li>
                        @endcan
                   
                </ul>
            </nav>
        </div>
    </div>
    
    <div id="main-content">
            
         @yield('content')                           

        <div id="nouislider_basic_example" style="display: none"></div>
         <div id="nouislider_range_example" style="display: none"></div>        
    </div>
    
</div>

<!-- Javascript -->
<script src="{{asset('assets/bundles/libscripts.bundle.js')}}"></script>    
<script src="{{asset('assets/bundles/vendorscripts.bundle.js')}}"></script>

<script src="{{asset('assets/bundles/chartist.bundle.js')}}"></script>
<script src="{{asset('assets/bundles/knob.bundle.js')}}"></script> <!-- Jquery Knob-->
<script src="{{asset('assets/bundles/flotscripts.bundle.js')}}"></script> <!-- flot charts Plugin Js --> 

<script src="{{asset('assets/js/index.js')}}"></script>

<script src="{{asset('assets/vendor/bootstrap-colorpicker/js/bootstrap-colorpicker.js')}}"></script> <!-- Bootstrap Colorpicker Js --> 
<script src="{{asset('assets/vendor/jquery-inputmask/jquery.inputmask.bundle.js')}}"></script> <!-- Input Mask Plugin Js --> 
<script src="{{asset('assets/vendor/jquery.maskedinput/jquery.maskedinput.min.js')}}"></script>
<script src="{{asset('assets/vendor/multi-select/js/jquery.multi-select.js')}}"></script> <!-- Multi Select Plugin Js -->
<script src="{{asset('assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js')}}"></script>
<script src="{{asset('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js')}}"></script> <!-- Bootstrap Tags Input Plugin Js --> 
<script src="{{asset('assets/vendor/nouislider/nouislider.js')}}"></script> <!-- noUISlider Plugin Js --> 

<script src="{{asset('assets/vendor/select2/select2.min.js')}}"></script> <!-- Select2 Js -->

<script src="{{asset('assets/js/pages/forms/advanced-form-elements.js')}}"></script>

<script src="{{asset('assets/bundles/mainscripts.bundle.js')}}"></script>
<script src="{{asset('assets/bundles/morrisscripts.bundle.js')}}"></script>

<script src="{{asset('assets/js/widgets/infobox/infobox-1.js')}}"></script>

<script>
    $('.sparkbar').sparkline('html', { type: 'bar' });
</script>
<!--<script src="//code-eu1.jivosite.com/widget/RmsgH8HyeY" async></script>-->
@yield('scripts')
@stack('scripts')
</body>
<!-- Mirrored from thememakker.com/templates/mplify/html/light/forms-advanced.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 25 Feb 2022 12:03:49 GMT -->
</html>


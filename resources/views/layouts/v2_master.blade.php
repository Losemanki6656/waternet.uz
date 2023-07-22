<!doctype html>
<html lang="en" id="html_layout">

<head>

    <meta charset="utf-8" />
    <title>Waternet</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}">

    <!-- preloader css -->
    <link rel="stylesheet" href="{{ asset('assets/css/preloader.min.css') }}" type="text/css" />


    <link href="{{ asset('assets/libs/choices.js/public/assets/styles/choices.min.css') }}" rel="stylesheet"
        type="text/css" />

    <link href="{{ asset('assets/libs/alertifyjs/build/css/alertify.min.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('animate_css/animate.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/libs/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

</head>

<body data-topbar="dark" id="bodyAttr">

    <!-- <body data-layout="horizontal"> -->

    <!-- Begin page -->
    <div id="layout-wrapper">


        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box">
                        <a href="" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="{{ asset('assets/images/favicon.png') }}" alt="" height="30">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ asset('assets/images/favicon.png') }}" alt="" height="24">
                                <span class="logo-txt">Waternet</span>
                            </span>
                        </a>

                        <a href="" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="{{ asset('assets/images/favicon.png') }}" alt="" height="30">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ asset('assets/images/favicon.png') }}" alt="" height="24">
                                <span class="logo-txt">Waternet</span>
                            </span>
                        </a>
                    </div>

                    <button type="button" class="btn btn-sm px-3 font-size-16 header-item" id="vertical-menu-btn">
                        <i class="fa fa-fw fa-bars"></i>
                    </button>

                    <!-- App Search-->
                    <form class="app-search d-none d-lg-block">
                        <div class="position-relative">
                            <input type="search" class="form-control" placeholder="Search...">
                            <button class="btn btn-primary" type="button"><i
                                    class="bx bx-search-alt align-middle"></i></button>
                        </div>
                    </form>
                </div>

                <div class="d-flex">

                    <div class="dropdown d-inline-block d-lg-none ms-2">
                        <button type="button" class="btn header-item" id="page-header-search-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i data-feather="search" class="icon-lg"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                            aria-labelledby="page-header-search-dropdown">

                            <form class="p-3">
                                <div class="form-group m-0">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search ..."
                                            aria-label="Search Result">

                                        <button class="btn btn-primary" type="submit"><i
                                                class="mdi mdi-magnify"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="dropdown d-none d-sm-inline-block">
                        <button type="button" class="btn header-item" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <img id="header-lang-img" src="{{ asset('assets/images/flags/us.jpg') }}"
                                alt="Header Language" height="16">
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">

                            <!-- item-->
                            <a onclick="Translate('en')" class="dropdown-item notify-item language" data-lang="en">
                                <img src="{{ asset('assets/images/flags/us.jpg') }}" alt="user-image" class="me-1"
                                    height="12"> <span class="align-middle">English</span>
                            </a>
                            <!-- item-->
                            <a onclick="Translate('ru')" class="dropdown-item notify-item language" data-lang="ru">
                                <img src="{{ asset('assets/images/flags/russia.jpg') }}" alt="user-image"
                                    class="me-1" height="12"> <span class="align-middle">Russian</span>
                            </a>
                            <!-- item-->
                            <a onclick="Translate('uz')" class="dropdown-item notify-item language" data-lang="uz">
                                <img src="{{ asset('assets/images/flags/uzb.jpg') }}" alt="user-image"
                                    class="me-1" height="12"> <span class="align-middle">Uzbek</span>
                            </a>
                        </div>
                    </div>

                    <div class="dropdown d-none d-sm-inline-block">
                        <button type="button" class="btn header-item" id="mode-setting-btn">
                            <i data-feather="moon" class="icon-lg layout-mode-dark"></i>
                            <i data-feather="sun" class="icon-lg layout-mode-light"></i>
                        </button>
                    </div>

                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item noti-icon position-relative"
                            id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <i data-feather="bell" class="icon-lg"></i>
                            <span class="badge bg-success rounded-pill">5</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                            aria-labelledby="page-header-notifications-dropdown">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0"> {{ __('messages.notifications') }} </h6>
                                    </div>
                                    <div class="col-auto">
                                        <a href="#!" class="small text-reset text-decoration-underline">
                                            {{ __('messages.unread') }} (3)</a>
                                    </div>
                                </div>
                            </div>
                            <div data-simplebar style="max-height: 230px;">
                                <a href="#!" class="text-reset notification-item">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 me-3">
                                            <img src="{{ asset('assets/images/users/avatar-3.jpg') }}"
                                                class="rounded-circle avatar-sm" alt="user-pic">
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">James Lemire</h6>
                                            <div class="font-size-13 text-muted">
                                                <p class="mb-1">It will seem like simplified English.</p>
                                                <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span>1 hours
                                                        ago</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="p-2 border-top d-grid">
                                <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                                    <i class="mdi mdi-arrow-right-circle me-1"></i>
                                    <span>{{ __('messages.view_more') }}..</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item right-bar-toggle me-2">
                            <i data-feather="settings" class="icon-lg"></i>
                        </button>
                    </div>

                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item bg-light-subtle border-start border-end"
                            id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <img class="rounded-circle header-profile-user"
                                src="{{ asset('assets/images/users/avatar-1.jpg') }}" alt="Header Avatar">
                            <span class="d-none d-xl-inline-block ms-1 fw-medium">{{ auth()->user()->name }}</span>
                            <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <a class="dropdown-item" href=""><i
                                    class="mdi mdi-face-profile font-size-16 align-middle me-1"></i>
                                {{ __('messages.profile') }}</a>
                            <a class="dropdown-item" href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                    class="mdi mdi-lock font-size-16 align-middle me-1"></i>
                                {{ __('messages.lock_screen') }}</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                    class="mdi mdi-logout font-size-16 align-middle me-1"></i>
                                {{ __('messages.logout') }}</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </header>

        <!-- ========== Left Sidebar Start ========== -->
        <div class="vertical-menu animate__animated animate__fadeIn">

            <div data-simplebar class="h-100">

                <!--- Sidemenu -->
                <div id="sidebar-menu">
                    <!-- Left Menu Start -->
                    <ul class="metismenu list-unstyled" id="side-menu">
                        <li class="menu-title" data-key="t-menu">{{ __('messages.Statistics') }}</li>

                        @can('bosh-menu')
                            <li>
                                <a href="{{ route('dashboard') }}">
                                    <i data-feather="pie-chart"></i>
                                    <span class="badge rounded-pill bg-success-subtle text-success float-end">9+</span>
                                    <span data-key="t-dashboard">{{ __('messages.dashboard') }}</span>
                                </a>
                            </li>
                        @endcan

                        @can('results')
                            <li>
                                <a href="{{ route('results') }}">
                                    <i data-feather="monitor"></i>
                                    <span data-key="t-dashboard">{{ __('messages.results') }}</span>
                                </a>
                            </li>
                        @endcan

                        <li class="menu-title" data-key="t-menu">{{ __('messages.Clients_and_Orders') }}</li>
                        @can('clients')
                            <li>
                                <a href="{{ route('clients') }}">
                                    <i data-feather="users"></i>
                                    <span data-key="t-dashboard">{{ __('messages.Clients') }}</span>
                                </a>
                            </li>
                        @endcan
                        @can('orders')
                            <li>
                                <a href="{{ route('orders') }}">
                                    <i data-feather="codesandbox"></i>
                                    <span data-key="t-dashboard">{{ __('messages.Orders') }}</span>
                                </a>
                            </li>
                        @endcan

                        <li class="menu-title" data-key="t-menu">{{ __('messages.Warehouse') }}</li>

                        @can('products')
                            <li>
                                <a href="{{ route('products') }}">
                                    <i data-feather="shopping-bag"></i>
                                    <span data-key="t-dashboard">{{ __('messages.Products') }}</span>
                                </a>
                            </li>
                        @endcan
                        @can('sklad')
                            <li>
                                <a href="{{ route('entry_products') }}">
                                    <i data-feather="codepen"></i>
                                    <span data-key="t-dashboard">{{ __('messages.warehouse') }}</span>
                                </a>
                            </li>
                        @endcan

                        <li class="menu-title" data-key="t-menu">{{ __('messages.Others') }}</li>
                        @can('regions')
                            <li>
                                <a href="{{ route('regions') }}">
                                    <i data-feather="map-pin"></i>
                                    <span data-key="t-dashboard">{{ __('messages.regions') }}</span>
                                </a>
                            </li>
                        @endcan
                        @can('users')
                            <li>
                                <a href="{{ route('users') }}">
                                    <i data-feather="user-check"></i>
                                    <span data-key="t-dashboard">{{ __('messages.users') }}</span>
                                </a>
                            </li>
                        @endcan

                        @can('smsmanager')
                            <li>
                                <a href="javascript: void(0);" class="has-arrow">
                                    <i data-feather="message-square"></i>
                                    <span data-key="t-icons">{{ __('messages.messages') }}</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{ route('members') }}"
                                            data-key="t-feather">{{ __('messages.members') }}</a></li>
                                    <li><a href="{{ route('success_message') }}"
                                            data-key="t-feather">{{ __('messages.history') }}</a></li>
                                    <li><a href="#" data-key="t-feather">
                                            <span
                                                class="badge rounded-pill bg-warning-subtle text-warning float-end">new</span>
                                            {{ __('messages.example_sms') }}</a></li>
                                </ul>
                            </li>
                        @endcan

                        @can('admin')
                            <li class="menu-title" data-key="t-apps">Administration</li>

                            <li>
                                <a href="{{ route('organizations') }}"><i
                                        data-feather="user-check"></i><span>Reklama</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('organizations') }}"><i
                                        data-feather="user-check"></i><span>Magazinlar</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('traffics') }}"><i data-feather="user-check"></i><span>Tariflar</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('users_admin') }}"><i data-feather="user-check"></i><span>Users</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('client_app') }}"><i data-feather="user-check"></i><span>App
                                        Photos</span>
                                </a>
                            </li>

                            <li>
                                <a><i data-feather="user-check"></i><span>App
                                        Orgnization Swipers</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('organization_app_cart') }}"><i data-feather="user-check"></i><span>App
                                        Orgnization Swipers</span>
                                </a>
                            </li>
                        @endcan

                    </ul>


                </div>
            </div>
        </div>



        <div class="main-content">


            <div class="page-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>
                                document.write(new Date().getFullYear())
                            </script> © Waternet.
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                {{ __('messages.design_develop') }} <a href=""
                                    class="text-decoration-underline">Waternet</a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->


    <!-- Right Sidebar -->
    <div class="right-bar">
        <div data-simplebar class="h-100">
            <div class="rightbar-title d-flex align-items-center p-3">

                <h5 class="m-0 me-2">{{ __('messages.the_custom') }}</h5>

                <a href="javascript:void(0);" class="right-bar-toggle ms-auto">
                    <i class="mdi mdi-close noti-icon"></i>
                </a>
            </div>

            <!-- Settings -->
            <hr class="m-0" />

            <div class="p-4">
                <h6 class="mb-3">{{ __('messages.select_custom_color') }}</h6>
                <div class="form-check form-check-inline">
                    <input class="form-check-input theme-color" type="radio" name="theme-mode" id="theme-default"
                        value="default" onchange="document.documentElement.setAttribute('data-theme-mode', 'default')"
                        onclick="htmlLayout('light')" checked>
                    <label class="form-check-label" for="theme-default">{{ __('messages.default') }}</label>
                </div>

                <div class="form-check form-check-inline">
                    <input class="form-check-input theme-color" type="radio" name="theme-mode" id="theme-red"
                        value="red" onchange="document.documentElement.setAttribute('data-theme-mode', 'red')"
                        onclick="htmlLayout('red')">
                    <label class="form-check-label" for="theme-red">{{ __('messages.red') }}</label>
                </div>

                <div class="form-check form-check-inline">
                    <input class="form-check-input theme-color" type="radio" name="theme-mode" id="theme-purple"
                        value="purple" onchange="document.documentElement.setAttribute('data-theme-mode', 'purple')"
                        onclick="htmlLayout('purple')">
                    <label class="form-check-label" for="theme-purple">{{ __('messages.purple') }}</label>
                </div>

                <h6 class="mt-4 mb-3 pt-2">{{ __('messages.topbar_color') }}</h6>

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="topbar-color" id="topbar-color-light"
                        value="light" onchange="document.body.setAttribute('data-topbar', 'light')"
                        onclick="topBar('light')">
                    <label class="form-check-label" for="topbar-color-light">{{ __('messages.light') }}</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="topbar-color" id="topbar-color-dark"
                        value="dark" onchange="document.body.setAttribute('data-topbar', 'dark')"
                        onclick="topBar('dark')">
                    <label class="form-check-label" for="topbar-color-dark">{{ __('messages.dark') }}</label>
                </div>

                <h6 class="mt-4 mb-3 pt-2 sidebar-setting">{{ __('messages.sidebar_color') }}</h6>

                <div class="form-check sidebar-setting">
                    <input class="form-check-input" type="radio" name="sidebar-color" id="sidebar-color-light"
                        value="light" onchange="document.body.setAttribute('data-sidebar', 'light')"
                        onclick="sidebarThemeUpdate('light')">
                    <label class="form-check-label" for="sidebar-color-light">{{ __('messages.light') }}</label>
                </div>
                <div class="form-check sidebar-setting">
                    <input class="form-check-input" type="radio" name="sidebar-color" id="sidebar-color-dark"
                        value="dark" onchange="document.body.setAttribute('data-sidebar', 'dark')"
                        onclick="sidebarThemeUpdate('dark')">
                    <label class="form-check-label" for="sidebar-color-dark">{{ __('messages.dark') }}</label>
                </div>
                <div class="form-check sidebar-setting">
                    <input class="form-check-input" type="radio" name="sidebar-color" id="sidebar-color-brand"
                        value="brand" onchange="document.body.setAttribute('data-sidebar', 'brand')"
                        onclick="sidebarThemeUpdate('brand')">
                    <label class="form-check-label" for="sidebar-color-brand">{{ __('messages.brand') }}</label>
                </div>
            </div>
            <hr class="m-0" />
            <div class="p-4">
                <div class="d-flex mb-3">
                    <div class="flex-shrink-0 me-3">
                        <img src="{{ asset('assets/images/custom_logos/clients.jpg') }}"
                            class="rounded-circle avatar-sm" alt="user-pic">
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-1" id="clients_count"></h6>
                        <div class="font-size-13 text-muted">
                            <p class="mb-1" id="clients_count_traffic"></p>
                        </div>
                    </div>
                </div>
                <div class="d-flex mb-3">
                    <div class="flex-shrink-0 me-3">
                        <img src="{{ asset('assets/images/custom_logos/sms.jpg') }}" class="rounded-circle avatar-sm"
                            alt="user-pic">
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-1" id="sms_count"></h6>
                        <div class="font-size-13 text-muted">
                            <p class="mb-1" id="sms_count_traffic"></p>
                        </div>
                    </div>
                </div>
                <div class="d-flex mb-3">
                    <div class="flex-shrink-0 me-3">
                        <img src="{{ asset('assets/images/custom_logos/bak.jpg') }}" class="rounded-circle avatar-sm"
                            alt="user-pic">
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-1" id="products_count"></h6>
                        <div class="font-size-13 text-muted">
                            <p class="mb-1" id="products_count_taffic"></p>
                        </div>
                    </div>
                </div>
                <div class="d-flex mb-3">
                    <div class="flex-shrink-0 me-3">
                        <img src="{{ asset('assets/images/custom_logos/man.jpg') }}" class="rounded-circle avatar-sm"
                            alt="user-pic">
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-1" id="users_count"></h6>
                        <div class="font-size-13 text-muted">
                            <p class="mb-1" id="users_count_taffic"></p>
                        </div>
                    </div>
                </div>
                <div class="d-flex mb-3">
                    <div class="flex-shrink-0 me-3">
                        <img src="{{ asset('assets/images/custom_logos/balance.png') }}"
                            class="rounded-circle avatar-sm" alt="user-pic">
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-1" id="balance"></h6>
                        <div class="font-size-13 text-muted">
                            <p class="mb-1" id="balance_debt"></p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <button type="button" onclick="updateOrgInfo()" class="btn btn-primary btn-lg">
                        <i class="fas fa-redo-alt me-2"></i>
                        {{ __('messages.update') }}
                    </button>
                </div>

            </div>

        </div>
    </div>

    <div class="rightbar-overlay"></div>

    <script>
        let cat = localStorage.getItem('body_class') ?? 'pace-done sidebar-enable';
        document.getElementById("bodyAttr").setAttribute("class", cat);

        let x = localStorage.getItem('data_sidebar_size') ?? 'lg';
        document.getElementById("bodyAttr").setAttribute("data-sidebar-size", x);

        let y = localStorage.getItem('data_bs_theme') ?? '';
        if (y == "light") document.getElementById("bodyAttr").setAttribute("data-bs-theme", '');
        else document.getElementById("bodyAttr").setAttribute("data-bs-theme", y);

        let z = localStorage.getItem('data_sidebar') ?? 'light';
        document.getElementById("bodyAttr").setAttribute("data-sidebar", z);

        let l = localStorage.getItem('data_bs_theme_html') ?? 'default';
        document.getElementById("html_layout").setAttribute("data-theme-mode", l);

        let q = localStorage.getItem('topBar') ?? 'dark';
        document.getElementById("bodyAttr").setAttribute("data-topbar", q);
    </script>
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/libs/pace-js/pace.min.js') }}"></script>
    <script src="{{ asset('assets/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/libs/alertifyjs/build/alertify.min.js') }}"></script>
    <script src="{{ asset('assets/libs/imask/imask.min.js') }}"></script>
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>


    <!-- apexcharts js -->
    <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/allchart.js') }}"></script>
    <script src="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script>
        function sidebarThemeUpdate(color) {
            localStorage.setItem('data_sidebar', color);
        }
    </script>
    <script>
        function htmlLayout(color) {
            localStorage.setItem('data_bs_theme_html', color);
        }
    </script>
    <script>
        function topBar(color) {
            localStorage.setItem('topBar', color);
        }
    </script>
    <script>
        function userData() {
            var userInfo = JSON.parse(localStorage.getItem('userInfo'))

            $('#clients_count').html("{{ __('messages.clients_count') }}: " + userInfo.clientCount);
            $('#clients_count_traffic').html("{{ __('messages.traffic') }}: " + userInfo.clientCountTraffic);

            $('#sms_count').html("{{ __('messages.sms_count') }}: " + userInfo.productsCount);
            $('#sms_count_traffic').html("{{ __('messages.traffic') }}: " + userInfo.productsCountTraffic);

            $('#products_count').html("{{ __('messages.products_count') }}: " + userInfo.smsCount);
            $('#products_count_taffic').html("{{ __('messages.traffic') }}: " + userInfo.smsCountTraffic);

            $('#users_count').html("{{ __('messages.users_count') }}: " + userInfo.usersCount);
            $('#users_count_taffic').html("{{ __('messages.traffic') }}: " + userInfo.usersCountTraffic);

            $('#balance').html("{{ __('messages.balance') }}: " + userInfo.balance);
            $('#balance_debt').html("{{ __('messages.date_traffic') }}: " + userInfo.date_traffic);
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var e = document.querySelectorAll("[data-trigger]");
            for (i = 0; i < e.length; ++i) {
                var a = e[i];
                new Choices(a, {
                    // placeholderValue: "This is a placeholder set in the config",
                    searchPlaceholderValue: "{{ __('messages.search') }}"
                })
            }
            userData();

        });

        document.getElementById('vertical-menu-btn').onclick = function() {
            let c = localStorage.getItem('data_sidebar_size') ?? 'lg';

            if (c == "sm") {
                document.getElementById("bodyAttr").setAttribute("data-sidebar-size", "lg");
                document.getElementById("bodyAttr").setAttribute("class", "pace-done sidebar-enable");
                localStorage.setItem('data_sidebar_size', 'lg');
                localStorage.setItem('body_class', 'pace-done sidebar-enable');

            } else {
                document.getElementById("bodyAttr").setAttribute("data-sidebar-size", "sm");
                document.getElementById("bodyAttr").setAttribute("class", "pace-done");
                localStorage.setItem('data_sidebar_size', 'sm');
                localStorage.setItem('body_class', 'pace-done');
            }
        };

        document.getElementById('mode-setting-btn').onclick = function() {
            let c = localStorage.getItem('data_bs_theme') ?? 'light';

            if (c == "light") {
                console.log(1);
                document.getElementById("bodyAttr").setAttribute("data-bs-theme", "dark");
                document.getElementById("bodyAttr").setAttribute("data-sidebar", "light");
                localStorage.setItem('data_bs_theme', 'dark');
                localStorage.setItem('data_sidebar', 'light');
            } else {
                console.log(2);
                document.getElementById("bodyAttr").setAttribute("data-bs-theme", "");
                document.getElementById("bodyAttr").setAttribute("data-sidebar", "light");
                localStorage.setItem('data_bs_theme', "light");
                localStorage.setItem('data_sidebar', 'light');
            }
        };
    </script>
    <script>
        function updateOrgInfo() {
            $.ajax({
                url: "{{ route('user_info') }}",
                method: "GET",
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success: function(res) {
                    localStorage.setItem('userInfo', JSON.stringify(res.data));
                    userData();
                    alertify.set('notifier', 'position', 'bottom-left');
                    alertify.success('success');
                },
                error: function(error) {
                    alertify.error(error.responseJSON.message);
                }
            });
        }
    </script>
    <script>
        function Translate(lang) {
            localStorage.setItem('Dason-language', lang);
            let url = '{{ url('change/locale') }}' + '/' + lang;
            window.location.href = `${url}`;
        }
    </script>
    <script>
        $(document).ready(function() {
            @if (session()->has('success'))
                alertify.success("{{ session()->get('success') }}");
            @elseif (session()->has('warning'))
                alertify.warning("{{ session()->get('warning') }}");
            @elseif (session()->has('error'))
                alertify.error("{{ session()->get('error') }}");
            @endif
        });
    </script>

    @yield('scripts')
    @stack('scripts')

</body>

</html>

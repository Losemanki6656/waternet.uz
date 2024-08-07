<!doctype html>
<html lang="en">


<!-- Mirrored from themesbrand.com/dason/layouts/pages-comingsoon.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 08 Jun 2023 10:03:00 GMT -->

<head>

    <meta charset="utf-8" />
    <title>Waternet</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}">

    <!-- swiper css -->
    <link rel="stylesheet" href="assets/libs/swiper/swiper-bundle.min.css">

    <!-- preloader css -->
    <link rel="stylesheet" href="assets/css/preloader.min.css" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

</head>

<body data-topbar="dark">

    <!-- <body data-layout="horizontal"> -->
    <div class="preview-img">
        <div class="swiper-container preview-thumb">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="slide-bg" style="background-image: url(assets/images/bg-1.jpg);"></div>
                </div>
                <div class="swiper-slide">
                    <div class="slide-bg" style="background-image: url(assets/images/bg-2.jpg);"></div>
                </div>
                <div class="swiper-slide">
                    <div class="slide-bg" style="background-image: url(assets/images/bg-3.jpg);"></div>
                </div>
            </div>
        </div>
        <!-- preview-thumb -->
        <div class="swiper-container preview-thumbsnav">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div>
                        <img src="assets/images/bg-1.jpg" alt="" class="avatar-sm nav-img rounded-circle">
                    </div>
                </div>
                <div class="swiper-slide">
                    <div>
                        <img src="assets/images/bg-2.jpg" alt="" class="avatar-sm nav-img rounded-circle">
                    </div>
                </div>
                <div class="swiper-slide">
                    <div>
                        <img src="assets/images/bg-3.jpg" alt="" class="avatar-sm nav-img rounded-circle">
                    </div>
                </div>
            </div>
        </div>
        <!-- preview-thumb -->
    </div>
    <!-- preview bg -->

    <div class="coming-content min-vh-100 py-4 px-3 py-sm-5">
        <div class="bg-overlay bg-primary"></div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="text-center py-4 py-sm-5">

                        <div class="mb-5">
                            <a href="index.html">
                                <img src="{{ asset('assets/images/favicon.png') }}" alt="" height="30"
                                    class="me-1"><span class="logo-txt text-white font-size-22">Waternet</span>
                            </a>
                        </div>
                        <h3 class="text-white mt-5">Срок действия вашего тарифа истек!</h3>
                        <p class="text-white-50 font-size-15">Просим вас связаться с персоналом, отвечающим за продление
                            вашего тарифного периода!</p>

                        <div data-countdown="2022/12/31" class="counter-number mt-5"></div>

                        <form class="app-search mt-5 mx-auto mb-4">
                            <div class="position-relative">
                                <input type="text" class="form-control" placeholder="Введите ваш логин">
                                <button class="btn btn-primary" type="button"><i
                                        class="bx bx-paper-plane align-middle"></i></button>
                            </div>
                        </form>

                        <a type="button" class="btn btn-light btn-lg waves-effect waves-light"
                            href="{{ route('login') }}">Выход из
                            аккаунта</a>
                        {{--
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form> --}}
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>

    <div class="rightbar-overlay"></div>
    <!-- JAVASCRIPT -->
    <script src="assets/libs/jquery/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>
    <script src="assets/libs/feather-icons/feather.min.js"></script>
    <!-- pace js -->
    <script src="assets/libs/pace-js/pace.min.js"></script>
    <!-- swiper js -->
    <script src="assets/libs/swiper/swiper-bundle.min.js"></script>
    <!-- Plugins js-->
    <script src="assets/libs/jquery-countdown/jquery.countdown.min.js"></script>

    <!-- Countdown js -->
    <script src="assets/js/pages/coming-soon.init.js"></script>
</body>

<!-- Mirrored from themesbrand.com/dason/layouts/pages-comingsoon.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 08 Jun 2023 10:03:11 GMT -->

</html>

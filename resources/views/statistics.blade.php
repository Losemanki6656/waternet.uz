@extends('layouts.master')

@section('content')

<div class="container-fluid">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-8 col-sm-12">
                <h2>Dashboard</h2>
            </div>            
            <div class="col-lg-7 col-md-4 col-sm-12 text-right">
                <ul class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>                            
                    <li class="breadcrumb-item active">Dashboard</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-12">
            <div class="card top_report">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="body">
                            <div class="clearfix">
                                <div class="float-left">
                                    <i class="fa fa-2x fa-dollar text-col-blue"></i>
                                </div>
                                <div class="number float-right text-right">
                                    <h6>EARNINGS</h6>
                                    <span class="font700">$22,500</span>
                                </div>
                            </div>
                            <div class="progress progress-xs progress-transparent custom-color-blue mb-0 mt-3">
                                <div class="progress-bar" data-transitiongoal="87"></div>
                            </div>
                            <small class="text-muted">19% compared to last week</small>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="body">
                            <div class="clearfix">
                                <div class="float-left">
                                    <i class="fa fa-2x fa-bar-chart-o text-col-green"></i>
                                </div>
                                <div class="number float-right text-right">
                                    <h6>SALES</h6>
                                    <span class="font700">$500</span>
                                </div>
                            </div>
                            <div class="progress progress-xs progress-transparent custom-color-green mb-0 mt-3">
                                <div class="progress-bar" data-transitiongoal="28"></div>
                            </div>
                            <small class="text-muted">19% compared to last week</small>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="body">
                            <div class="clearfix">
                                <div class="float-left">
                                    <i class="fa fa-2x fa-shopping-cart text-col-red"></i>
                                </div>
                                <div class="number float-right text-right">
                                    <h6>Orders</h6>
                                    <span class="font700">215</span>
                                </div>
                            </div>
                            <div class="progress progress-xs progress-transparent custom-color-red mb-0 mt-3">
                                <div class="progress-bar" data-transitiongoal="41"></div>
                            </div>
                            <small class="text-muted">19% compared to last week</small>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="body">
                            <div class="clearfix">
                                <div class="float-left">
                                    <i class="fa fa-2x fa-thumbs-up text-col-yellow"></i>
                                </div>
                                <div class="number float-right text-right">
                                    <h6>Umumiy qarzdorlik</h6>
                                    <span class="font700">{{number_format($dolg,2)}}</span>
                                </div>
                            </div>
                            <div class="progress progress-xs progress-transparent custom-color-yellow mb-0 mt-3">
                                <div class="progress-bar" data-transitiongoal="75"></div>
                            </div>
                            <small class="text-muted">19% compared to last week</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-lg-2 col-md-3 col-sm-6">
            <div id="Summary1" class="carousel slide" data-ride="carousel" data-interval="3000">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="card bg-success text-center">
                            <div class="body">
                                <input type="text" class="knob2" value="82" data-width="69" data-height="69" data-thickness="0.07" data-bgColor="#2e9a4a" data-fgColor="#ffffff" readonly>
                                <h4 class="font-22 text-col-white mt-4">
                                    <small class="font-12 d-block mb-1"><i class="fa fa-caret-up"></i> 15%</small>
                                    Lead
                                    <span class="d-block font-13 mt-1">Last Week</span>
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="card bg-warning text-center">
                            <div class="body">
                                <input type="text" class="knob2" value="67" data-width="69" data-height="69" data-thickness="0.07" data-bgColor="#e8a70c" data-fgColor="#ffffff" readonly>
                                <h4 class="font-22 text-col-white mt-4">
                                    <small class="font-12 d-block mb-1"><i class="fa fa-caret-up"></i> $95 M</small>
                                    Ballance
                                    <span class="d-block font-13 mt-1">Last Month</span>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>                    
        </div>
        <div class="col-lg-2 col-md-3 col-sm-6">
            <div id="Summary2" class="carousel slide" data-ride="carousel" data-interval="3000">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="card text-center">
                            <div class="body">
                                <input type="text" class="knob2" value="60" data-width="69" data-height="69" data-thickness="0.07" data-bgColor="#eceeef" data-fgColor="#2e9a4a" readonly>
                                <h4 class="font-22 mt-4">
                                    <small class="font-12 d-block mb-1"><i class="fa fa-caret-up"></i> 25%</small>
                                    Sales
                                    <span class="d-block font-13 mt-1">Last Week</span>
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="card bg-dark text-center">
                            <div class="body">
                                <input type="text" class="knob2" value="73" data-width="69" data-height="69" data-thickness="0.07" data-bgColor="#434b52" data-fgColor="#2e9a4a" readonly>
                                <h4 class="font-22 text-col-white mt-4">
                                    <small class="font-12 d-block mb-1"><i class="fa fa-caret-up"></i> 40K</small>
                                    Profits
                                    <span class="d-block font-13 mt-1">Last Month</span>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card text-center">
                <div class="header">
                    <h2>Connection</h2>
                </div>
                <div class="body pt-0">
                    <div class="row">
                        <div class="col-12 m-b-15">
                            <h1><i class="icon-user"></i></h1>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <h4 class="font-22 text-col-green font-weight-bold">
                                <small class="font-12 text-col-dark d-block m-b-10">Following</small>
                                1255
                            </h4>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <h4 class="font-22 text-col-blue font-weight-bold">
                                <small class="font-12 text-col-dark d-block m-b-10">Followers</small>
                                3650
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5 col-md-12 col-sm-12">
            <div class="card overflowhidden">
                <div class="header">
                    <h2>Analysis</h2>
                    <ul class="header-dropdown">
                        <li> <a href="javascript:void(0);" data-toggle="cardloading" data-loading-effect="pulse"><i class="icon-refresh"></i></a></li>
                        <li><a href="javascript:void(0);" class="full-screen"><i class="icon-size-fullscreen"></i></a></li>
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"></a>
                            <ul class="dropdown-menu dropdown-menu-right animated bounceIn">
                                <li><a href="javascript:void(0);">Action</a></li>
                                <li><a href="javascript:void(0);">Another Action</a></li>
                                <li><a href="javascript:void(0);">Something else</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <div class="row text-center">
                        <div class="col-4">
                            <h4>2598 <span class="font-13 d-block mt-2">New York</span></h4>
                        </div>
                        <div class="col-4 border-left border-right">
                            <h4>8547 <span class="font-13 d-block mt-2">France</span></h4>
                        </div>
                        <div class="col-4">
                            <h4>2707 <span class="font-13 d-block mt-2">Canada</span></h4>
                        </div>
                    </div>
                </div>
                <div class="sparkline" data-type="bar" data-offset="90" data-width="97%" data-height="50px" data-bar-Width="10" data-bar-Spacing="10" data-bar-Color="#7cb5ec">4,8,0,3,1,8,5,4,0,5,4,3,2,1,5,6,7,8,4,5,8,0,3</div>
            </div>
        </div>
    </div>
    
</div>

@endsection

@section('scritps')
@endsection

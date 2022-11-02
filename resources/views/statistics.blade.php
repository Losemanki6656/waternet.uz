@extends('layouts.master')

@section('content')
    <link rel="stylesheet" href="/assets/vendor/morrisjs/morris.css" />


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
                                        <h6>Bugungi balans</h6>
                                        <span class="font700">{{ number_format($soldsumm, 2) }}</span>
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
                                        <h6>Naqd va plastik savdolari</h6>
                                        <span class="font700">{{ number_format($x, 2) }}</span>
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
                                        <h6>Oldindan to'lovlar</h6>
                                        <span class="font700">{{ number_format($pered, 2) }}</span>
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
                                        <span class="font700">{{ number_format($dolg, 2) }}</span>
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
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card text-center bg-info">
                    <div class="body">
                        <div class="p-15 text-light">
                            <h3>{{ $clients }}</h3>
                            <span>Mijozlar soni</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card text-center bg-dark">
                    <div class="body">
                        <div class="p-15 text-light">
                            <h3>{{ $users }}</h3>
                            <span>Foydalanuvchilar soni</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card text-center bg-warning">
                    <div class="body">
                        <div class="p-15 text-light">
                            <h3>1,025</h3>
                            <span>Feeds</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div id="Summary1" class="carousel slide" data-ride="carousel" data-interval="3000">
                    <div class="carousel-inner">

                        @foreach ($products as $product)
                            @if ($loop->index == 0)
                                <div class="carousel-item active">
                                    <div class="card text-center bg-primary">
                                        <div class="body">
                                            <div class="p-15 text-light">
                                                <h3>{{ $product->product_count }}</h3>
                                                <span>{{ $product->name }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="carousel-item">
                                    <div class="card text-center l-green">
                                        <div class="body">
                                            <div class="p-15 text-dark">
                                                <h3>{{ $product->product_count }}</h3>
                                                <span>{{ $product->name }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach


                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-6">
                <div class="card">
                    <div class="body">
                        <div id="line_chart"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-6">
                <div class="card">
                    <div class="body">
                        <div id="order_chart"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('scripts')
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="{{ asset('assets/bundles/vendorscripts.bundle.js') }}"></script>
    <script src="/assets/bundles/libscripts.bundle.js"></script>
    <script src="/assets/bundles/vendorscripts.bundle.js"></script>
    <script src="/assets/bundles/morrisscripts.bundle.js"></script>
    <script src="/assets/bundles/mainscripts.bundle.js"></script>
    <script src="/assets/bundles/morrisscripts.bundle.js"></script>

    <script>
        var options = {
            series: {!! json_encode($series1) !!},
            chart: {
                type: 'bar',
                height: 350
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: {!! json_encode($categories) !!},
            },
            yaxis: {
                title: {
                    text: '$ (thousands)'
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return "" + val + ""
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#order_chart"), options);
        chart.render();
    </script>
    <script>
        var options = {
            series: {!! json_encode($series) !!},
            chart: {
                height: 350,
                type: 'line',
                dropShadow: {
                    enabled: true,
                    color: '#000',
                    top: 18,
                    left: 7,
                    blur: 10,
                    opacity: 0.2
                },
                toolbar: {
                    show: false
                }
            },
            colors: ['#007ACC', '#F47D01', '#19E6A0', '#C6EEF4', '#FF575A'],
            dataLabels: {
                enabled: true,
            },
            stroke: {
                curve: 'smooth'
            },
            title: {
                text: 'Oxirgi xaftadagi pul tushumlari',
                align: 'left'
            },
            grid: {
                borderColor: '#e7e7e7',
                row: {
                    colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                    opacity: 0.5
                },
            },
            markers: {
                size: 1
            },
            xaxis: {
                categories: {!! json_encode($categories) !!},
                title: {
                    text: 'Sanalar'
                }
            },
            yaxis: {
                title: {
                    text: 'Pul miqdorlari'
                },
                min: 0,
                max: {!! $maxsum !!}
            },
            legend: {
                position: 'top',
                horizontalAlign: 'right',
                floating: true,
                offsetY: -25,
                offsetX: -5
            }
        };

        var chart = new ApexCharts(document.querySelector("#line_chart"), options);
        chart.render();
    </script>

    <script>
        $(function() {
            "use strict";
            MorrisDonutChart();
        });
    </script>
    <script>
        function MorrisDonutChart() {
            Morris.Donut({
                element: 'm_donut_chart',
                data: [{
                    label: "Online Sales",
                    value: 45,

                }, {
                    label: "Store Sales",
                    value: 35
                }, {
                    label: "Email Sales",
                    value: 8
                }, {
                    label: "Agent Sales",
                    value: 12
                }],

                resize: true,
                colors: ['#2cbfb7', '#3dd1c9', '#60ded7', '#a1ece8']
            });
        }
    </script>
@endsection

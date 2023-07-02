@extends('layouts.v2_master')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ __('messages.dashboard') }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('messages.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('messages.dashboard') }}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h5 class="mb-sm-0"> Results Today</h5>

                <div class="page-title-right">
                    <div class="row">
                        <div class="col">
                            <select name="" id="" class="form-select form-select-sm">
                                <option value="today">{{ __('messages.today') }}</option>
                                <option value="today">{{ __('messages.this_week') }}</option>
                                <option value="today">{{ __('messages.this_month') }}</option>
                                <option value="today">{{ __('messages.this_year') }}</option>
                            </select>
                        </div>
                        <div class="col">
                            <input type="text" style="width: 200px" class="form-control form-control-sm"
                                id="datepicker-range">
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <div class="row animate__animated animate__fadeInDown">
        <div class="col-xl-6 col-xxl-3 col-lg-6 col-md-6">
            <!-- card -->
            <div class="card card-h-100">
                <!-- card body -->
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <span
                                class="text-muted mb-3 lh-1 d-block text-truncate">{{ __('messages.total_amount') }}</span>
                            <h4 class="mb-3">
                                <span class="counter-value" data-target="{{ $amount }}">0</span> UZS
                            </h4>
                            <div class="text-nowrap">
                                <span class="badge bg-success-subtle text-success">100%</span>
                                <span class="ms-1 text-muted font-size-13">{{ __('messages.of_the_total_value') }}</span>
                            </div>
                        </div>

                        <div class="flex-shrink-0 text-end dash-widget">
                            <div id="mini-chart1" data-colors='["--bs-primary", "--bs-success"]' class="apex-charts">
                            </div>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

        <div class="col-xl-6 col-xxl-3 col-lg-6 col-md-6">
            <!-- card -->
            <div class="card card-h-100">
                <!-- card body -->
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <span class="text-muted mb-3 lh-1 d-block text-truncate">{{ __('messages.total_cash') }}</span>
                            <h4 class="mb-3">
                                <span class="counter-value" data-target="{{ $amount_cash }}">0</span> UZS
                            </h4>
                            <div class="text-nowrap">
                                <span class="badge bg-danger-subtle text-danger">-29 Trades</span>
                                <span class="ms-1 text-muted font-size-13">{{ __('messages.of_the_total_value') }}</span>
                            </div>
                        </div>
                        <div class="flex-shrink-0 text-end dash-widget">
                            <div id="mini-chart2" data-colors='["--bs-primary", "--bs-success"]' class="apex-charts">
                            </div>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col-->

        <div class="col-xl-6 col-xxl-3 col-lg-6 col-md-6">
            <!-- card -->
            <div class="card card-h-100">
                <!-- card body -->
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <span class="text-muted mb-3 lh-1 d-block text-truncate">{{ __('messages.total_card') }}</span>
                            <h4 class="mb-3">
                                <span class="counter-value" data-target="{{ $amount_card }}">0</span>UZS
                            </h4>
                            <div class="text-nowrap">
                                <span class="badge bg-success-subtle text-success">+ $2.8k</span>
                                <span class="ms-1 text-muted font-size-13">{{ __('messages.of_the_total_value') }}</span>
                            </div>
                        </div>
                        <div class="flex-shrink-0 text-end dash-widget">
                            <div id="mini-chart3" data-colors='["--bs-primary", "--bs-success"]' class="apex-charts">
                            </div>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

        <div class="col-xl-6 col-xxl-3 col-lg-6 col-md-6">
            <!-- card -->
            <div class="card card-h-100">
                <!-- card body -->
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <span
                                class="text-muted mb-3 lh-1 d-block text-truncate">{{ __('messages.total_transfer') }}</span>
                            <h4 class="mb-3">
                                <span class="counter-value" data-target="{{ $amount_transfer }}">0</span> UZS
                            </h4>
                            <div class="text-nowrap">
                                <span class="badge bg-success-subtle text-success">+5.32%</span>
                                <span class="ms-1 text-muted font-size-13">{{ __('messages.of_the_total_value') }}</span>
                            </div>
                        </div>
                        <div class="flex-shrink-0 text-end dash-widget">
                            <div id="mini-chart4" data-colors='["--bs-primary", "--bs-success"]' class="apex-charts">
                            </div>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div>
    <div class="row animate__animated animate__fadeInDown">
        <div class="col-xl-6 col-xxl-3 col-lg-6 col-md-6">
            <!-- card -->
            <div class="card card-h-100">
                <!-- card body -->
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <span class="text-muted mb-3 lh-1 d-block text-truncate">{{ __('messages.total_debt') }}</span>
                            <h4 class="mb-3">
                                <span class="counter-value" data-target="{{ $debt }}">0</span> UZS
                            </h4>
                            <div class="text-nowrap">
                                <span class="badge bg-success-subtle text-success">100%</span>
                                <span class="ms-1 text-muted font-size-13">{{ __('messages.of_the_total_value') }}</span>
                            </div>
                        </div>

                        <div class="flex-shrink-0 text-end dash-widget">
                            <div id="mini-chart1" data-colors='["--bs-primary", "--bs-success"]' class="apex-charts">
                            </div>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

        <div class="col-xl-6 col-xxl-3 col-lg-6 col-md-6">
            <!-- card -->
            <div class="card card-h-100">
                <!-- card body -->
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <span
                                class="text-muted mb-3 lh-1 d-block text-truncate">{{ __('messages.total_other') }}</span>
                            <h4 class="mb-3">
                                <span class="counter-value" data-target="{{ $amount_cash }}">0</span> UZS
                            </h4>
                            <div class="text-nowrap">
                                <span class="badge bg-danger-subtle text-danger">-29 Trades</span>
                                <span class="ms-1 text-muted font-size-13">{{ __('messages.of_the_total_value') }}</span>
                            </div>
                        </div>
                        <div class="flex-shrink-0 text-end dash-widget">
                            <div id="mini-chart2" data-colors='["--bs-primary", "--bs-success"]' class="apex-charts">
                            </div>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col-->

        <div class="col-xl-6 col-xxl-3 col-lg-6 col-md-6">
            <!-- card -->
            <div class="card card-h-100">
                <!-- card body -->
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <span
                                class="text-muted mb-3 lh-1 d-block text-truncate">{{ __('messages.given_order') }}</span>
                            <h4 class="mb-3">
                                <span class="counter-value" data-target="{{ $amount_card }}">0</span>
                            </h4>
                            <div class="text-nowrap">
                                <span class="badge bg-success-subtle text-success">+ $2.8k</span>
                                <span class="ms-1 text-muted font-size-13">{{ __('messages.of_the_total_value') }}</span>
                            </div>
                        </div>
                        <div class="flex-shrink-0 text-end dash-widget">
                            <div id="mini-chart3" data-colors='["--bs-primary", "--bs-success"]' class="apex-charts">
                            </div>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

        <div class="col-xl-6 col-xxl-3 col-lg-6 col-md-6">
            <!-- card -->
            <div class="card card-h-100">
                <!-- card body -->
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <span
                                class="text-muted mb-3 lh-1 d-block text-truncate">{{ __('messages.sold_product') }}</span>
                            <h4 class="mb-3">
                                <span class="counter-value" data-target="{{ $amount_transfer }}">0</span>
                            </h4>
                            <div class="text-nowrap">
                                <span class="badge bg-success-subtle text-success">+5.32%</span>
                                <span class="ms-1 text-muted font-size-13">{{ __('messages.of_the_total_value') }}</span>
                            </div>
                        </div>
                        <div class="flex-shrink-0 text-end dash-widget">
                            <div id="mini-chart4" data-colors='["--bs-primary", "--bs-success"]' class="apex-charts">
                            </div>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div>

    <div class="row animate__animated animate__fadeInDown">
        <div class="col-xl-5">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Selling Products</h4>
                    <div class="flex-shrink-0">
                    </div>

                </div><!-- end card header -->

                <div class="card-body px-0 pt-2">
                    <div class="table-responsive px-3" data-simplebar style="max-height: 395px;">
                        <table class="table align-middle table-nowrap">
                            <tbody>
                                @foreach ($tableUser as $item)
                                    <tr>
                                        <td>
                                            <div class="avatar-md">
                                                <img src="{{ asset('assets/images/user.jpg') }}" class="img-fluid">
                                            </div>
                                        </td>

                                        <td>
                                            <div>
                                                <h5 class="font-size-15"><a href="#"
                                                        class="text-dark">{{ $item['name'] }}</a></h5>
                                                <span class="text-muted">{{ $item['role'] }}</span>
                                            </div>
                                        </td>

                                        <td>
                                            <p class="mb-1"><a href="#"
                                                    class="text-dark">{{ __('messages.given_product') }}</a></p>
                                            <span class="text-muted">{{ $item['takeProd'] }}</span>
                                        </td>
                                        <td>
                                            <p class="mb-1"><a href="#"
                                                    class="text-dark">{{ __('messages.given_tara') }}</a></p>
                                            <span class="text-muted">{{ $item['ectryCon'] }}</span>
                                        </td>

                                        <td>
                                            <div class="text-end">
                                                <ul class="mb-1 ps-0">
                                                    <li class="bx bxs-star text-warning"></li>
                                                    <li class="bx bxs-star text-warning"></li>
                                                    <li class="bx bxs-star text-warning"></li>
                                                    <li class="bx bxs-star text-warning"></li>
                                                    <li class="bx bxs-star text-warning"></li>
                                                </ul>
                                                <span class="text-muted mt-1">{{ $item['suc_order'] }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var barchartColors = getChartColorsArray("#mini-chart1"),
            options = {
                series: [{{ $amount }}, 0],
                chart: {
                    type: "donut",
                    height: 110
                },
                colors: barchartColors,
                legend: {
                    show: !1
                },
                dataLabels: {
                    enabled: !1
                }
            },
            chart = new ApexCharts(document.querySelector("#mini-chart1"), options).render();
    </script>
    <script>
        var barchartColors = getChartColorsArray("#mini-chart2"),
            options = {
                series: [{{ $amount }}, {{ $amount_cash }}],
                chart: {
                    type: "donut",
                    height: 110
                },
                colors: barchartColors,
                legend: {
                    show: !1
                },
                dataLabels: {
                    enabled: !1
                }
            },
            chart = new ApexCharts(document.querySelector("#mini-chart2"), options).render();
    </script>
    <script>
        var barchartColors = getChartColorsArray("#mini-chart3"),
            options = {
                series: [{{ $amount }}, {{ $amount_card }}],
                chart: {
                    type: "donut",
                    height: 110
                },
                colors: barchartColors,
                legend: {
                    show: !1
                },
                dataLabels: {
                    enabled: !1
                }
            },
            chart = new ApexCharts(document.querySelector("#mini-chart3"), options).render();
    </script>
    <script>
        var barchartColors = getChartColorsArray("#mini-chart4"),
            options = {
                series: [{{ $amount }}, {{ $amount_transfer }}],
                chart: {
                    type: "donut",
                    height: 110
                },
                colors: barchartColors,
                legend: {
                    show: !1
                },
                dataLabels: {
                    enabled: !1
                }
            },
            chart = new ApexCharts(document.querySelector("#mini-chart4"), options).render();
    </script>
    <script>
        flatpickr("#datepicker-range", {
            mode: "range",
            defaultDate: new Date
        })
    </script>
@endsection

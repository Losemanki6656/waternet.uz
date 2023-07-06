@extends('layouts.v2_master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ __('messages.results') }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('messages.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('messages.results') }}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <div class="row mb-3 animate__animated animate__fadeInUp">
        <div class="accordion" id="accordionExample">
            <div class="accordion-item rounded-3">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse"
                        id="accorButton" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                        {{ __('messages.old_version_result') }}
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="table-responsive">
                            <table class="table align-middle table-bordered table-nowrap" id="table">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center fw-bold">{{ __('messages.fullname') }}</th>
                                        <th class="text-center fw-bold">{{ __('messages.role') }}</th>
                                        <th class="text-center fw-bold">{{ __('messages.given_order') }}</th>
                                        <th class="text-center fw-bold">{{ __('messages.given_product') }}</th>
                                        <th class="text-center fw-bold">{{ __('messages.sold_product') }}</th>
                                        <th class="text-center fw-bold">{{ __('messages.amount') }}</th>
                                        <th class="text-center fw-bold">{{ __('messages.given_container') }}</th>
                                        <th class="text-center fw-bold">{{ __('messages.returned_container') }}</th>
                                        <th class="text-center fw-bold">{{ __('messages.cash') }}</th>
                                        <th class="text-center fw-bold">{{ __('messages.card') }}</th>
                                        <th class="text-center fw-bold">{{ __('messages.transfer') }}</th>
                                        <th class="text-center fw-bold">{{ __('messages.debt') }}</th>
                                        <th class="text-center fw-bold">{{ __('messages.deposit') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td class="text-center fw-bold">
                                                {{ $user->name }}
                                            </td>
                                            <td class="text-center fw-bold">
                                                {{ $user->roleName() }}
                                            </td>
                                            <td class="text-center">
                                                <a
                                                    href="{{ route('result_orders', ['date1' => request('date1'), 'date2' => request('date2'), 'id' => $user->id]) }}">
                                                    {{ $order[$user->id] }}</a>
                                            </td>
                                            <td class="text-center">
                                                <a
                                                    href="{{ route('result_take', ['date1' => request('date1'), 'date2' => request('date2'), 'id' => $user->id]) }}">{{ $takeproduct[$user->id] }}</a>
                                            </td>
                                            <td class="text-center">
                                                <a
                                                    href="{{ route('resultsold', ['date1' => request('date1'), 'date2' => request('date2'), 'id' => $user->id]) }}">{{ $soldproducts[$user->id] }}</a>
                                            </td>
                                            <td class="text-center">
                                                <a
                                                    href="{{ route('summresult', ['date1' => request('date1'), 'date2' => request('date2'), 'id' => $user->id]) }}">{{ $soldsumm[$user->id] }}</a>
                                            </td>
                                            <td class="text-center">
                                                <a
                                                    href="{{ route('resultentrycontainer', ['date1' => request('date1'), 'date2' => request('date2'), 'id' => $user->id]) }}">{{ $entrycon[$user->id] }}</a>
                                            </td>
                                            <td class="text-center">
                                                {{ $takecon[$user->id] }}
                                            </td>
                                            <td class="text-center">
                                                <a
                                                    href="{{ route('payment1', ['date1' => request('date1'), 'date2' => request('date2'), 'id' => $user->id]) }}">{{ $payment1[$user->id] }}</a>
                                            </td>
                                            <td class="text-center">
                                                <a
                                                    href="{{ route('payment2', ['date1' => request('date1'), 'date2' => request('date2'), 'id' => $user->id]) }}">{{ $payment2[$user->id] }}</a>
                                            </td>
                                            <td class="text-center">
                                                <a
                                                    href="{{ route('payment3', ['date1' => request('date1'), 'date2' => request('date2'), 'id' => $user->id]) }}">{{ $payment3[$user->id] }}</a>
                                            </td>
                                            <td class="text-center">
                                                <a
                                                    href="{{ route('dolgresult', ['date1' => request('date1'), 'date2' => request('date2'), 'id' => $user->id]) }}">{{ $amount[$user->id] }}</a>
                                            </td>
                                            <td></td>
                                        </tr>
                                    @endforeach
                                    <td colspan="2" class="text-center fw-bold"> {{ __('messages.total') }}:</td>
                                    <td class="text-center fw-bold">{{ $summorder }}</td>
                                    <td class="text-center fw-bold">{{ $summtakeproduct }}</td>
                                    <td class="text-center fw-bold">{{ $summsoldproducts }}</td>
                                    <td class="text-center fw-bold">{{ $summsoldsumm }}</td>
                                    <td class="text-center fw-bold">{{ $summentrycon }}</td>
                                    <td class="text-center fw-bold">{{ $takesumm }}</td>
                                    <td class="text-center fw-bold">{{ $summpayment1 }}</td>
                                    <td class="text-center fw-bold">{{ $summpayment2 }}</td>
                                    <td class="text-center fw-bold">{{ $summpayment3 }}</td>
                                    <td class="text-center fw-bold">{{ $dolgsumm }}</td>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row  animate__animated animate__fadeInUp">
        <div class="col-xl-2 col-md-6">
            <div class="card rounded-3">
                <div class="card-body">
                    <div>
                        <h5 class="mb-3">{{ __('messages.cash') }}</h5>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="avatar-md">
                                <a class="avatar-title bg-success-subtle text-success font-size-20 rounded-3"
                                    href="#"><i class="mdi mdi-arrow-top-right"></i></a>
                            </div>
                            <h5 class="mb-0">{{ $summpayment1 }}</h5>

                        </div>

                    </div>

                </div>
                <!--end card body-->
            </div>
            <!--end card-->
        </div>
        <!--end col-->
        <div class="col-xl-2 ms-md-auto col-md-6">
            <div class="card rounded-3">
                <div class="card-body">
                    <div>
                        <h5 class="mb-3">{{ __('messages.card') }}</h5>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="avatar-md">
                                <a class="avatar-title bg-danger-subtle text-danger font-size-20 rounded-3"
                                    href="#"><i class="mdi mdi-arrow-bottom-left"></i></a>
                            </div>
                            <h5 class="mb-0">{{ $summpayment2 }}</h5>
                        </div>
                    </div>
                </div>
                <!--end card body-->
            </div>
            <!--end card-->
        </div>
        <!--end col-->
        <div class="col-xl-2 ms-md-auto col-md-6">
            <div class="card rounded-3">
                <div class="card-body">
                    <div>
                        <h5 class="mb-3">{{ __('messages.transfer') }}</h5>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="avatar-md">
                                <a class="avatar-title bg-info-subtle text-info font-size-20 rounded-3" href="#"><i
                                        class="mdi mdi-currency-usd"></i></a>
                            </div>
                            <h5 class="mb-0">{{ $summpayment3 }}</h5>
                        </div>
                    </div>
                </div>
                <!--end card body-->
            </div>
            <!--end card-->
        </div>
        <!--end col-->
        <div class="col-xl-2 ms-md-auto col-md-6">
            <div class="card rounded-3">
                <div class="card-body">
                    <div>
                        <h5 class="mb-3">{{ __('messages.debt') }}</h5>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="avatar-md">
                                <a class="avatar-title bg-primary-subtle text-primary font-size-20 rounded-3"
                                    href="#"><i class="mdi mdi-email-outline"></i></a>
                            </div>
                            <h5 class="mb-0">{{ $dolgsumm }}</h5>
                            {{-- <p class="fw-bold mb-0">{{ $summsoldsumm }}</p> --}}
                        </div>
                    </div>
                </div>
                <!--end card body-->
            </div>
            <!--end card-->
        </div>
        <div class="col-xl-2 ms-md-auto col-md-6">
            <div class="card rounded-3">
                <div class="card-body">
                    <div>
                        <h5 class="mb-3">{{ __('messages.debt') }}</h5>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="avatar-md">
                                <a class="avatar-title bg-warning-subtle text-warning font-size-20 rounded-3"
                                    href="#"><i class="mdi mdi-arrow-top-right"></i></a>
                            </div>
                            <h5 class="mb-0">{{ $otherSumm ?? 0 }}</h5>
                            {{-- <p class="fw-bold mb-0">{{ $summsoldsumm }}</p> --}}
                        </div>
                    </div>
                </div>
                <!--end card body-->
            </div>
            <!--end card-->
        </div>
        <div class="col-xl-2 ms-md-auto col-md-6">
            <div class="card rounded-3">
                <div class="card-body">
                    <div>
                        <h5 class="mb-3">{{ __('messages.total') }}</h5>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="avatar-md">
                                <a class="avatar-title bg-danger-subtle text-danger font-size-20 rounded-3"
                                    href="#"><i class="mdi mdi-arrow-top-left"></i></a>
                            </div>
                            <h5 class="mb-0">{{ $summsoldsumm }}</h5>
                            {{-- <p class="fw-bold mb-0">{{ $summsoldsumm }}</p> --}}
                        </div>
                    </div>
                </div>
                <!--end card body-->
            </div>
            <!--end card-->
        </div>
        <!--end col-->

    </div>

    <div class="row  animate__animated animate__fadeInUp">
        <div class="col-xl-3 col-lg-4">
            <div class="card rounded-3">
                <form action="{{ route('results') }}" method="get">
                    @csrf
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-xxl-6 col-xl-12 col-lg-12 col-sm-12 col-md-12">
                                <input type="date" value="{{ request('date1', now()->format('Y-m-d')) }}"
                                    id="date1" name="date1" class="form-control">
                            </div>
                            <div class="col-xxl-6 col-xl-12 col-lg-12 col-sm-12 col-md-12">
                                <input type="date" value="{{ request('date2', now()->format('Y-m-d')) }}"
                                    id="date2" name="date2" class="form-control">
                            </div>
                        </div>
                        <div class="d-grid">
                            <button class="btn font-16 btn-primary" type="submit" id="btn-new-event"><i
                                    class="mdi mdi-plus-circle-outline"></i> {{ __('messages.filtr') }}
                            </button>
                        </div>

                        <div id="external-events" class="">
                            <br>
                            @foreach ($data as $user)
                                <div class="external-event mb-2 text-{{ $color[$user->id] }} bg-{{ $color[$user->id] }}-subtle rounded-3"
                                    data-class="bg-{{ $color[$user->id] }}">
                                    <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>
                                    <input class="form-check-input me-2" type="radio" name="formRadios"
                                        @if (request('formRadios') == $user->id) checked @endif value="{{ $user->id }}"
                                        id="formRadios{{ $user->id }}">
                                    <label class="form-check-label" for="formRadios{{ $user->id }}">
                                        {{ $user->name }}
                                    </label>

                                </div>
                            @endforeach
                            <div class="external-event mb-2 text-success bg-success-subtle rounded-3"
                                data-class="bg-success">
                                <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>
                                <input class="form-check-input me-2" type="radio" name="formRadios" id="formRadios"
                                    @if (!request('formRadios')) checked @endif value="">
                                <label class="form-check-label" for="formRadios">
                                    {{ __('messages.all') }}
                                </label>

                            </div>
                        </div>

                        <div class="row justify-content-center mt-2">
                            <div class="col-lg-12 col-sm-6">
                                <img src="{{ asset('assets/images/undraw-calendar.svg') }}" alt=""
                                    class="img-fluid d-block">
                            </div>
                        </div>

                    </div>

                </form>
            </div>
        </div>

        <div class="col-xl-9 col-lg-4">
            <!--end row-->

            {{-- <div class="row">
                <div class="col-xl-4 col-md-4">
                    <div class="card rounded-3">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Bar Chart</h4>
                        </div>
                        <div class="card-body">
                            <div id="given_or"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-4">
                    <div class="card rounded-3">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Bar Chart</h4>
                        </div>
                        <div class="card-body">
                            <div id="given_prod"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-4">
                    <div class="card rounded-3">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Bar Chart</h4>
                        </div>
                        <div class="card-body">
                            <div id="given_prod"></div>
                        </div>
                    </div>
                </div>
                <!--end col-->
            </div> --}}

            <div class="row">
                <div class="col-xl-12">
                    <div class="card rounded-3">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Chart</h4>
                        </div>
                        <div class="card-body">
                            <div id="chart"></div>
                        </div>
                    </div>
                </div>
                <!--end col-->
            </div>

            {{-- <div class="row">
                <div class="col-xl-12">
                    <div class="card rounded-3">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Top Transection</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-responsive table-striped">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Avalibility</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Domain</td>
                                        <td>120 in stock</td>
                                        <td>$29,192</td>
                                    </tr>
                                    <tr>
                                        <td>Market implements</td>
                                        <td>10 in stock</td>
                                        <td>$19,100</td>
                                    </tr>
                                    <tr>
                                        <td>Local business</td>
                                        <td>3 in stock</td>
                                        <td>$10,000</td>
                                    </tr>
                                    <tr>
                                        <td>Salary payments</td>
                                        <td>3 in stock</td>
                                        <td>$50,000</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="text-center">
                                <a href="#" class="btn btn-soft-secondary btn-sm">See more</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end col-->
            </div> --}}
        </div>

    </div>

    <style>
        .highcharts-background {
            fill: transparent;
        }
    </style>
@endsection



@section('scripts')
    {{-- <script src="https://code.highcharts.com/highcharts.js"></script> --}}
    <script>
        $(document).ready(function() {
            let z = localStorage.getItem('accorButton');
            if (z == 'show') {
                $('#accorButton').removeClass('collapsed');
                $('#collapseOne').addClass('show');
            } else {
                $('#accorButton').addClass('collapsed');
                $('#collapseOne').removeClass('show');
            }

            $('#accorButton').click(function(e) {
                let x = localStorage.getItem('accorButton');
                if (x != 'show') {
                    localStorage.setItem('accorButton', 'show');
                } else {
                    localStorage.setItem('accorButton', 'hide');
                }

            });
        });
    </script>

    <script>
        var options = {
            series: [44, 55, 67, 83],
            chart: {
                height: 200,
                type: 'radialBar',
            },
            plotOptions: {
                radialBar: {
                    dataLabels: {
                        name: {
                            fontSize: '22px',
                        },
                        value: {
                            fontSize: '16px',
                        },
                        total: {
                            show: true,
                            label: 'Total',
                            formatter: function(w) {
                                return 249
                            }
                        }
                    }
                }
            },
            labels: ['Apples', 'Oranges', 'Bananas', 'Berries'],
        };

        var chart = new ApexCharts(document.querySelector("#given_or"), options);
        chart.render();
    </script>

    <script>
        var options = {
            series: [44, 55, 67, 83],
            chart: {
                height: 200,
                type: 'radialBar',
            },
            plotOptions: {
                radialBar: {
                    dataLabels: {
                        name: {
                            fontSize: '22px',
                        },
                        value: {
                            fontSize: '16px',
                        },
                        total: {
                            show: true,
                            label: 'Total',
                            formatter: function(w) {
                                return 249
                            }
                        }
                    }
                }
            },
            labels: ['Apples', 'Oranges', 'Bananas', 'Berries'],
        };

        var chart = new ApexCharts(document.querySelector("#given_prod"), options);
        chart.render();
    </script>

    <script>
        var series = @php echo $dataUser; @endphp;
        var categories = @php echo $categories; @endphp;
        var options = {
            series: series,
            chart: {
                type: 'bar',
                height: 440
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
                categories: categories,
            },
            yaxis: {
                title: {
                    text: ''
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    </script>
@endsection

@extends('layouts.v2_master')
@section('content')

    {{-- Page Title --}}
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ __('messages.results') }}</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">{{ __('messages.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('messages.results') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    {{-- Summary Stat Cards --}}
    <div class="row g-3 mb-3 animate__animated animate__fadeInUp">
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card rounded-3 h-100 mb-0">
                <div class="card-body">
                    <h6 class="text-muted mb-2">{{ __('messages.cash') }}</h6>
                    <div class="d-flex align-items-center gap-3">
                        <span class="avatar-sm rounded-3 d-flex align-items-center justify-content-center bg-success-subtle text-success fs-4">
                            <i class="mdi mdi-cash"></i>
                        </span>
                        <h5 class="mb-0 fw-bold">{{ number_format($summpayment1, 0, '.', ' ') }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card rounded-3 h-100 mb-0">
                <div class="card-body">
                    <h6 class="text-muted mb-2">{{ __('messages.card') }}</h6>
                    <div class="d-flex align-items-center gap-3">
                        <span class="avatar-sm rounded-3 d-flex align-items-center justify-content-center bg-danger-subtle text-danger fs-4">
                            <i class="mdi mdi-credit-card-outline"></i>
                        </span>
                        <h5 class="mb-0 fw-bold">{{ number_format($summpayment2, 0, '.', ' ') }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card rounded-3 h-100 mb-0">
                <div class="card-body">
                    <h6 class="text-muted mb-2">{{ __('messages.transfer') }}</h6>
                    <div class="d-flex align-items-center gap-3">
                        <span class="avatar-sm rounded-3 d-flex align-items-center justify-content-center bg-info-subtle text-info fs-4">
                            <i class="mdi mdi-bank-transfer"></i>
                        </span>
                        <h5 class="mb-0 fw-bold">{{ number_format($summpayment3, 0, '.', ' ') }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card rounded-3 h-100 mb-0">
                <div class="card-body">
                    <h6 class="text-muted mb-2">{{ __('messages.debt') }}</h6>
                    <div class="d-flex align-items-center gap-3">
                        <span class="avatar-sm rounded-3 d-flex align-items-center justify-content-center bg-warning-subtle text-warning fs-4">
                            <i class="mdi mdi-alert-circle-outline"></i>
                        </span>
                        <h5 class="mb-0 fw-bold">{{ number_format($dolgsumm, 0, '.', ' ') }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card rounded-3 h-100 mb-0">
                <div class="card-body">
                    <h6 class="text-muted mb-2">{{ __('messages.deposit') }}</h6>
                    <div class="d-flex align-items-center gap-3">
                        <span class="avatar-sm rounded-3 d-flex align-items-center justify-content-center bg-primary-subtle text-primary fs-4">
                            <i class="mdi mdi-wallet-outline"></i>
                        </span>
                        <h5 class="mb-0 fw-bold">{{ number_format($otherSumm, 0, '.', ' ') }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card rounded-3 h-100 mb-0">
                <div class="card-body">
                    <h6 class="text-muted mb-2">{{ __('messages.total') }}</h6>
                    <div class="d-flex align-items-center gap-3">
                        <span class="avatar-sm rounded-3 d-flex align-items-center justify-content-center bg-dark-subtle text-dark fs-4">
                            <i class="mdi mdi-sigma"></i>
                        </span>
                        <h5 class="mb-0 fw-bold">{{ number_format($summsoldsumm, 0, '.', ' ') }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter + Chart --}}
    <div class="row animate__animated animate__fadeInUp">

        {{-- Left: Filter panel --}}
        <div class="col-xl-3 col-lg-4">
            <div class="card rounded-3">
                <form action="{{ route('results') }}" method="get">
                    <div class="card-body">
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label small text-muted">{{ __('messages.date_from') ?? 'Dan' }}</label>
                                <input type="date" value="{{ request('date1', now()->format('Y-m-d')) }}"
                                       id="date1" name="date1" class="form-control form-control-sm">
                            </div>
                            <div class="col-6">
                                <label class="form-label small text-muted">{{ __('messages.date_to') ?? 'Gacha' }}</label>
                                <input type="date" value="{{ request('date2', now()->format('Y-m-d')) }}"
                                       id="date2" name="date2" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="d-grid mb-3">
                            <button class="btn btn-primary btn-sm" type="submit">
                                <i class="mdi mdi-filter-outline me-1"></i>{{ __('messages.filtr') }}
                            </button>
                        </div>

                        <p class="text-muted small mb-2">{{ __('messages.employee') ?? 'Xodim' }}</p>
                        <div id="external-events">
                            @foreach ($data as $user)
                                <div class="d-flex align-items-center mb-2 p-2 rounded-3 bg-{{ $color[$user->id] }}-subtle">
                                    <input class="form-check-input me-2 flex-shrink-0" type="radio"
                                           name="formRadios"
                                           @if (request('formRadios') == $user->id) checked @endif
                                           value="{{ $user->id }}"
                                           id="formRadios{{ $user->id }}">
                                    <label class="form-check-label text-{{ $color[$user->id] }} fw-medium small"
                                           for="formRadios{{ $user->id }}">
                                        <i class="mdi mdi-circle-small me-1"></i>{{ $user->name }}
                                    </label>
                                </div>
                            @endforeach
                            <div class="d-flex align-items-center mb-2 p-2 rounded-3 bg-success-subtle">
                                <input class="form-check-input me-2 flex-shrink-0" type="radio"
                                       name="formRadios" id="formRadiosAll"
                                       @if (!request('formRadios')) checked @endif value="">
                                <label class="form-check-label text-success fw-medium small" for="formRadiosAll">
                                    <i class="mdi mdi-circle-small me-1"></i>{{ __('messages.all') }}
                                </label>
                            </div>
                        </div>

                        <div class="text-center mt-3">
                            <img src="{{ asset('assets/images/undraw-calendar.svg') }}" alt=""
                                 class="img-fluid" style="max-height:120px">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Right: Chart --}}
        <div class="col-xl-9 col-lg-8">
            <div class="card rounded-3 h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title mb-0">{{ __('messages.results') }}</h5>
                    <span class="badge bg-primary-subtle text-primary">
                        {{ request('date1', now()->format('d.m.Y')) }} — {{ request('date2', now()->format('d.m.Y')) }}
                    </span>
                </div>
                <div class="card-body">
                    <div id="chart"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Detailed Table (collapsible) --}}
    <div class="row mt-3 animate__animated animate__fadeInUp">
        <div class="col-12">
            <div class="accordion" id="accordionTable">
                <div class="accordion-item rounded-3">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button fw-medium collapsed" type="button"
                                data-bs-toggle="collapse" id="accorButton"
                                data-bs-target="#collapseOne" aria-expanded="false"
                                aria-controls="collapseOne">
                            <i class="mdi mdi-table me-2"></i>{{ __('messages.old_version_result') }}
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse"
                         aria-labelledby="headingOne" data-bs-parent="#accordionTable">
                        <div class="accordion-body p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover align-middle mb-0" id="table">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center">{{ __('messages.fullname') }}</th>
                                            <th class="text-center">{{ __('messages.role') }}</th>
                                            <th class="text-center">{{ __('messages.given_order') }}</th>
                                            <th class="text-center">{{ __('messages.given_product') }}</th>
                                            <th class="text-center">{{ __('messages.sold_product') }}</th>
                                            <th class="text-center">{{ __('messages.amount') }}</th>
                                            <th class="text-center">{{ __('messages.given_container') }}</th>
                                            <th class="text-center">{{ __('messages.returned_container') }}</th>
                                            <th class="text-center">{{ __('messages.cash') }}</th>
                                            <th class="text-center">{{ __('messages.card') }}</th>
                                            <th class="text-center">{{ __('messages.transfer') }}</th>
                                            <th class="text-center">{{ __('messages.debt') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td class="fw-semibold">{{ $user->name }}</td>
                                                <td class="text-center">
                                                    <span class="badge bg-secondary-subtle text-secondary">{{ $roles[$user->id] }}</span>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('result_orders', ['date1' => request('date1'), 'date2' => request('date2'), 'id' => $user->id]) }}">
                                                        {{ $order[$user->id] }}
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('result_take', ['date1' => request('date1'), 'date2' => request('date2'), 'id' => $user->id]) }}">
                                                        {{ $takeproduct[$user->id] }}
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('resultsold', ['date1' => request('date1'), 'date2' => request('date2'), 'id' => $user->id]) }}">
                                                        {{ $soldproducts[$user->id] }}
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('summresult', ['date1' => request('date1'), 'date2' => request('date2'), 'id' => $user->id]) }}">
                                                        {{ number_format($soldsumm[$user->id], 0, '.', ' ') }}
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('resultentrycontainer', ['date1' => request('date1'), 'date2' => request('date2'), 'id' => $user->id]) }}">
                                                        {{ $entrycon[$user->id] }}
                                                    </a>
                                                </td>
                                                <td class="text-center">{{ $takecon[$user->id] }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('payment1', ['date1' => request('date1'), 'date2' => request('date2'), 'id' => $user->id]) }}">
                                                        {{ number_format($payment1[$user->id], 0, '.', ' ') }}
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('payment2', ['date1' => request('date1'), 'date2' => request('date2'), 'id' => $user->id]) }}">
                                                        {{ number_format($payment2[$user->id], 0, '.', ' ') }}
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('payment3', ['date1' => request('date1'), 'date2' => request('date2'), 'id' => $user->id]) }}">
                                                        {{ number_format($payment3[$user->id], 0, '.', ' ') }}
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('dolgresult', ['date1' => request('date1'), 'date2' => request('date2'), 'id' => $user->id]) }}"
                                                       class="{{ $amount[$user->id] > 0 ? 'text-danger fw-semibold' : '' }}">
                                                        {{ number_format($amount[$user->id], 0, '.', ' ') }}
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr class="table-light fw-bold">
                                            <td colspan="2" class="text-center">{{ __('messages.total') }}</td>
                                            <td class="text-center">{{ $summorder }}</td>
                                            <td class="text-center">{{ $summtakeproduct }}</td>
                                            <td class="text-center">{{ $summsoldproducts }}</td>
                                            <td class="text-center">{{ number_format($summsoldsumm, 0, '.', ' ') }}</td>
                                            <td class="text-center">{{ $summentrycon }}</td>
                                            <td class="text-center">{{ $takesumm }}</td>
                                            <td class="text-center">{{ number_format($summpayment1, 0, '.', ' ') }}</td>
                                            <td class="text-center">{{ number_format($summpayment2, 0, '.', ' ') }}</td>
                                            <td class="text-center">{{ number_format($summpayment3, 0, '.', ' ') }}</td>
                                            <td class="text-center">{{ number_format($dolgsumm, 0, '.', ' ') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .highcharts-background { fill: transparent; }
        .avatar-sm {
            width: 2.5rem;
            height: 2.5rem;
            flex-shrink: 0;
        }
    </style>
@endsection

@section('scripts')
    <script>
        // Restore accordion state from localStorage
        $(document).ready(function () {
            if (localStorage.getItem('accorButton') === 'show') {
                $('#accorButton').removeClass('collapsed');
                $('#collapseOne').addClass('show');
            }
            $('#accorButton').on('click', function () {
                const isOpen = localStorage.getItem('accorButton') === 'show';
                localStorage.setItem('accorButton', isOpen ? 'hide' : 'show');
            });
        });
    </script>

    <script>
        var options = {
            series: @php echo $dataUser; @endphp,
            chart: {
                type: 'bar',
                height: 380,
                toolbar: { show: false },
                background: 'transparent'
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '50%',
                    borderRadius: 4
                }
            },
            dataLabels: { enabled: false },
            stroke: { show: true, width: 2, colors: ['transparent'] },
            xaxis: {
                categories: @php echo $categories; @endphp,
                labels: { style: { fontSize: '12px' } }
            },
            yaxis: { title: { text: '' } },
            fill: { opacity: 1 },
            legend: { position: 'top' },
            tooltip: {
                y: { formatter: function (val) { return val.toLocaleString(); } }
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    </script>
@endsection

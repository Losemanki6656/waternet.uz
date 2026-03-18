@extends('layouts.v2_master')

@section('styles')
<style>
    /* prevent animate.css from causing horizontal scrollbar */
    .main-content { overflow-x: hidden; }
</style>
@endsection

@section('content')

{{-- Page header --}}
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">{{ __('messages.dashboard') }}</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('messages.home') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('messages.dashboard') }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

{{-- Date filter bar --}}
<div class="row mb-3">
    <div class="col-12">
        <div class="card mb-0">
            <div class="card-body py-2 px-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
                <h6 class="mb-0 text-muted">
                    <i class="bx bx-calendar me-1"></i>
                    {{ $selectedDate->format('d.m.Y') }}
                    @if ($isToday)
                        <span class="badge bg-success-subtle text-success ms-1">{{ __('messages.today') }}</span>
                    @endif
                </h6>
                <div class="d-flex align-items-center gap-2">
                    @if (!$isToday)
                        <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bx bx-reset me-1"></i>{{ __('messages.today') }}
                        </a>
                    @endif
                    <input type="text" id="dashboard-date"
                           class="form-control form-control-sm"
                           style="width:160px"
                           value="{{ $selectedDate->format('d.m.Y') }}"
                           readonly>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ─── Row 1: Payment stats ─────────────────────────────────────────── --}}
@php
    $payCards = [
        [
            'label'   => __('messages.total_amount'),
            'value'   => $amount,
            'badge'   => '100%',
            'badge_class' => 'bg-primary-subtle text-primary',
            'icon'    => 'bx bx-money',
            'icon_bg' => 'bg-primary-subtle',
            'icon_color' => 'text-primary',
            'chart'   => 'chart-total',
            'series'  => [$amount, 0],
        ],
        [
            'label'   => __('messages.total_cash'),
            'value'   => $amount_cash,
            'badge'   => $pct_cash . '%',
            'badge_class' => 'bg-success-subtle text-success',
            'icon'    => 'bx bx-wallet',
            'icon_bg' => 'bg-success-subtle',
            'icon_color' => 'text-success',
            'chart'   => 'chart-cash',
            'series'  => [$amount_cash, max($amount - $amount_cash, 0)],
        ],
        [
            'label'   => __('messages.total_card'),
            'value'   => $amount_card,
            'badge'   => $pct_card . '%',
            'badge_class' => 'bg-info-subtle text-info',
            'icon'    => 'bx bx-credit-card',
            'icon_bg' => 'bg-info-subtle',
            'icon_color' => 'text-info',
            'chart'   => 'chart-card',
            'series'  => [$amount_card, max($amount - $amount_card, 0)],
        ],
        [
            'label'   => __('messages.total_transfer'),
            'value'   => $amount_transfer,
            'badge'   => $pct_transfer . '%',
            'badge_class' => 'bg-warning-subtle text-warning',
            'icon'    => 'bx bx-transfer',
            'icon_bg' => 'bg-warning-subtle',
            'icon_color' => 'text-warning',
            'chart'   => 'chart-transfer',
            'series'  => [$amount_transfer, max($amount - $amount_transfer, 0)],
        ],
    ];
@endphp

<div class="row g-3">
    @foreach ($payCards as $card)
    <div class="col-xl-6 col-xxl-3 col-lg-6 col-md-6">
        <div class="card card-h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <span class="text-muted mb-3 lh-1 d-block text-truncate font-size-13">{{ $card['label'] }}</span>
                        <h4 class="mb-2 fw-semibold">
                            {{ number_format($card['value'], 0, '.', ' ') }}
                            <small class="font-size-12 fw-normal text-muted">UZS</small>
                        </h4>
                        <div class="text-nowrap">
                            <span class="badge {{ $card['badge_class'] }}">{{ $card['badge'] }}</span>
                            <span class="ms-1 text-muted font-size-12">{{ __('messages.of_the_total_value') }}</span>
                        </div>
                    </div>
                    <div class="flex-shrink-0 ms-3">
                        <div class="avatar-sm rounded {{ $card['icon_bg'] }} d-flex align-items-center justify-content-center"
                             style="width:48px;height:48px">
                            <i class="{{ $card['icon'] }} font-size-22 {{ $card['icon_color'] }}"></i>
                        </div>
                        <div id="{{ $card['chart'] }}"
                             data-colors='["--bs-primary","--bs-light"]'
                             class="apex-charts mt-2"
                             data-series="{{ json_encode($card['series']) }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- ─── Row 2: Operational stats ────────────────────────────────────── --}}
@php
    $opCards = [
        [
            'label'      => __('messages.total_debt'),
            'value'      => number_format($debt, 0, '.', ' ') . ' UZS',
            'badge'      => $debt > 0 ? '⚠ ' . __('messages.today') : '✓ OK',
            'badge_class'=> $debt > 0 ? 'bg-danger-subtle text-danger' : 'bg-success-subtle text-success',
            'icon'       => 'bx bx-error-circle',
            'icon_bg'    => 'bg-danger-subtle',
            'icon_color' => 'text-danger',
        ],
        [
            'label'      => __('messages.total_other'),
            'value'      => number_format($amount_other, 0, '.', ' ') . ' UZS',
            'badge'      => $pct_other . '%',
            'badge_class'=> 'bg-secondary-subtle text-secondary',
            'icon'       => 'bx bx-dots-horizontal-rounded',
            'icon_bg'    => 'bg-secondary-subtle',
            'icon_color' => 'text-secondary',
        ],
        [
            'label'      => __('messages.given_order'),
            'value'      => number_format($orders_count, 0, '.', ' '),
            'badge'      => __('messages.today'),
            'badge_class'=> 'bg-success-subtle text-success',
            'icon'       => 'bx bx-package',
            'icon_bg'    => 'bg-success-subtle',
            'icon_color' => 'text-success',
        ],
        [
            'label'      => __('messages.sold_product'),
            'value'      => number_format(array_sum(array_column($tableUser, 'takeProd')), 0, '.', ' '),
            'badge'      => __('messages.today'),
            'badge_class'=> 'bg-info-subtle text-info',
            'icon'       => 'bx bx-store',
            'icon_bg'    => 'bg-info-subtle',
            'icon_color' => 'text-info',
        ],
    ];
@endphp

<div class="row g-3">
    @foreach ($opCards as $card)
    <div class="col-xl-6 col-xxl-3 col-lg-6 col-md-6">
        <div class="card card-h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <span class="text-muted mb-3 lh-1 d-block text-truncate font-size-13">{{ $card['label'] }}</span>
                        <h4 class="mb-2 fw-semibold">{{ $card['value'] }}</h4>
                        <div class="text-nowrap">
                            <span class="badge {{ $card['badge_class'] }}">{{ $card['badge'] }}</span>
                        </div>
                    </div>
                    <div class="flex-shrink-0 ms-3">
                        <div class="avatar-sm rounded {{ $card['icon_bg'] }} d-flex align-items-center justify-content-center"
                             style="width:48px;height:48px">
                            <i class="{{ $card['icon'] }} font-size-22 {{ $card['icon_color'] }}"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- ─── Row 3: Worker performance table ────────────────────────────── --}}
<div class="row g-3 mt-0">
    <div class="col-xl-7 col-lg-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">
                    <i class="bx bx-group me-1 text-primary"></i>
                    {{ __('messages.workers') }}
                    <span class="badge bg-primary-subtle text-primary ms-1 font-size-11">{{ count($tableUser) }}</span>
                </h4>
                <small class="text-muted">{{ now()->format('d.m.Y') }}</small>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive" data-simplebar style="max-height: 420px;">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">#</th>
                                <th>{{ __('messages.name') }}</th>
                                <th class="text-center">{{ __('messages.given_product') }}</th>
                                <th class="text-center">{{ __('messages.given_tara') }}</th>
                                <th class="text-center">{{ __('messages.given_order') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tableUser as $index => $item)
                            <tr>
                                <td class="ps-3 text-muted font-size-13">{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        @php
                                        $avatarColors = ['#556ee6','#34c38f','#f1b44c','#50a5f1','#f46a6a','#74788d'];
                                        $avatarBg = $avatarColors[$index % count($avatarColors)];
                                    @endphp
                                    <div class="flex-shrink-0 d-flex align-items-center justify-content-center rounded-circle text-white fw-semibold font-size-13"
                                         style="width:34px;height:34px;min-width:34px;background:{{ $avatarBg }}">
                                        {{ mb_strtoupper(mb_substr($item['name'], 0, 1)) }}
                                    </div>
                                        <div>
                                            <p class="mb-0 fw-medium">{{ $item['name'] }}</p>
                                            <small class="text-muted">{{ $item['role'] }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-success-subtle text-success font-size-12 fw-medium">
                                        {{ $item['takeProd'] }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-warning-subtle text-warning font-size-12 fw-medium">
                                        {{ $item['ectryCon'] }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-primary-subtle text-primary font-size-12 fw-medium">
                                        {{ $item['suc_order'] }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="bx bx-user-x font-size-24 d-block mb-1"></i>
                                    {{ __('messages.no_data') }}
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Payment breakdown mini pie chart --}}
    <div class="col-xl-5 col-lg-12">
        <div class="card h-100">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">
                    <i class="bx bx-pie-chart me-1 text-primary"></i>
                    {{ __('messages.total_amount') }}
                </h4>
                <small class="text-muted">{{ now()->format('d.m.Y') }}</small>
            </div>
            <div class="card-body d-flex flex-column justify-content-center">
                <div id="payment-breakdown-chart"></div>

                <div class="mt-3">
                    @php
                        $breakdown = [
                            ['label' => __('messages.total_cash'),     'value' => $amount_cash,     'color' => '#34c38f'],
                            ['label' => __('messages.total_card'),     'value' => $amount_card,     'color' => '#556ee6'],
                            ['label' => __('messages.total_transfer'), 'value' => $amount_transfer, 'color' => '#f1b44c'],
                            ['label' => __('messages.total_other'),    'value' => $amount_other,    'color' => '#74788d'],
                        ];
                    @endphp
                    @foreach ($breakdown as $b)
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="d-flex align-items-center gap-2">
                            <span class="rounded-circle d-inline-block"
                                  style="width:10px;height:10px;background:{{ $b['color'] }}"></span>
                            <span class="text-muted font-size-13">{{ $b['label'] }}</span>
                        </div>
                        <span class="fw-medium font-size-13">{{ number_format($b['value'], 0, '.', ' ') }} UZS</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // ── Mini donut charts for payment cards ──────────────────────────────
    document.querySelectorAll('[data-series]').forEach(function (el) {
        var series = JSON.parse(el.dataset.series);
        var allZero = series.every(function (v) { return v === 0; });
        new ApexCharts(el, {
            series: allZero ? [1, 0] : series,
            chart: { type: 'donut', height: 80, sparkline: { enabled: true } },
            colors: ['#556ee6', '#e8ecf4'],
            legend: { show: false },
            dataLabels: { enabled: false },
            plotOptions: { pie: { donut: { size: '65%' } } },
            tooltip: { enabled: !allZero }
        }).render();
    });

    // ── Payment breakdown pie chart ───────────────────────────────────────
    new ApexCharts(document.querySelector('#payment-breakdown-chart'), {
        series: [
            {{ $amount_cash }},
            {{ $amount_card }},
            {{ $amount_transfer }},
            {{ $amount_other }}
        ],
        chart: { type: 'donut', height: 220 },
        labels: [
            '{{ __('messages.total_cash') }}',
            '{{ __('messages.total_card') }}',
            '{{ __('messages.total_transfer') }}',
            '{{ __('messages.total_other') }}'
        ],
        colors: ['#34c38f', '#556ee6', '#f1b44c', '#74788d'],
        legend: { position: 'bottom' },
        dataLabels: { enabled: true, formatter: function (val) { return Math.round(val) + '%'; } },
        plotOptions: { pie: { donut: { size: '60%' } } },
        tooltip: {
            y: { formatter: function (val) { return val.toLocaleString() + ' UZS'; } }
        }
    }).render();

    // ── Single-day date picker → reload page with ?date= param ───────────
    flatpickr('#dashboard-date', {
        mode: 'single',
        dateFormat: 'd.m.Y',
        maxDate: 'today',
        disableMobile: true,
        onChange: function (selectedDates) {
            if (!selectedDates.length) return;
            var d = selectedDates[0];
            var yyyy = d.getFullYear();
            var mm   = String(d.getMonth() + 1).padStart(2, '0');
            var dd   = String(d.getDate()).padStart(2, '0');
            window.location.href = '{{ route('dashboard') }}?date=' + yyyy + '-' + mm + '-' + dd;
        }
    });
</script>
@endsection

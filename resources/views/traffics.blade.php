@extends('layouts.v2_master')

@section('styles')
<style>
    /* ── Shared ─────────────────────────────────────────── */
    .badge-month { background: rgba(85,110,230,.1);  color: #556ee6; }
    .badge-year  { background: rgba(52,195,143,.1);  color: #34c38f; }

    /* ── Admin table ─────────────────────────────────────── */
    .traffic-table th { font-size: 12px; font-weight: 600; text-transform: uppercase;
                        color: #74788d; background: #f8f9fa; border-bottom: 1.5px solid #e9ecef; }
    .traffic-table td { vertical-align: middle; font-size: 13.5px; }
    .traffic-table tr:hover td { background: #fafbff; }

    /* ── Pricing cards (non-admin) ───────────────────────── */
    .pricing-card {
        border-radius: 16px; border: 1.5px solid #e9ecef;
        transition: box-shadow .2s, transform .15s;
    }
    .pricing-card:hover { box-shadow: 0 8px 32px rgba(85,110,230,.14); transform: translateY(-3px); }
    .pricing-card.current {
        border-color: #556ee6;
        background: linear-gradient(135deg, #556ee6 0%, #6f42c1 100%);
        color: #fff;
    }
    .pricing-card.current .text-muted { color: rgba(255,255,255,.75) !important; }
    .pricing-card .price-num { font-size: 36px; font-weight: 800; line-height: 1; }
    .pricing-card .feature-item {
        display: flex; align-items: center; gap: 8px;
        padding: 5px 0; font-size: 13.5px; border-bottom: 1px solid #f0f0f0;
    }
    .pricing-card.current .feature-item { border-bottom-color: rgba(255,255,255,.15); }
    .pricing-card .feature-item:last-child { border-bottom: none; }
    .stat-pill {
        display: inline-flex; align-items: center; gap: 6px;
        background: #f8f9fa; border-radius: 10px; padding: 8px 16px;
        font-size: 13px;
    }
    .stat-pill .num { font-size: 20px; font-weight: 800; color: #343a40; }
</style>
@endsection

@section('content')

{{-- Breadcrumb --}}
<div class="row mb-3">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">{{ __('messages.traffics') }}</h4>
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('messages.home') }}</a></li>
                <li class="breadcrumb-item active">{{ __('messages.traffics') }}</li>
            </ol>
        </div>
    </div>
</div>

{{-- Flash messages --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@php
    $allTraffics    = $month_traffics->merge($year_traffics);
    $isAdmin        = auth()->user()->id == 1;
@endphp

{{-- ════════════════════════════════════════════════════
     ADMIN VIEW — table with full controls
     ════════════════════════════════════════════════════ --}}
@if ($isAdmin)

    {{-- Stats + Add button --}}
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
        <div class="d-flex flex-wrap gap-2">
            <div class="stat-pill">
                <span class="num text-primary">{{ $allTraffics->count() }}</span>
                <span class="text-muted">Jami</span>
            </div>
            <div class="stat-pill">
                <span class="num text-success">{{ $allTraffics->where('active_status', true)->count() }}</span>
                <span class="text-muted">Faol</span>
            </div>
            <div class="stat-pill">
                <span class="num" style="color:#556ee6">{{ $month_traffics->count() }}</span>
                <span class="text-muted">Oylik</span>
            </div>
            <div class="stat-pill">
                <span class="num text-success">{{ $year_traffics->count() }}</span>
                <span class="text-muted">Yillik</span>
            </div>
        </div>
        <button type="button" class="btn btn-primary waves-effect" data-bs-toggle="offcanvas" data-bs-target="#addTrafficCanvas">
            <i class="fas fa-plus me-1"></i> Tarif qo'shish
        </button>
    </div>

    {{-- Month / Year tabs --}}
    <ul class="nav nav-tabs mb-0" id="adminTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="tab-month" data-bs-toggle="tab" href="#pane-month">
                <i class="fas fa-calendar-alt me-1"></i> Oylik
                <span class="badge badge-month ms-1">{{ $month_traffics->count() }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="tab-year" data-bs-toggle="tab" href="#pane-year">
                <i class="fas fa-calendar-check me-1"></i> Yillik
                <span class="badge badge-year ms-1">{{ $year_traffics->count() }}</span>
            </a>
        </li>
    </ul>

    <div class="card rounded-3 rounded-top-start-0 mb-0">
        <div class="card-body p-0">
            <div class="tab-content" id="adminTabsContent">

                {{-- ── Month tab ─────────────────────────────────── --}}
                @foreach ([['pane-month', $month_traffics, 'month'], ['pane-year', $year_traffics, 'year']] as [$paneId, $items, $typeLabel])
                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $paneId }}">
                    @if($items->count())
                    <div class="table-responsive">
                        <table class="table traffic-table mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4" style="width:200px">Nomi</th>
                                    <th style="width:110px">Narxi</th>
                                    <th>Mijoz</th>
                                    <th>SMS</th>
                                    <th>Tovar</th>
                                    <th>Xodim</th>
                                    <th style="width:80px">Faol</th>
                                    <th style="width:120px" class="pe-4 text-end">Amallar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-semibold" style="font-size:14px">{{ $item->name }}</div>
                                        <small class="text-muted">{{ $item->annotation }}</small>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-dark">{{ number_format($item->price, 0, '.', ' ') }}</span>
                                        <small class="text-muted"> so'm</small>
                                    </td>
                                    <td>{{ $item->clients_count }}</td>
                                    <td>{{ $item->sms_count }}</td>
                                    <td>{{ $item->products_count }}</td>
                                    <td>{{ $item->users_count }}</td>
                                    <td>
                                        <div class="form-check form-switch mb-0">
                                            <input class="form-check-input" type="checkbox"
                                                   id="toggle_{{ $item->id }}"
                                                   onchange="toggleActive({{ $item->id }}, this)"
                                                   @if($item->active_status) checked @endif>
                                        </div>
                                    </td>
                                    <td class="pe-4 text-end">
                                        <button type="button" class="btn btn-sm btn-soft-primary me-1"
                                            onclick="openEdit({{ $item->id }}, '{{ addslashes($item->name) }}', '{{ addslashes($item->annotation) }}', {{ $item->price }}, {{ $item->clients_count }}, {{ $item->sms_count }}, {{ $item->products_count }}, {{ $item->users_count }}, {{ $item->status }}, '{{ $item->type_traffic }}')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-soft-danger"
                                            onclick="deleteTraffic({{ $item->id }}, '{{ addslashes($item->name) }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-tags fa-2x mb-2 opacity-25"></i>
                            <p class="mb-0">Tariflar yo'q</p>
                        </div>
                    @endif
                </div>
                @endforeach

            </div>
        </div>
    </div>

    {{-- ── Add Traffic Offcanvas ───────────────────────────────────── --}}
    <div class="offcanvas offcanvas-end" tabindex="-1" id="addTrafficCanvas" style="width:420px">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title"><i class="fas fa-plus-circle text-primary me-2"></i>Tarif qo'shish</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <form action="{{ route('add_traffic') }}" method="POST">
                @csrf
                @include('partials._traffic_form')
                <div class="d-flex gap-2 mt-4">
                    <button type="button" class="btn btn-light flex-fill" data-bs-dismiss="offcanvas">
                        <i class="fas fa-times me-1"></i>{{ __('messages.cancel') }}
                    </button>
                    <button type="submit" class="btn btn-primary flex-fill waves-effect">
                        <i class="fas fa-save me-1"></i>{{ __('messages.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ── Edit Traffic Offcanvas ──────────────────────────────────── --}}
    <div class="offcanvas offcanvas-end" tabindex="-1" id="editTrafficCanvas" style="width:420px">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title"><i class="fas fa-edit text-warning me-2"></i>Tarifni tahrirlash</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <form id="editTrafficForm" action="" method="POST">
                @csrf
                @include('partials._traffic_form', ['editing' => true])
                <div class="d-flex gap-2 mt-4">
                    <button type="button" class="btn btn-light flex-fill" data-bs-dismiss="offcanvas">
                        <i class="fas fa-times me-1"></i>{{ __('messages.cancel') }}
                    </button>
                    <button type="submit" class="btn btn-warning flex-fill waves-effect">
                        <i class="fas fa-save me-1"></i>{{ __('messages.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

{{-- ════════════════════════════════════════════════════
     NON-ADMIN VIEW — pricing cards
     ════════════════════════════════════════════════════ --}}
@else

    {{-- Month / Year toggle --}}
    <div class="text-center mb-4">
        <ul class="nav nav-pills card justify-content-center d-inline-block shadow-sm py-1 px-2" id="pricingTab">
            <li class="nav-item d-inline-block">
                <a class="nav-link px-4 active" data-bs-toggle="pill" href="#price-month">
                    {{ __('messages.month') }}
                </a>
            </li>
            <li class="nav-item d-inline-block">
                <a class="nav-link px-4" data-bs-toggle="pill" href="#price-year">
                    {{ __('messages.year') }}
                    <span class="badge bg-success ms-1">20% Off</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="tab-content">
        @foreach ([['price-month', $month_traffics], ['price-year', $year_traffics]] as [$paneId, $items])
        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $paneId }}">
            <div class="row g-3 justify-content-center">
                @forelse ($items as $item)
                    @php $isCurrent = ($traffic == $item->id); @endphp
                    <div class="col-xl-3 col-md-4 col-sm-6">
                        <div class="card pricing-card mb-0 {{ $isCurrent ? 'current' : '' }}">
                            <div class="card-body p-4">
                                {{-- Header --}}
                                @if($isCurrent)
                                    <span class="badge bg-white text-primary mb-2" style="font-size:11px">
                                        <i class="fas fa-check-circle me-1"></i>{{ __('messages.selected') }}
                                    </span>
                                @endif
                                <h5 class="fw-bold mb-1 {{ $isCurrent ? 'text-white' : '' }}">{{ $item->name }}</h5>
                                <p class="mb-3 {{ $isCurrent ? 'text-white opacity-75' : 'text-muted' }}" style="font-size:13px">
                                    {{ $item->annotation }}
                                </p>

                                {{-- Price --}}
                                <div class="mb-4">
                                    <span class="price-num {{ $isCurrent ? 'text-white' : 'text-dark' }}">
                                        {{ number_format($item->price, 0, '.', ' ') }}
                                    </span>
                                    <span class="{{ $isCurrent ? 'text-white opacity-75' : 'text-muted' }}" style="font-size:13px">
                                        so'm / {{ $loop->parent->first ? __('messages.month') : __('messages.year') }}
                                    </span>
                                </div>

                                {{-- Features --}}
                                <div class="mb-4">
                                    @if($item->clients_count)
                                    <div class="feature-item {{ $isCurrent ? 'text-white' : '' }}">
                                        <i class="fas fa-users {{ $isCurrent ? 'text-white' : 'text-primary' }}" style="font-size:13px;width:16px"></i>
                                        <span>{{ $item->clients_count }} — {{ __('messages.clients') }}</span>
                                    </div>
                                    @endif
                                    @if($item->products_count)
                                    <div class="feature-item {{ $isCurrent ? 'text-white' : '' }}">
                                        <i class="fas fa-box {{ $isCurrent ? 'text-white' : 'text-success' }}" style="font-size:13px;width:16px"></i>
                                        <span>{{ $item->products_count }} — {{ __('messages.products') }}</span>
                                    </div>
                                    @endif
                                    @if($item->sms_count)
                                    <div class="feature-item {{ $isCurrent ? 'text-white' : '' }}">
                                        <i class="fab fa-telegram {{ $isCurrent ? 'text-white' : 'text-info' }}" style="font-size:13px;width:16px"></i>
                                        <span>{{ $item->sms_count }} — {{ __('messages.reklama_for_telegram') }}</span>
                                    </div>
                                    @endif
                                    @if($item->users_count)
                                    <div class="feature-item {{ $isCurrent ? 'text-white' : '' }}">
                                        <i class="fas fa-user-cog {{ $isCurrent ? 'text-white' : 'text-warning' }}" style="font-size:13px;width:16px"></i>
                                        <span>{{ $item->users_count }} — {{ __('messages.users') }}</span>
                                    </div>
                                    @endif
                                    <div class="feature-item {{ $isCurrent ? 'text-white' : '' }}">
                                        <i class="fas fa-infinity {{ $isCurrent ? 'text-white' : 'text-secondary' }}" style="font-size:13px;width:16px"></i>
                                        <span>{{ __('messages.bezlimitniy_telegram_posts') }}</span>
                                    </div>
                                </div>

                                {{-- CTA --}}
                                @if($isCurrent)
                                    <button class="btn btn-light w-100 fw-semibold" disabled>
                                        <i class="fas fa-check me-1"></i>{{ __('messages.selected') }}
                                    </button>
                                @else
                                    <a href="{{ route('trafficorgan', $item->id) }}" class="btn btn-outline-primary w-100 fw-semibold">
                                        {{ __('messages.view_more') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted py-5">
                        <i class="fas fa-tags fa-2x mb-2 opacity-25"></i>
                        <p class="mb-0">{{ __('messages.no_data') ?? 'Tariflar yo\'q' }}</p>
                    </div>
                @endforelse
            </div>
        </div>
        @endforeach
    </div>

@endif

@endsection

@section('scripts')
@if(auth()->user()->id == 1)
<script>
    // ── Open edit offcanvas, populate fields ─────────────────────────
    function openEdit(id, name, annotation, price, clients, sms, products, users, status, typeTraffic) {
        var form = document.getElementById('editTrafficForm');
        form.action = '/administration/edit-traffic/' + id;

        form.querySelector('[name="name"]').value        = name;
        form.querySelector('[name="annotation"]').value  = annotation;
        form.querySelector('[name="price"]').value       = price;
        form.querySelector('[name="clients_count"]').value = clients;
        form.querySelector('[name="sms_count"]').value   = sms;
        form.querySelector('[name="products_count"]').value = products;
        form.querySelector('[name="users_count"]').value = users;
        form.querySelector('[name="status"]').value      = status;
        form.querySelector('[name="type_traffic"]').value = typeTraffic;

        bootstrap.Offcanvas.getOrCreateInstance(document.getElementById('editTrafficCanvas')).show();
    }

    // ── Active status toggle (AJAX, no reload) ────────────────────────
    function toggleActive(id, el) {
        $.ajax({
            url: '/administration/update_status_traffic/' + id,
            method: 'POST',
            data: { _token: '{{ csrf_token() }}', active_status: el.checked ? 'true' : 'false' },
            success: function () {
                var badge = document.getElementById('toggle_' + id);
                // already updated by checkbox, nothing extra needed
            },
            error: function (xhr) {
                // revert toggle on failure
                el.checked = !el.checked;
                alertify.error(xhr.responseJSON?.message ?? 'Xatolik!');
            }
        });
    }

    // ── Delete traffic (SweetAlert + AJAX) ───────────────────────────
    function deleteTraffic(id, name) {
        Swal.fire({
            title: "O'chirishni tasdiqlang",
            text: name + ' tarifini o\'chirmoqchimisiz?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#f46a6a',
            cancelButtonColor: '#74788d',
            confirmButtonText: "Ha, o'chirish!",
            cancelButtonText: 'Bekor qilish'
        }).then(function (result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/administration/delete-traffic/' + id,
                    method: 'POST',
                    data: { _token: '{{ csrf_token() }}', id: id },
                    success: function () {
                        Swal.fire("O'chirildi!", name + " tarifi o'chirildi.", 'success')
                            .then(() => location.reload());
                    },
                    error: function (xhr) {
                        alertify.error(xhr.responseJSON?.message ?? 'Xatolik!');
                    }
                });
            }
        });
    }
</script>
@endif
@endsection

@extends('layouts.v2_master')

@section('styles')
<style>
    .avatar-initials {
        width: 72px; height: 72px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 26px; font-weight: 700; color: #fff;
        background: linear-gradient(135deg, #556ee6 0%, #6f42c1 100%);
        box-shadow: 0 4px 15px rgba(85,110,230,.35);
        flex-shrink: 0;
    }
    .stat-card { border: none; border-radius: 14px; transition: transform .15s; }
    .stat-card:hover { transform: translateY(-2px); }
    .stat-icon {
        width: 48px; height: 48px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 20px; flex-shrink: 0;
    }
    .section-table th { font-size: 12px; white-space: nowrap; }
    .section-table td { font-size: 13px; }
    .badge-payment { font-size: 11px; padding: 4px 8px; border-radius: 6px; }
</style>
@endsection

@section('content')

{{-- ─── Page title ────────────────────────────────────────────────── --}}
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">{{ __('messages.client_result') }}</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('messages.home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('clients') }}">{{ __('messages.Clients') }}</a></li>
                    <li class="breadcrumb-item active">{{ $client->fullname }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

{{-- ─── Client info + stat cards ──────────────────────────────────── --}}
<div class="row g-3 mb-3">

    {{-- Client card --}}
    <div class="col-xl-4 col-md-12">
        <div class="card stat-card h-100 mb-0">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="avatar-initials">
                    {{ mb_strtoupper(mb_substr($client->fullname, 0, 1)) }}
                </div>
                <div class="flex-grow-1 overflow-hidden">
                    <h5 class="fw-bold mb-1 text-truncate">{{ $client->fullname }}</h5>
                    <p class="mb-1 text-muted">
                        <i class="fas fa-phone text-primary me-1"></i>
                        <span class="fw-semibold text-dark">{{ $client->phone }}</span>
                        @if($client->phone2)
                            &nbsp;/&nbsp;<span class="text-muted">{{ $client->phone2 }}</span>
                        @endif
                    </p>
                    @if($client->city || $client->area)
                    <p class="mb-1 text-muted" style="font-size:12px">
                        <i class="fas fa-map-marker-alt me-1 text-danger"></i>
                        {{ optional($client->city)->name }}{{ optional($client->area)->name ? ', '.$client->area->name : '' }}
                    </p>
                    @endif
                    @if($client->address)
                    <p class="mb-0 text-muted text-truncate" style="font-size:12px">
                        <i class="fas fa-home me-1"></i>{{ $client->address }}
                    </p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Balance --}}
    <div class="col-xl-2 col-sm-6">
        <div class="card stat-card mb-0 h-100">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-icon" style="background:rgba(52,195,143,.15)">
                        <i class="fas fa-wallet text-success"></i>
                    </div>
                    <div class="flex-grow-1 min-w-0">
                        <p class="text-muted mb-1 text-truncate" style="font-size:12px">{{ __('messages.client_balance') }}</p>
                        <h5 class="fw-bold mb-0 {{ $client->balance < 0 ? 'text-danger' : 'text-success' }}">
                            {{ number_format($client->balance, 0, '.', ' ') }}
                            <small class="text-muted fw-normal" style="font-size:11px">UZS</small>
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Container debt --}}
    <div class="col-xl-2 col-sm-6">
        <div class="card stat-card mb-0 h-100">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-icon" style="background:rgba(241,180,76,.15)">
                        <i class="fas fa-box-open text-warning"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="text-muted mb-1" style="font-size:12px">{{ __('messages.debt_container') }}</p>
                        <h5 class="fw-bold mb-0 {{ $client->container < 0 ? 'text-danger' : 'text-dark' }}">
                            {{ $client->container }}
                            <small class="text-muted fw-normal" style="font-size:11px">{{ __('messages.pcs') ?? 'pcs' }}</small>
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Total sold amount --}}
    <div class="col-xl-2 col-sm-6">
        <div class="card stat-card mb-0 h-100">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-icon" style="background:rgba(85,110,230,.15)">
                        <i class="fas fa-sort-amount-down text-primary"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="text-muted mb-1" style="font-size:12px">{{ __('messages.all_amounts') }}</p>
                        <h5 class="fw-bold mb-0 text-primary">
                            {{ number_format($summ, 0, '.', ' ') }}
                            <small class="text-muted fw-normal" style="font-size:11px">UZS</small>
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Orders count --}}
    <div class="col-xl-2 col-sm-6">
        <div class="card stat-card mb-0 h-100">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-icon" style="background:rgba(85,110,230,.12)">
                        <i class="fas fa-shopping-cart text-primary"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="text-muted mb-1" style="font-size:12px">{{ __('messages.orders_count') }}</p>
                        <h5 class="fw-bold mb-0 text-dark">
                            {{ $soldproducts->count() }}
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ─── Two side tables: receipts + containers ────────────────────── --}}
<div class="row g-3 mb-3">

    {{-- Payment receipts --}}
    <div class="col-lg-6">
        <div class="card rounded-3 mb-0 h-100">
            <div class="card-header d-flex align-items-center py-2 px-3">
                <i class="fas fa-receipt text-success me-2"></i>
                <h6 class="card-title mb-0 flex-grow-1">{{ __('messages.amount_receipts') }}</h6>
                <span class="badge bg-success-subtle text-success">{{ $clientprices->count() }}</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive" data-simplebar style="max-height:220px">
                    <table class="table table-sm section-table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="36">#</th>
                                <th>{{ __('messages.amount') }}</th>
                                <th>{{ __('messages.payment_type') }}</th>
                                <th>{{ __('messages.who_got_it') }}</th>
                                <th>{{ __('messages.comment') }}</th>
                                <th>{{ __('messages.go_it_time') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($clientprices as $prices)
                                <tr>
                                    <td class="text-center text-muted">{{ $loop->index + 1 }}</td>
                                    <td class="fw-semibold">{{ number_format($prices->amount, 0, '.', ' ') }}</td>
                                    <td>
                                        @if ($prices->payment == 1)
                                            <span class="badge bg-primary badge-payment">{{ __('messages.cash') }}</span>
                                        @elseif ($prices->payment == 2)
                                            <span class="badge bg-warning text-dark badge-payment">{{ __('messages.card') }}</span>
                                        @else
                                            <span class="badge bg-success badge-payment">{{ __('messages.transfer') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($loop->first && $lastPrice)
                                            <button type="button"
                                                class="btn btn-soft-primary btn-sm py-0 px-2"
                                                data-bs-toggle="modal" data-bs-target="#priceedit">
                                                {{ $prices->user->name ?? '' }}
                                            </button>
                                        @else
                                            <span class="text-muted">{{ $prices->user->name ?? '' }}</span>
                                        @endif
                                    </td>
                                    <td class="text-muted" style="max-width:100px">{{ $prices->comment }}</td>
                                    <td class="text-nowrap text-muted" style="font-size:11px">{{ $prices->created_at->format('d.m.Y') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center text-muted py-3">{{ __('messages.no_data') ?? 'No data' }}</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Container returns --}}
    <div class="col-lg-6">
        <div class="card rounded-3 mb-0 h-100">
            <div class="card-header d-flex align-items-center py-2 px-3">
                <i class="fas fa-box text-warning me-2"></i>
                <h6 class="card-title mb-0 flex-grow-1">{{ __('messages.returned_containers') }}</h6>
                <span class="badge bg-warning-subtle text-warning">{{ $clientcontainer->count() }}</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive" data-simplebar style="max-height:220px">
                    <table class="table table-sm section-table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="36">#</th>
                                <th>{{ __('messages.product') }}</th>
                                <th>{{ __('messages.count') }}</th>
                                <th>{{ __('messages.invalid') }}</th>
                                <th>{{ __('messages.who_got_it') }}</th>
                                <th>{{ __('messages.go_it_time') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($clientcontainer as $container)
                                <tr>
                                    <td class="text-center text-muted">{{ $loop->index + 1 }}</td>
                                    <td>{{ optional($container->product)->name ?? '—' }}</td>
                                    <td class="fw-semibold">{{ $container->count }}</td>
                                    <td class="text-danger">{{ $container->invalid_count }}</td>
                                    <td>
                                        @if ($loop->first && $lastContainer)
                                            <button type="button"
                                                class="btn btn-soft-warning btn-sm py-0 px-2"
                                                data-bs-toggle="modal" data-bs-target="#container_edit">
                                                {{ $container->user->name ?? '' }}
                                            </button>
                                        @else
                                            <span class="text-muted">{{ $container->user->name ?? '' }}</span>
                                        @endif
                                    </td>
                                    <td class="text-nowrap text-muted" style="font-size:11px">{{ $container->created_at->format('d.m.Y') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center text-muted py-3">{{ __('messages.no_data') ?? 'No data' }}</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ─── Sold products history table ───────────────────────────────── --}}
<div class="card rounded-3">
    <div class="card-header d-flex align-items-center py-2 px-3">
        <i class="fas fa-history text-primary me-2"></i>
        <h6 class="card-title mb-0 flex-grow-1">{{ __('messages.client_result') }}</h6>
        <span class="badge bg-primary-subtle text-primary">{{ $soldproducts->count() }}</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive" data-simplebar style="max-height:400px">
            <table class="table table-sm section-table table-hover mb-0">
                <thead class="table-light" style="position:sticky;top:0;z-index:1">
                    <tr>
                        <th width="36">#</th>
                        <th>{{ __('messages.product') }}</th>
                        <th class="text-center">{{ __('messages.order_count') }}</th>
                        <th class="text-center">{{ __('messages.price') }}</th>
                        <th>{{ __('messages.order_time') }}</th>
                        <th class="text-center">{{ __('messages.received_count') }}</th>
                        <th class="text-center">{{ __('messages.received_price') }}</th>
                        <th class="text-center">{{ __('messages.returned_containers') }}</th>
                        <th class="text-center">{{ __('messages.payment_type') }}</th>
                        <th class="text-end">{{ __('messages.total_amount') }}</th>
                        <th>{{ __('messages.comment') }}</th>
                        <th>{{ __('messages.delevired_time') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($soldproducts as $soldproduct)
                        <tr>
                            <td class="text-center text-muted">{{ $loop->index + 1 }}</td>
                            <td class="fw-semibold">{{ optional($soldproduct->product)->name ?? '—' }}</td>
                            <td class="text-center">{{ $soldproduct->order_count }}</td>
                            <td class="text-center">{{ number_format($soldproduct->order_price, 0, '.', ' ') }}</td>
                            <td class="text-nowrap text-muted" style="font-size:11px">
                                {{ $soldproduct->order_date ? \Carbon\Carbon::parse($soldproduct->order_date)->format('d.m.Y') : '—' }}
                            </td>
                            <td class="text-center fw-semibold">{{ $soldproduct->count }}</td>
                            <td class="text-center">{{ number_format($soldproduct->price, 0, '.', ' ') }}</td>
                            <td class="text-center">{{ $soldproduct->container }}</td>
                            <td class="text-center">
                                @if ($soldproduct->payment == 1)
                                    <span class="badge bg-primary badge-payment">{{ __('messages.cash') }}</span>
                                @elseif ($soldproduct->payment == 2)
                                    <span class="badge bg-warning text-dark badge-payment">{{ __('messages.card') }}</span>
                                @else
                                    <span class="badge bg-success badge-payment">{{ __('messages.transfer') }}</span>
                                @endif
                            </td>
                            <td class="text-end fw-bold text-success">
                                {{ number_format($soldproduct->amount, 0, '.', ' ') }}
                            </td>
                            <td class="text-muted" style="max-width:120px;font-size:12px">{{ $soldproduct->comment }}</td>
                            <td class="text-nowrap text-muted" style="font-size:11px">
                                {{ $soldproduct->created_at->format('d.m.Y H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="text-center py-4 text-muted">
                                <i class="fas fa-inbox fa-2x d-block mb-2 opacity-50"></i>
                                {{ __('messages.no_data') ?? 'No orders yet' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ─── Edit price modal ───────────────────────────────────────────── --}}
@if ($lastPrice)
    <div id="priceedit" class="modal fade" tabindex="-1" data-bs-scroll="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('messages.amount_receipts') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('client_price_edit', ['id' => $lastPrice->id]) }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="mb-1 fw-semibold">{{ __('messages.payment_type') }}:</label>
                            <select class="form-select" name="payment" id="price_payment_type">
                                <option value="1" @if($lastPrice->payment == 1) selected @endif>{{ __('messages.cash') }}</option>
                                <option value="2" @if($lastPrice->payment == 2) selected @endif>{{ __('messages.card') }}</option>
                                <option value="3" @if($lastPrice->payment == 3) selected @endif>{{ __('messages.transfer') }}</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="mb-1 fw-semibold">{{ __('messages.amount') }}:</label>
                            <input class="form-control" type="number" name="amount"
                                   value="{{ $lastPrice->amount }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="mb-1 fw-semibold">{{ __('messages.comment') }}:</label>
                            <textarea class="form-control" name="comment" rows="2">{{ $lastPrice->comment }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('client_price_delete', ['id' => $lastPrice->id]) }}"
                           class="btn btn-danger btn-lg" onclick="return confirm('{{ __('messages.Do_you_want_to_delete') }}?')">
                            <i class="fa fa-trash me-1"></i>{{ __('messages.delete') }}
                        </a>
                        <button type="button" class="btn btn-secondary btn-lg" data-bs-dismiss="modal">
                            <i class="fas fa-reply me-1"></i>{{ __('messages.cancel') }}
                        </button>
                        <button class="btn btn-primary btn-lg" type="submit">
                            <i class="fa fa-save me-1"></i>{{ __('messages.save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

{{-- ─── Edit container modal ───────────────────────────────────────── --}}
@if ($lastContainer)
    <div id="container_edit" class="modal fade" tabindex="-1" data-bs-scroll="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('messages.returned_containers') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('client_container_edit', ['id' => $lastContainer->id]) }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="mb-1 fw-semibold">{{ __('messages.product') }}:</label>
                            <select class="form-select" name="product_id" required>
                                <option value="">—</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}"
                                        @if($lastContainer->product_id == $product->id) selected @endif>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="mb-1 fw-semibold">{{ __('messages.returned_count') }}:</label>
                            <input class="form-control" type="number" name="count"
                                   value="{{ $lastContainer->count }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="mb-1 fw-semibold">{{ __('messages.invalid_count') }}:</label>
                            <input class="form-control" type="number" name="invalid_count"
                                   value="{{ $lastContainer->invalid_count }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="mb-1 fw-semibold">{{ __('messages.comment') }}:</label>
                            <textarea class="form-control" name="comment" rows="2">{{ $lastContainer->comment }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('client_container_delete', ['id' => $lastContainer->id]) }}"
                           class="btn btn-danger btn-lg" onclick="return confirm('{{ __('messages.Do_you_want_to_delete') }}?')">
                            <i class="fa fa-trash me-1"></i>{{ __('messages.delete') }}
                        </a>
                        <button type="button" class="btn btn-secondary btn-lg" data-bs-dismiss="modal">
                            <i class="fas fa-reply me-1"></i>{{ __('messages.cancel') }}
                        </button>
                        <button class="btn btn-primary btn-lg" type="submit">
                            <i class="fa fa-save me-1"></i>{{ __('messages.save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

@endsection

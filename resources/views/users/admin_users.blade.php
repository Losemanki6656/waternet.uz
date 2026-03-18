@extends('layouts.v2_master')

@section('styles')
<style>
    .user-card {
        border-radius: 14px;
        transition: box-shadow .2s, transform .15s;
        border: 1.5px solid #f0f0f0;
    }
    .user-card:hover {
        box-shadow: 0 6px 24px rgba(85,110,230,.13);
        transform: translateY(-2px);
    }
    .user-avatar {
        width: 56px; height: 56px; border-radius: 50%; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        font-size: 20px; font-weight: 700; color: #fff;
    }
    .info-line {
        font-size: 12.5px; color: #74788d;
        display: flex; align-items: center; gap: 6px;
        margin-top: 5px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
    }
    .info-line i { font-size: 12px; flex-shrink: 0; width: 14px; text-align: center; }
    .org-chip {
        display: inline-flex; align-items: center; gap: 5px;
        background: rgba(85,110,230,.08); color: #556ee6;
        border-radius: 20px; padding: 3px 10px; font-size: 12px; font-weight: 600;
        max-width: 180px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
    }
    .stat-card {
        border-radius: 12px; padding: 16px 20px;
        border: 1.5px solid #f0f0f0;
    }
    .stat-card .stat-num { font-size: 26px; font-weight: 800; line-height: 1; }
    .stat-card .stat-lbl { font-size: 12px; color: #74788d; margin-top: 3px; }
</style>
@endsection

@section('content')

{{-- Breadcrumb --}}
<div class="row mb-2">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">{{ __('messages.users') }}</h4>
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('messages.home') }}</a></li>
                <li class="breadcrumb-item active">{{ __('messages.users') }}</li>
            </ol>
        </div>
    </div>
</div>

{{-- Stats row --}}
<div class="row g-3 mb-3">
    <div class="col-6 col-sm-3">
        <div class="card stat-card mb-0">
            <div class="stat-num text-primary">{{ $users->total() }}</div>
            <div class="stat-lbl">{{ __('messages.users') }}</div>
        </div>
    </div>
    <div class="col-6 col-sm-3">
        <div class="card stat-card mb-0">
            <div class="stat-num text-success">{{ $shops->count() }}</div>
            <div class="stat-lbl">{{ __('messages.shops') }}</div>
        </div>
    </div>
</div>

{{-- Filter bar --}}
<div class="card rounded-3 mb-3">
    <div class="card-body py-2 px-3">
        <div class="row g-2 align-items-center">
            <div class="col-sm-4 col-md-3">
                <select name="org_id" id="org_id" class="form-select">
                    <option value="">— {{ __('messages.shops') }} —</option>
                    @foreach ($shops as $shop)
                        <option value="{{ $shop->id }}" @if($shop->id == request('org_id')) selected @endif>
                            {{ $shop->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-4 col-md-3">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fas fa-search text-muted" style="font-size:12px"></i>
                    </span>
                    <input type="search" id="search" class="form-control border-start-0 ps-0"
                           value="{{ request('search') }}"
                           placeholder="{{ __('messages.search') }}...">
                </div>
            </div>
            <div class="col-sm-2 col-md-2">
                <select id="paginate_select" class="form-select">
                    @foreach ([8, 16, 32, 80] as $n)
                        <option value="{{ $n }}" @if($users->perPage() == $n) selected @endif>{{ $n }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <button type="button" class="btn btn-primary" onclick="runFilter()">
                    <i class="fas fa-filter me-1"></i>{{ __('messages.search') }}
                </button>
                @if(request('search') || request('org_id'))
                    <a href="{{ route('users_admin') }}" class="btn btn-light ms-1">
                        <i class="fas fa-times me-1"></i>{{ __('messages.cancel') }}
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- User grid --}}
@php
    $avatarColors = ['#556ee6','#34c38f','#f1b44c','#f46a6a','#50a5f1','#74788d'];
    $i = 0;
@endphp

@if ($users->count())
<div class="row g-3">
    @foreach ($users as $user)
        @php $tc = $avatarColors[$i % count($avatarColors)]; $i++; @endphp
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <div class="card user-card mb-0 h-100">
                <div class="card-body">
                    {{-- Avatar + name row --}}
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="user-avatar" style="background:{{ $tc }}">
                            {{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}
                        </div>
                        <div class="flex-grow-1 overflow-hidden">
                            <div class="fw-bold text-dark text-truncate" style="font-size:15px">
                                {{ $user->name }}
                            </div>
                            <div class="mt-1">
                                @if ($user->id == 1)
                                    <span class="badge bg-danger-subtle text-danger">Super Admin</span>
                                @else
                                    <span class="badge
                                        @if($user->role == 4) bg-success-subtle text-success
                                        @elseif($user->role == 2) bg-warning-subtle text-warning
                                        @elseif($user->role == 3) bg-info-subtle text-info
                                        @else bg-danger-subtle text-danger @endif">
                                        {{ $user->roleName() ?? '—' }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Organization chip --}}
                    @if ($user->organization)
                        <div class="mb-3">
                            <span class="org-chip">
                                <i class="fas fa-store" style="font-size:10px"></i>
                                {{ $user->organization->name }}
                            </span>
                        </div>
                    @endif

                    {{-- Contact info --}}
                    <div class="info-line">
                        <i class="fas fa-phone text-primary"></i>
                        <span class="text-truncate">{{ $user->phone ?? '—' }}</span>
                    </div>
                    <div class="info-line">
                        <i class="fas fa-envelope text-success"></i>
                        <span class="text-truncate">{{ $user->email }}</span>
                    </div>
                    <div class="info-line">
                        <i class="fas fa-map-marker-alt text-danger"></i>
                        <span class="text-truncate">{{ $user->address ?? '—' }}</span>
                    </div>
                </div>

                {{-- Action buttons --}}
                <div class="card-footer bg-transparent border-top-0 pt-0 pb-3 px-3">
                    <div class="d-flex gap-2">
                        <a href="{{ route('users.edit', $user->id) }}?from=admin_users"
                           class="btn btn-sm btn-soft-primary flex-fill">
                            <i class="fas fa-edit me-1"></i>{{ __('messages.edit') }}
                        </a>
                        @if ($user->id != 1)
                            <button type="button" class="btn btn-sm btn-soft-danger flex-fill"
                                    onclick="DeleteUser('{{ addslashes($user->name) }}', {{ $user->id }})">
                                <i class="fas fa-trash me-1"></i>{{ __('messages.delete') }}
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@else
    <div class="card rounded-3">
        <div class="card-body text-center py-5 text-muted">
            <i class="fas fa-users fa-3x mb-3 opacity-25"></i>
            <p class="mb-0">{{ __('messages.no_data') ?? 'Ma\'lumot topilmadi' }}</p>
        </div>
    </div>
@endif

{{-- Pagination --}}
@if ($users->lastPage() > 1)
<div class="d-flex align-items-center justify-content-between mt-3">
    <div class="text-muted" style="font-size:13px">
        {{ $users->firstItem() }}–{{ $users->lastItem() }} / {{ $users->total() }}
    </div>
    <div>
        {{ $users->onEachSide(1)->withQueryString()->links() }}
    </div>
</div>
@endif

@endsection

@section('scripts')
<script>
    // Choices.js for org select
    if (document.getElementById('org_id')) {
        new Choices('#org_id', {
            searchEnabled: true,
            itemSelectText: '',
            shouldSort: false,
        });
    }

    // Run filter (page reload with params)
    function runFilter() {
        var url = new URL('{{ route('users_admin') }}');
        var search  = document.getElementById('search').value;
        var orgId   = document.getElementById('org_id').value;
        var perPage = document.getElementById('paginate_select').value;
        if (search)  url.searchParams.set('search', search);
        if (orgId)   url.searchParams.set('org_id', orgId);
        if (perPage) url.searchParams.set('per_page', perPage);
        window.location.href = url.toString();
    }

    // Trigger filter on Enter key in search
    document.getElementById('search').addEventListener('keydown', function (e) {
        if (e.key === 'Enter') runFilter();
    });

    // Per-page change auto-submits
    document.getElementById('paginate_select').addEventListener('change', runFilter);

    // Delete user
    function DeleteUser(fullname, id) {
        Swal.fire({
            title: "{{ __('messages.Do_you_want_to_delete') }} ?",
            text: fullname,
            icon: "warning",
            showCancelButton: true,
            cancelButtonText: "{{ __('messages.no') }}",
            confirmButtonColor: "#f46a6a",
            cancelButtonColor: "#74788d",
            confirmButtonText: "{{ __('messages.Yes_delete') }} !"
        }).then(function (result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('user_destroy') }}",
                    method: "POST",
                    data: { "_token": "{{ csrf_token() }}", id: id },
                    success: function () {
                        Swal.fire(
                            "{{ __('messages.deleted') }}!",
                            "{{ __('messages.success_removed') }}",
                            "success"
                        ).then(() => location.reload());
                    },
                    error: function (xhr) {
                        alertify.error(xhr.responseJSON?.message ?? 'Xatolik!');
                    }
                });
            }
        });
    }
</script>
@endsection

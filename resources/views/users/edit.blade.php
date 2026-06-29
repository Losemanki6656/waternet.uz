@extends('layouts.v2_master')

@section('styles')
<style>
    .profile-cover {
        height: 150px; border-radius: 16px 16px 0 0;
        background: linear-gradient(135deg, #556ee6 0%, #6f42c1 60%, #34c38f 100%);
    }
    .profile-avatar {
        width: 80px; height: 80px; border-radius: 50%; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        font-size: 30px; font-weight: 700; color: #fff;
        background: linear-gradient(135deg, #f46a6a, #f1b44c);
        border: 4px solid #fff; box-shadow: 0 4px 15px rgba(0,0,0,.25);
        /* pulled up into the cover via margin-top on the row */
    }
    .perm-grid {
        display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px;
    }
    @media (max-width: 768px) { .perm-grid { grid-template-columns: 1fr 1fr; } }
    .perm-card {
        border: 1.5px solid #e9ecef; border-radius: 12px; padding: 12px;
        cursor: pointer; transition: border-color .15s, background .15s, transform .1s;
        user-select: none;
    }
    .perm-card:hover { border-color: #556ee6; transform: translateY(-1px); }
    .perm-card:has(input:checked) {
        border-color: #556ee6; background: rgba(85,110,230,.07);
    }
    .perm-icon-wrap {
        width: 36px; height: 36px; border-radius: 9px;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 8px;
    }
    .teammate-item { border-radius: 10px; padding: 8px 12px; }
    .teammate-item:hover { background: #f8f9fa; }
    .teammate-avatar {
        width: 36px; height: 36px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 14px; font-weight: 700; color: #fff; flex-shrink: 0;
    }
    .password-toggle { cursor: pointer; }
</style>
@endsection

@section('content')

{{-- Breadcrumb --}}
<div class="row mb-2">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">{{ __('messages.profile') }}</h4>
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('messages.home') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('users') }}">{{ __('messages.users') }}</a></li>
                <li class="breadcrumb-item active">{{ $user->name }}</li>
            </ol>
        </div>
    </div>
</div>

<form action="{{ route('user_update', $user->id) }}" method="POST" id="update_user">
    @csrf
    <input type="hidden" name="from" value="{{ request('from') }}">

<div class="row g-3">

    {{-- LEFT: Profile card + form --}}
    <div class="col-xl-8">

        {{-- Cover + avatar --}}
        <div class="card rounded-3 mb-3">
            <div class="profile-cover"></div>
            <div class="px-4 pb-3">
                {{-- Avatar row: pulled up 40px into the cover --}}
                @php
                    $backUrl = request('from') === 'admin_users' ? route('users_admin') : route('users');
                @endphp
                <div class="d-flex align-items-end justify-content-between" style="margin-top:-40px">
                    <div class="profile-avatar">
                        {{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}
                    </div>
                    <div class="d-flex gap-2 pb-1">
                        <a href="{{ $backUrl }}" class="btn btn-light btn-lg">
                            <i class="fas fa-arrow-left me-1"></i>{{ __('messages.back') ?? 'Orqaga' }}
                        </a>
                        <button type="submit" class="btn btn-success btn-lg waves-effect">
                            <i class="fas fa-save me-1"></i>{{ __('messages.save') }}
                        </button>
                    </div>
                </div>
                {{-- Name + role below avatar --}}
                <div class="mt-2">
                    <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                    <span class="badge
                        @if($user->role == 4) bg-success-subtle text-success
                        @elseif($user->role == 2) bg-warning-subtle text-warning
                        @elseif($user->role == 3) bg-info-subtle text-info
                        @else bg-danger-subtle text-danger @endif"
                        style="font-size:12px">
                        {{ $user->roleName() ?? '—' }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Basic info --}}
        <div class="card rounded-3 mb-3">
            <div class="card-header py-2 px-3">
                <h6 class="mb-0"><i class="fas fa-user text-primary me-2"></i>{{ __('messages.update') ?? 'Ma\'lumotlarni yangilash' }}</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('messages.fullname') }} <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control"
                               value="{{ $user->name }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('messages.phone') }}</label>
                        <input type="text" name="phone" value="{{ $user->phone }}"
                               class="form-control" id="phone_user">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('messages.email') }} <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control"
                               value="{{ $user->email }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('messages.address') }}</label>
                        <input type="text" name="address" value="{{ $user->address }}"
                               class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">{{ __('messages.role') }} <span class="text-danger">*</span></label>
                        <select class="form-select" name="role" required>
                            @foreach ($roles as $key => $value)
                                <option value="{{ $key }}" @if($key == $user->role) selected @endif>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">
                            {{ __('messages.password') }}
                            <small class="text-muted fw-normal">({{ __('messages.leave_blank_to_keep') ?? 'bo\'sh qoldiring' }})</small>
                        </label>
                        <div class="input-group">
                            <input type="password" name="password" class="form-control" id="pw_field" autocomplete="new-password">
                            <button class="btn btn-outline-secondary password-toggle" type="button" tabindex="-1"
                                    onclick="togglePw('pw_field')">
                                <i class="fas fa-eye" id="pw_icon"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">{{ __('messages.confirm_password') }}</label>
                        <div class="input-group">
                            <input type="password" name="confirm-password" class="form-control" id="pw2_field" autocomplete="new-password">
                            <button class="btn btn-outline-secondary password-toggle" type="button" tabindex="-1"
                                    onclick="togglePw('pw2_field')">
                                <i class="fas fa-eye" id="pw2_icon"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Permissions --}}
        <div class="card rounded-3">
            <div class="card-header py-2 px-3 d-flex align-items-center justify-content-between">
                <h6 class="mb-0">
                    <i class="fas fa-shield-alt text-primary me-2"></i>{{ __('messages.permissions') ?? 'Ruxsatlar' }}
                </h6>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-sm btn-soft-primary" id="checkAllPerms">
                        <i class="fas fa-check-double me-1"></i>{{ __('messages.select_all') ?? 'Hammasi' }}
                    </button>
                    <button type="button" class="btn btn-sm btn-soft-danger" id="uncheckAllPerms">
                        <i class="fas fa-times me-1"></i>{{ __('messages.deselect_all') ?? 'Tozalash' }}
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="perm-grid">
                    @foreach ($permissions as $permKey => $permData)
                        @php
                            $bgColors = [
                                'primary'   => 'rgba(85,110,230,.12)',
                                'info'      => 'rgba(80,165,241,.12)',
                                'warning'   => 'rgba(241,180,76,.12)',
                                'success'   => 'rgba(52,195,143,.12)',
                                'secondary' => 'rgba(116,120,141,.12)',
                                'dark'      => 'rgba(52,58,64,.12)',
                                'danger'    => 'rgba(244,106,106,.12)',
                            ];
                            $bg = $bgColors[$permData['color']] ?? 'rgba(85,110,230,.12)';
                            $hasIt = in_array($permKey, $userPermissions);
                        @endphp
                        <label class="perm-card d-block mb-0" for="perm_{{ $permKey }}">
                            <input class="d-none perm-checkbox" type="checkbox"
                                   name="permissions[]" value="{{ $permKey }}"
                                   id="perm_{{ $permKey }}"
                                   @if($hasIt) checked @endif>
                            <div class="perm-icon-wrap" style="background:{{ $bg }}">
                                <i class="{{ $permData['icon'] }} text-{{ $permData['color'] }}"></i>
                            </div>
                            <div class="fw-semibold" style="font-size:13px">{{ $permData['label'] }}</div>
                            <div style="font-size:11px;color:#adb5bd;margin-top:2px">{{ $permKey }}</div>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Driver geographic coverage (Region → Area) --}}
        @include('users.partials.areas', ['sities' => $sities, 'assignedAreas' => $assignedAreas])

    </div>

    {{-- RIGHT: Teammates --}}
    <div class="col-xl-4">
        <div class="card rounded-3 h-100">
            <div class="card-header py-2 px-3 d-flex align-items-center">
                <i class="fas fa-users text-primary me-2"></i>
                <h6 class="mb-0 flex-grow-1">{{ __('messages.team_members') }}</h6>
                <span class="badge bg-primary-subtle text-primary">{{ $users->count() }}</span>
            </div>
            <div class="card-body p-0">
                <div data-simplebar style="max-height:480px">
                    @forelse ($users as $item)
                        @php
                            $avatarColors = ['#556ee6','#34c38f','#f1b44c','#f46a6a','#50a5f1','#74788d'];
                            $tc = $avatarColors[$loop->index % count($avatarColors)];
                        @endphp
                        <a href="{{ route('users.edit', $item->id) }}"
                           class="d-flex align-items-center gap-3 teammate-item text-decoration-none text-dark mx-2 my-1">
                            <div class="teammate-avatar" style="background:{{ $tc }}">
                                {{ mb_strtoupper(mb_substr($item->name, 0, 1)) }}
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <div class="fw-semibold text-truncate" style="font-size:14px">{{ $item->name }}</div>
                                <div class="text-muted" style="font-size:12px">{{ $item->roleName() ?? '—' }}</div>
                            </div>
                            <i class="fas fa-chevron-right text-muted" style="font-size:11px"></i>
                        </a>
                    @empty
                        <div class="text-center text-muted py-4" style="font-size:13px">
                            {{ __('messages.no_data') ?? 'No teammates' }}
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

</div>
</form>

@endsection

@section('scripts')
<script>
    // Phone mask
    if (document.getElementById('phone_user')) {
        IMask(document.getElementById('phone_user'), { mask: '(00)0000000' });
    }

    // Password visibility toggle
    function togglePw(fieldId) {
        var f = document.getElementById(fieldId);
        var icon = document.getElementById(fieldId.replace('_field', '_icon'));
        if (f.type === 'password') {
            f.type = 'text';
            if (icon) { icon.classList.remove('fa-eye'); icon.classList.add('fa-eye-slash'); }
        } else {
            f.type = 'password';
            if (icon) { icon.classList.remove('fa-eye-slash'); icon.classList.add('fa-eye'); }
        }
    }

    // Select / deselect all permissions
    document.getElementById('checkAllPerms').addEventListener('click', function () {
        document.querySelectorAll('.perm-checkbox').forEach(function (el) { el.checked = true; });
    });
    document.getElementById('uncheckAllPerms').addEventListener('click', function () {
        document.querySelectorAll('.perm-checkbox').forEach(function (el) { el.checked = false; });
    });

    // Visual feedback on perm-card click
    document.querySelectorAll('.perm-card').forEach(function (card) {
        card.addEventListener('click', function () {
            var cb = this.querySelector('input');
            // checkbox state toggled by label click (default behaviour), just update visual
            setTimeout(function () {
                // :has() handles the CSS, nothing extra needed
            }, 0);
        });
    });
</script>
@endsection

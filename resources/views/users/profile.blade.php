@extends('layouts.v2_master')

@section('styles')
<style>
    .profile-banner {
        height: 140px; border-radius: 16px 16px 0 0;
        background: linear-gradient(135deg, #34c38f 0%, #556ee6 60%, #f1b44c 100%);
    }
    .profile-avatar-lg {
        width: 88px; height: 88px; border-radius: 50%; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        font-size: 32px; font-weight: 700; color: #fff;
        background: linear-gradient(135deg, #556ee6, #6f42c1);
        border: 4px solid #fff; box-shadow: 0 6px 20px rgba(85,110,230,.35);
    }
    .info-row { padding: 10px 0; border-bottom: 1px solid #f0f0f0; }
    .info-row:last-child { border-bottom: none; }
    .perm-chip {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 5px 12px; border-radius: 20px; font-size: 12px;
        margin: 3px; font-weight: 500;
    }
    .section-divider {
        display: flex; align-items: center; gap: 12px; margin: 20px 0 16px;
        color: #adb5bd; font-size: 12px; font-weight: 600; text-transform: uppercase;
    }
    .section-divider::after { content:''; flex:1; height:1px; background:#e9ecef; }
    .pw-strength { height: 4px; border-radius: 2px; transition: width .3s, background .3s; }
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
                <li class="breadcrumb-item active">{{ __('messages.profile') }}</li>
            </ol>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        @foreach($errors->all() as $e) {{ $e }}<br> @endforeach
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row g-3">

    {{-- LEFT: banner + avatar + info + forms --}}
    <div class="col-xl-8">

        {{-- Banner card --}}
        <div class="card rounded-3 mb-3">
            <div class="profile-banner"></div>
            <div class="px-4 pb-4">
                {{-- Avatar pulled up into banner --}}
                <div class="d-flex align-items-end justify-content-between" style="margin-top:-44px">
                    <div class="profile-avatar-lg">
                        {{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}
                    </div>
                    <div class="pb-1">
                        <span class="badge fs-6
                            @if($user->role == 4) bg-success-subtle text-success
                            @elseif($user->role == 2) bg-warning-subtle text-warning
                            @elseif($user->role == 3) bg-info-subtle text-info
                            @else bg-danger-subtle text-danger @endif"
                            style="padding:6px 14px">
                            {{ $user->roleName() ?? '—' }}
                        </span>
                    </div>
                </div>
                <div class="mt-3">
                    <h4 class="fw-bold mb-0">{{ $user->name }}</h4>
                    <p class="text-muted mb-0">{{ $user->email }}</p>
                </div>
            </div>
        </div>

        {{-- ── Edit form ─────────────────────────────────────────────── --}}
        <form action="{{ route('profile.update') }}" method="POST" id="profileForm">
            @csrf

            {{-- Basic info --}}
            <div class="card rounded-3 mb-3">
                <div class="card-header py-2 px-4">
                    <h6 class="mb-0">
                        <i class="fas fa-user-edit text-primary me-2"></i>
                        {{ __('messages.update') ?? 'Ma\'lumotlarni tahrirlash' }}
                    </h6>
                </div>
                <div class="card-body px-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                {{ __('messages.fullname') }} <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="name" class="form-control"
                                   value="{{ old('name', $user->name) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">{{ __('messages.phone') }}</label>
                            <input type="text" name="phone" class="form-control" id="profile_phone"
                                   value="{{ old('phone', $user->phone) }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">{{ __('messages.address') }}</label>
                            <input type="text" name="address" class="form-control"
                                   value="{{ old('address', $user->address) }}">
                        </div>
                        {{-- Email: read-only (contact admin to change) --}}
                        <div class="col-12">
                            <label class="form-label fw-semibold text-muted">
                                {{ __('messages.email') }}
                                <small class="text-muted fw-normal">({{ __('messages.contact_admin_to_change') ?? 'o\'zgartirish uchun adminiga murojaat qiling' }})</small>
                            </label>
                            <input type="text" class="form-control bg-light" value="{{ $user->email }}" readonly>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Change password --}}
            <div class="card rounded-3 mb-3">
                <div class="card-header py-2 px-4">
                    <h6 class="mb-0">
                        <i class="fas fa-lock text-warning me-2"></i>
                        {{ __('messages.change_password') ?? 'Parolni o\'zgartirish' }}
                        <small class="text-muted fw-normal ms-1">({{ __('messages.optional') ?? 'ixtiyoriy' }})</small>
                    </h6>
                </div>
                <div class="card-body px-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">
                                {{ __('messages.current_password') ?? 'Joriy parol' }}
                            </label>
                            <div class="input-group">
                                <input type="password" name="current_password" class="form-control"
                                       id="cur_pw" autocomplete="current-password">
                                <button class="btn btn-outline-secondary" type="button"
                                        onclick="toggleField('cur_pw','cur_pw_icon')">
                                    <i class="fas fa-eye" id="cur_pw_icon"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">
                                {{ __('messages.new_password') ?? 'Yangi parol' }}
                            </label>
                            <div class="input-group">
                                <input type="password" name="password" class="form-control"
                                       id="new_pw" autocomplete="new-password"
                                       oninput="checkStrength(this.value)">
                                <button class="btn btn-outline-secondary" type="button"
                                        onclick="toggleField('new_pw','new_pw_icon')">
                                    <i class="fas fa-eye" id="new_pw_icon"></i>
                                </button>
                            </div>
                            <div class="mt-1">
                                <div class="bg-light rounded" style="height:4px">
                                    <div class="pw-strength rounded" id="pw_strength_bar"
                                         style="width:0%;background:#fd625e"></div>
                                </div>
                                <small id="pw_strength_label" class="text-muted"></small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">
                                {{ __('messages.confirm_password') }}
                            </label>
                            <div class="input-group">
                                <input type="password" name="confirm-password" class="form-control"
                                       id="conf_pw" autocomplete="new-password">
                                <button class="btn btn-outline-secondary" type="button"
                                        onclick="toggleField('conf_pw','conf_pw_icon')">
                                    <i class="fas fa-eye" id="conf_pw_icon"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('home') }}" class="btn btn-light btn-lg">
                    <i class="fas fa-times me-1"></i>{{ __('messages.cancel') }}
                </a>
                <button type="submit" class="btn btn-primary btn-lg waves-effect">
                    <i class="fas fa-save me-1"></i>{{ __('messages.save') }}
                </button>
            </div>
        </form>
    </div>

    {{-- RIGHT: permissions + account info --}}
    <div class="col-xl-4">

        {{-- Account info --}}
        <div class="card rounded-3 mb-3">
            <div class="card-header py-2 px-3">
                <h6 class="mb-0">
                    <i class="fas fa-info-circle text-primary me-2"></i>
                    {{ __('messages.account_info') ?? 'Hisob ma\'lumotlari' }}
                </h6>
            </div>
            <div class="card-body px-3 py-2">
                <div class="info-row d-flex align-items-center justify-content-between">
                    <span class="text-muted" style="font-size:13px">{{ __('messages.email') }}</span>
                    <span class="fw-semibold" style="font-size:13px">{{ $user->email }}</span>
                </div>
                <div class="info-row d-flex align-items-center justify-content-between">
                    <span class="text-muted" style="font-size:13px">{{ __('messages.phone') }}</span>
                    <span class="fw-semibold" style="font-size:13px">{{ $user->phone ?? '—' }}</span>
                </div>
                <div class="info-row d-flex align-items-center justify-content-between">
                    <span class="text-muted" style="font-size:13px">{{ __('messages.role') }}</span>
                    <span class="badge
                        @if($user->role == 4) bg-success-subtle text-success
                        @elseif($user->role == 2) bg-warning-subtle text-warning
                        @elseif($user->role == 3) bg-info-subtle text-info
                        @else bg-danger-subtle text-danger @endif">
                        {{ $user->roleName() ?? '—' }}
                    </span>
                </div>
                <div class="info-row d-flex align-items-center justify-content-between">
                    <span class="text-muted" style="font-size:13px">{{ __('messages.address') }}</span>
                    <span class="text-dark text-end" style="font-size:13px;max-width:160px">{{ $user->address ?? '—' }}</span>
                </div>
            </div>
        </div>

        {{-- Permissions (read-only) --}}
        <div class="card rounded-3">
            <div class="card-header py-2 px-3">
                <h6 class="mb-0">
                    <i class="fas fa-shield-alt text-success me-2"></i>
                    {{ __('messages.permissions') ?? 'Ruxsatlar' }}
                    <span class="badge bg-success-subtle text-success ms-1">{{ count($userPermissions) }}</span>
                </h6>
            </div>
            <div class="card-body px-3 py-2">
                @if(count($userPermissions) > 0)
                    @foreach($permissions as $permKey => $permData)
                        @if(in_array($permKey, $userPermissions))
                            <span class="perm-chip bg-{{ $permData['color'] }}-subtle text-{{ $permData['color'] }}">
                                <i class="{{ $permData['icon'] }}" style="font-size:11px"></i>
                                {{ $permData['label'] }}
                            </span>
                        @endif
                    @endforeach
                @else
                    <p class="text-muted text-center py-3 mb-0" style="font-size:13px">
                        <i class="fas fa-lock opacity-50 d-block mb-1"></i>
                        {{ __('messages.no_permissions') ?? 'Ruxsatlar yo\'q' }}
                    </p>
                @endif
            </div>
        </div>

    </div>

</div>

@endsection

@section('scripts')
<script>
    // Phone mask
    if (document.getElementById('profile_phone')) {
        IMask(document.getElementById('profile_phone'), { mask: '(00)0000000' });
    }

    // Password visibility toggle
    function toggleField(fieldId, iconId) {
        var f = document.getElementById(fieldId);
        var i = document.getElementById(iconId);
        if (f.type === 'password') {
            f.type = 'text';
            i.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            f.type = 'password';
            i.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }

    // Password strength meter
    function checkStrength(val) {
        var bar   = document.getElementById('pw_strength_bar');
        var label = document.getElementById('pw_strength_label');
        if (!val) { bar.style.width = '0%'; label.textContent = ''; return; }
        var score = 0;
        if (val.length >= 6)  score++;
        if (val.length >= 10) score++;
        if (/[A-Z]/.test(val)) score++;
        if (/[0-9]/.test(val)) score++;
        if (/[^A-Za-z0-9]/.test(val)) score++;
        var levels = [
            { w: '20%',  c: '#fd625e', t: '{{ __("messages.very_weak")  ?? "Juda zaif" }}' },
            { w: '40%',  c: '#f46a6a', t: '{{ __("messages.weak")       ?? "Zaif" }}' },
            { w: '60%',  c: '#f1b44c', t: '{{ __("messages.medium")     ?? "O\'rtacha" }}' },
            { w: '80%',  c: '#34c38f', t: '{{ __("messages.strong")     ?? "Kuchli" }}' },
            { w: '100%', c: '#1cbb8c', t: '{{ __("messages.very_strong")?? "Juda kuchli" }}' },
        ];
        var lv = levels[Math.min(score, 4)];
        bar.style.width      = lv.w;
        bar.style.background = lv.c;
        label.textContent    = lv.t;
        label.style.color    = lv.c;
    }

    // Confirm password match visual
    document.getElementById('conf_pw').addEventListener('input', function () {
        var pw  = document.getElementById('new_pw').value;
        this.style.borderColor = (this.value && this.value !== pw) ? '#fd625e' : '';
    });
</script>
@endsection

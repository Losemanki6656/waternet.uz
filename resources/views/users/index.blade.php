@extends('layouts.v2_master')

@section('styles')
<style>
    .user-card { border: none; border-radius: 14px; transition: transform .15s, box-shadow .15s; }
    .user-card:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(0,0,0,.1) !important; }
    .avatar-initials {
        width: 64px; height: 64px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 22px; font-weight: 700; color: #fff; flex-shrink: 0;
    }
    .perm-badge {
        display: inline-flex; align-items: center; gap: 4px;
        font-size: 11px; padding: 3px 8px; border-radius: 20px;
        margin: 2px 2px 2px 0;
    }
    .role-badge { font-size: 12px; padding: 4px 10px; border-radius: 8px; }
    .offcanvas-perm-grid {
        display: grid; grid-template-columns: 1fr 1fr; gap: 8px;
    }
    .perm-check-card {
        border: 1.5px solid #e9ecef; border-radius: 10px; padding: 10px 12px;
        cursor: pointer; transition: border-color .15s, background .15s;
    }
    .perm-check-card:has(input:checked) {
        border-color: #556ee6; background: rgba(85,110,230,.06);
    }
</style>
@endsection

@section('content')

{{-- Page title --}}
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">{{ __('messages.users') }}</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('messages.home') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('messages.users') }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

{{-- Add user button --}}
<div class="d-flex justify-content-between align-items-center mb-3">
    <span class="text-muted">
        {{ __('messages.users') }}: <strong>{{ $users->count() }}</strong>
    </span>
    <button class="btn btn-primary waves-effect waves-light" type="button"
            data-bs-toggle="offcanvas" data-bs-target="#addUserCanvas">
        <i class="fas fa-user-plus me-1"></i> {{ __('messages.add_user') }}
    </button>
</div>

{{-- User cards --}}
<div class="row g-3">
    @forelse ($users as $user)
        @php
            $avatarColors = ['#556ee6','#34c38f','#f1b44c','#f46a6a','#50a5f1','#74788d'];
            $color = $avatarColors[$loop->index % count($avatarColors)];
            $initials = mb_strtoupper(mb_substr($user->name, 0, 1));
        @endphp
        <div class="col-xl-3 col-sm-6">
            <div class="card user-card mb-0 h-100">
                <div class="card-body pb-2">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="avatar-initials" style="background: linear-gradient(135deg, {{ $color }}, {{ $color }}cc)">
                            {{ $initials }}
                        </div>
                        <div class="flex-grow-1 overflow-hidden">
                            <h6 class="fw-bold mb-1 text-truncate">{{ $user->name }}</h6>
                            <span class="role-badge
                                @if($user->role == 4) badge bg-success-subtle text-success
                                @elseif($user->role == 2) badge bg-warning-subtle text-warning
                                @elseif($user->role == 3) badge bg-info-subtle text-info
                                @else badge bg-danger-subtle text-danger @endif">
                                {{ $user->roleName() ?? '—' }}
                            </span>
                        </div>
                    </div>

                    <p class="text-muted mb-1" style="font-size:13px">
                        <i class="fas fa-phone text-primary me-1"></i>{{ $user->phone ?? '—' }}
                    </p>
                    <p class="text-muted mb-2 text-truncate" style="font-size:13px">
                        <i class="fas fa-envelope text-primary me-1"></i>{{ $user->email }}
                    </p>

                    {{-- Permission badges --}}
                    @if($user->permissions->count())
                        <div class="mb-2">
                            @foreach($user->permissions as $perm)
                                @php $meta = $permissions[$perm->name] ?? null; @endphp
                                @if($meta)
                                    <span class="perm-badge badge bg-{{ $meta['color'] }}-subtle text-{{ $meta['color'] }}">
                                        <i class="{{ $meta['icon'] }}"></i>
                                        {{ $meta['label'] }}
                                    </span>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="card-footer bg-transparent border-0 pt-0">
                    <div class="d-flex gap-2">
                        <a href="{{ route('users.edit', $user->id) }}"
                           class="btn btn-soft-primary btn-sm flex-grow-1 waves-effect">
                            <i class="fas fa-user-edit me-1"></i>{{ __('messages.profile') }}
                        </a>
                        <button type="button" class="btn btn-soft-danger btn-sm waves-effect"
                                onclick="DeleteUser('{{ addslashes($user->name) }}', {{ $user->id }})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card text-center py-5">
                <i class="fas fa-users fa-3x text-muted opacity-50 mb-3"></i>
                <p class="text-muted">{{ __('messages.no_data') ?? 'No users found' }}</p>
            </div>
        </div>
    @endforelse
</div>

{{-- ── Add user offcanvas ──────────────────────────────────────────── --}}
<div class="offcanvas offcanvas-end" style="width:460px" tabindex="-1"
     id="addUserCanvas" aria-labelledby="addUserCanvasLabel">
    <div class="offcanvas-header border-bottom">
        <h5 id="addUserCanvasLabel" class="mb-0">
            <i class="fas fa-user-plus text-primary me-2"></i>{{ __('messages.add_new_user') }}
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <form action="{{ route('user_create') }}" method="post" id="createUserForm">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold">{{ __('messages.fullname') }} <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="name"
                       placeholder="{{ __('messages.fullname') }}" required>
            </div>

            <div class="row mb-3">
                <div class="col-7">
                    <label class="form-label fw-semibold">{{ __('messages.email') }} <span class="text-danger">*</span></label>
                    <input class="form-control" type="email" name="email" required>
                </div>
                <div class="col-5">
                    <label class="form-label fw-semibold">{{ __('messages.phone') }}</label>
                    <input class="form-control" type="text" name="phone" id="userphone">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label class="form-label fw-semibold">{{ __('messages.password') }} <span class="text-danger">*</span></label>
                    <input class="form-control" type="password" name="password" required>
                </div>
                <div class="col">
                    <label class="form-label fw-semibold">{{ __('messages.confirm_password') }} <span class="text-danger">*</span></label>
                    <input class="form-control" type="password" name="confirm-password" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">{{ __('messages.address') }}</label>
                <input class="form-control" type="text" name="address">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">{{ __('messages.role') }} <span class="text-danger">*</span></label>
                <select class="form-select" name="role" required>
                    @foreach ($roles as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Permissions --}}
            <div class="mb-3">
                <label class="form-label fw-semibold d-flex align-items-center justify-content-between">
                    <span><i class="fas fa-shield-alt text-primary me-1"></i>{{ __('messages.permissions') ?? 'Ruxsatlar' }}</span>
                    <button type="button" class="btn btn-link btn-sm p-0 text-muted" id="checkAllCreate">
                        {{ __('messages.select_all') ?? 'Hammasini tanlash' }}
                    </button>
                </label>
                <div class="offcanvas-perm-grid">
                    @foreach ($permissions as $permKey => $permData)
                        <label class="perm-check-card d-flex align-items-center gap-2 mb-0">
                            <input class="form-check-input perm-create-check mt-0" type="checkbox"
                                   name="permissions[]" value="{{ $permKey }}"
                                   id="cperm_{{ $permKey }}">
                            <div>
                                <i class="{{ $permData['icon'] }} text-{{ $permData['color'] }}"></i>
                                <span style="font-size:13px">{{ $permData['label'] }}</span>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="button" class="btn btn-secondary btn-lg flex-grow-1" data-bs-dismiss="offcanvas">
                    <i class="fas fa-times me-1"></i>{{ __('messages.cancel') }}
                </button>
                <button type="submit" class="btn btn-primary btn-lg flex-grow-1">
                    <i class="fas fa-save me-1"></i>{{ __('messages.save') }}
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Phone mask
    IMask(document.getElementById('userphone'), { mask: '(00)0000000' });

    // Select all permissions toggle
    var _allChecked = false;
    document.getElementById('checkAllCreate').addEventListener('click', function () {
        _allChecked = !_allChecked;
        document.querySelectorAll('.perm-create-check').forEach(function (el) {
            el.checked = _allChecked;
        });
        this.textContent = _allChecked
            ? '{{ __("messages.deselect_all") ?? "Hammasini olib tashlash" }}'
            : '{{ __("messages.select_all") ?? "Hammasini tanlash" }}';
    });

    // Delete user
    function DeleteUser(fullname, id) {
        Swal.fire({
            title: "{{ __('messages.Do_you_want_to_delete') }} ?",
            text:  fullname,
            icon:  'warning',
            showCancelButton:   true,
            cancelButtonText:   "{{ __('messages.no') }}",
            confirmButtonColor: '#1c84ee',
            cancelButtonColor:  '#fd625e',
            confirmButtonText:  "{{ __('messages.Yes_delete') }} !"
        }).then(function (e) {
            if (!e.isConfirmed) return;
            $.ajax({
                url:    "{{ route('user_destroy') }}",
                method: 'POST',
                data:   { _token: '{{ csrf_token() }}', id: id },
                success: function () {
                    Swal.fire("{{ __('messages.deleted') }}!",
                        "{{ __('messages.success_removed') }}", 'success')
                        .then(function () { location.reload(); });
                },
                error: function (xhr) {
                    alertify.error((xhr.responseJSON && xhr.responseJSON.message) || 'Error');
                }
            });
        });
    }
</script>
@endsection

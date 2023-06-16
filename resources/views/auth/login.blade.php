@extends('layouts.app')
@section('content')
    <div class="auth-content my-auto">
        <div class="text-center">
            <h5 class="mb-0">{{ __('messages.welcome_back') }}!</h5>
            <p class="text-muted mt-2">{{ __('messages.Sign_in_to_continue_to_Waternet') }}.</p>
        </div>
        <form class="mt-4 pt-2" action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-floating form-floating-custom mb-4">
                <input type="email" class="form-control" id="input-username" placeholder="{{ __('messages.enter_email') }}"
                    name="email" value="{{ old('email') }}" required>
                <label for="input-username">{{ __('messages.email') }}</label>
                <div class="form-floating-icon">
                    <i data-feather="mail"></i>
                </div>
            </div>

            <div class="form-floating form-floating-custom mb-4 auth-pass-inputgroup">
                <input type="password" class="form-control pe-5" id="password-input" name="password"
                    placeholder="{{ __('messages.enter_password') }}" required>

                <button type="button" class="btn btn-link position-absolute h-100 end-0 top-0" id="password-addon">
                    <i class="mdi mdi-eye-outline font-size-18 text-muted"></i>
                </button>
                <label for="input-password">{{ __('messages.password') }}</label>
                <div class="form-floating-icon">
                    <i data-feather="lock"></i>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col">
                    <div class="form-check font-size-15">
                        <input class="form-check-input" type="checkbox" id="remember-check">
                        <label class="form-check-label font-size-13" for="remember-check">
                            {{ __('messages.remember_me') }}
                        </label>
                    </div>
                </div>

            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary w-100 waves-effect waves-light"
                    type="submit">{{ __('messages.login') }}</button>
            </div>
        </form>

        <div class="mt-4 pt-2 text-center">
            <div class="signin-other-title">
                <h5 class="font-size-14 mb-3 text-muted fw-medium">- {{ __('messages.sign_in_with') }} -</h5>
            </div>

            <ul class="list-inline mb-0">
                <li class="list-inline-item">
                    <a href="javascript:void()" class="social-list-item bg-primary text-white border-primary">
                        <i class="mdi mdi-facebook"></i>
                    </a>
                </li>
                <li class="list-inline-item">
                    <a href="javascript:void()" class="social-list-item bg-info text-white border-info">
                        <i class="mdi mdi-twitter"></i>
                    </a>
                </li>
                <li class="list-inline-item">
                    <a href="javascript:void()" class="social-list-item bg-danger text-white border-danger">
                        <i class="mdi mdi-google"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        @error('password')
            alertify.error('{{ $message }}');
        @enderror

        @error('email')
            alertify.error('{{ $message }}');
        @enderror
    </script>
@endpush

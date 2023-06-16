@extends('layouts.v2_master')


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ __('messages.users') }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('messages.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('messages.users') }}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <a class="btn btn-primary btn-lg waves-effect waves-light" type="button" data-bs-toggle="offcanvas"
        data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
        <span class="fa fa-plus me-1"></span> {{ __('messages.add_user') }}
    </a>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasRightLabel">{{ __('messages.add_new_user') }}</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form class="needs-validation" novalidate action="{{ route('user_create') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label class="mb-0"> {{ __('messages.fullname') }} </label>
                    <input type="text" class="form-control" name="name" placeholder="{{ __('messages.fullname') }}"
                        required>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="mb-0">{{ __('messages.email') }}:</label>
                        <input class="form-control" type="email" name="email" required>
                    </div>
                    <div class="col-md-6">
                        <label class="mb-0">{{ __('messages.phone') }}:</label>
                        <input class="form-control" type="text" name="phone" id="userphone" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="mb-0">{{ __('messages.password') }}:</label>
                        <input class="form-control" type="password" name="password" required>
                    </div>

                    <div class="col-md-6">
                        <label class="mb-0">{{ __('messages.confirm_password') }}:</label>
                        <input class="form-control" type="password" name="confirm-password" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="mb-0">{{ __('messages.address') }}:</label>
                    <input class="form-control" type="text" name="address" required>
                </div>

                <div class="mb-3">
                    <label class="mb-0"> Roli: </label>
                    <select class="form-select" name="role" required>
                        @foreach ($roles as $key => $value)
                            <option value={{ $key }}>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="formCheck1" name="bosh">
                            <label class="form-check-label" for="formCheck1">
                                Bosh menu
                            </label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="formCheck2" name="client">
                            <label class="form-check-label" for="formCheck2">
                                Klientlar
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="formCheck3" name="order">
                            <label class="form-check-label" for="formCheck3">
                                Zakazlar
                            </label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="formCheck4" name="product">
                            <label class="form-check-label" for="formCheck4">
                                Tovarlar
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="formCheck5" name="sklad">
                            <label class="form-check-label" for="formCheck5">
                                Sklad
                            </label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="formCheck6" name="users">
                            <label class="form-check-label" for="formCheck6">
                                Xodimlar
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="formCheck7" name="regions">
                            <label class="form-check-label" for="formCheck7">
                                Regionlar
                            </label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="formCheck8" name="sms">
                            <label class="form-check-label" for="formCheck8">
                                Sms
                            </label>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="formCheck9" name="results">
                        <label class="form-check-label" for="formCheck9">
                            Xisobotlar
                        </label>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col">
                        <div class="d-grid">
                            <button type="button" class="btn btn-secondary btn-lg waves-effect waves-light"
                                data-bs-dismiss="offcanvas"><i class="fas fa-reply me-2"></i>
                                {{ __('messages.cancel') }}</button>
                        </div>
                    </div>
                    <div class="col">
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg waves-effect waves-light"><i
                                    class="fas fa-save me-2"></i> {{ __('messages.save') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row mt-3">
        @foreach ($users as $user)
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <img src="{{ asset('assets/images/user.jpg') }}" alt=""
                                    class="avatar-lg rounded-circle img-thumbnail">
                            </div>
                            <div class="flex-1 ms-3">
                                <h5 class="font-size-15 mb-1"><a href="#"
                                        class="text-dark">{{ $user->name }}</a>
                                </h5>
                                <p class="text-muted mb-0">
                                    @if (auth()->user()->id == 1)
                                        @if ($user->id != 1)
                                            <span class="badge badge-soft-primary"> {{ $user->organization->name }}</span>
                                        @endif
                                    @else
                                        @if ($user->role == 4)
                                            <span class="badge badge-soft-success"> Director</span>
                                        @endif
                                        @if ($user->role == 2)
                                            <span class="badge badge-soft-warning"> Warehouse manager</span>
                                        @endif
                                        @if ($user->role == 3)
                                            <span class="badge badge-soft-info"> Driver</span>
                                        @endif
                                        @if ($user->role == 1)
                                            <span class="badge badge-soft-danger"> Operator</span>
                                        @endif
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="mt-3 pt-1">
                            <p class="text-muted mb-0"><i
                                    class="mdi mdi-phone font-size-15 align-middle pe-2 text-primary"></i>
                                {{ $user->phone ?? '(97)7226656' }}</p>
                            <p class="text-muted mb-0 mt-2"><i
                                    class="mdi mdi-email font-size-15 align-middle pe-2 text-primary"></i>
                                {{ $user->email }}</p>
                            <p class="text-muted mb-0 mt-2"><i
                                    class="mdi mdi-google-maps font-size-15 align-middle pe-2 text-primary"></i>
                                {{ $user->address ?? 'Buxoro viloyati' }}</p>
                        </div>
                    </div>

                    <div class="btn-group" role="group">
                        <a type="button" href="{{ route('users.edit', $user->id) }}"
                            class="btn btn-outline-light text-truncate"><i class="uil uil-user me-1"></i>
                            {{ __('messages.profile') }}</a>
                        <a type="button" class="btn btn-outline-light text-truncate"
                            onclick="DeleteUser('{{ $user->name }}', {{ $user->id }})"><i
                                class="uil uil-envelope-alt me-1"></i>
                            {{ __('messages.delete') }}</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@section('scripts')
    <script>
        IMask(document.getElementById("userphone"), {
            mask: [{
                mask: "(00)0000000"
            }]
        });
    </script>
    <script>
        function DeleteUser(fullname, id) {
            Swal.fire({
                title: "{{ __('messages.Do_you_want_to_delete') }} ?",
                text: fullname,
                icon: "warning",
                showCancelButton: !0,
                cancelButtonText: "{{ __('messages.no') }}",
                confirmButtonColor: "#1c84ee",
                cancelButtonColor: "#fd625e",
                confirmButtonText: "{{ __('messages.Yes_delete') }} !"
            }).then(function(e) {
                if (e.isConfirmed) {
                    $.ajax({
                        url: "{{ route('user_destroy') }}",
                        method: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            id: id
                        },
                        success: function(res) {
                            e.value && Swal.fire("{{ __('messages.deleted') }}!",
                                "{{ __('messages.success_removed') }}",
                                "success").then((result) => {
                                location.reload();
                            });

                        },
                        error: function(error) {
                            alertify.error(error.responseJSON.message);
                        }
                    });
                }

            })
        }
    </script>
@endsection

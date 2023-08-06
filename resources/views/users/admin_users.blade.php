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

    <div class="row animate__animated animate__fadeIn">
        <div class="col-lg-3 col-md-6">
            <div class="card mb-0">
                <select class="form-control" data-trigger name="org_id" id="org_id">
                    <option value="">{{ __('messages.shops') }}</option>
                    @foreach ($shops as $shop)
                        <option value={{ $shop->id }} @if ($shop->id == request('org_id')) selected @endif>
                            {{ $shop->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card mb-0">
                <input type="search" class="form-control" name="search" id="search" value="{{ request('search') }}"
                    placeholder="{{ __('messages.search') }}">
            </div>
        </div>

    </div>

    <div class="row mt-3">
        @foreach ($users as $user)
            <div class="col-xl-3 col-sm-6">
                <div class="card animate__animated animate__fadeIn">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <img src="{{ asset('assets/images/user.jpg') }}" alt=""
                                    class="avatar-lg rounded-circle img-thumbnail">
                            </div>
                            <div class="flex-1 ms-3">
                                <h5 class="font-size-15 mb-1"><a href="#" class="text-dark">{{ $user->name }}</a>
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
                                    class="mdi mdi-email font-size-15 align-middle pe-2 text-success"></i>
                                {{ $user->email }}</p>
                            <p class="text-muted mb-0 mt-2"><i
                                    class="mdi mdi-google-maps font-size-15 align-middle pe-2 text-dark"></i>
                                {{ $user->address ?? 'Buxoro viloyati' }}</p>
                            <p class="text-muted mb-0 mt-2"><i
                                    class="mdi mdi-trophy-award font-size-15 align-middle pe-2 text-danger"></i>
                                {{ $user->organization->name ?? 'Admin' }}</p>
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
    @if ($users->total() > 8)
        <div class="row justify-content-between">
            <div class="col-md-2">
                <label>
                    <select class="form-select mx-3" name="paginate_select" id="paginate_select" style="max-width: 100px">
                        <option value="10" @if ($users->perPage() == 8) selected @endif>8
                        </option>
                        <option value="30" @if ($users->perPage() == 16) selected @endif>16
                        </option>
                        <option value="50" @if ($users->perPage() == 32) selected @endif>32
                        </option>
                        <option value="100" @if ($users->perPage() == 80) selected @endif>80
                        </option>
                    </select>
                </label>
            </div>
            <div class="col-md-10 text-end">
                <label class="me-3">{{ $users->onEachSide(1)->withQueryString() }}</label>
            </div>
        </div>
    @endif
@endsection

@section('scripts')
    <script>
        $('#search').keyup(function(e) {
            if (e.keyCode == 13) {
                myFilter();
            }
        });

        $('#data').change(function(e) {
            myFilter();
        });

        $('#org_id').change(function(e) {
            myFilter();
        });

        $('#paginate_select').change(function(e) {
            myFilter();
        });

        function myFilter() {
            let search = $('#search').val();
            let org_id = $('#org_id').val();
            let paginate_select = $('#paginate_select').val() ?? 10;

            let url = '{{ route('users_admin') }}';
            window.location.href =
                `${url}?search=${search}&per_page=${paginate_select}&org_id=${org_id}`;
        }
    </script>
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

@extends('layouts.v2_master')
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="profile-user"
                style="background-image: url({{ asset('assets/images/user_background.jpg') }}); background-position: top; ">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="profile-content">
            <div class="row align-items-end">
                <div class="col-sm">
                    <div class="d-flex align-items-end mt-3 mt-sm-0">
                        <div class="flex-shrink-0">
                            <div class="avatar-xxl me-3">
                                <img src="{{ asset('assets/images/users/avatar-3.jpg') }}" alt=""
                                    class="img-fluid rounded-circle d-block img-thumbnail">
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div>
                                <h5 class="font-size-16 mb-1">{{ $user->name }}</h5>
                                <p class="text-muted font-size-13 mb-2 pb-2">{{ $user->roleName() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-auto">
                    <div class="d-flex align-items-start justify-content-end gap-2 mb-2">
                        <div>
                            <button type="submit" form="update_user"
                                class="btn btn-success btn-lg waves-effect waves-light"><i class="fa fa-save me-2"></i>
                                {{ __('messages.save') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card bg-transparent shadow-none">
                <div class="card-body">
                    <ul class="nav nav-tabs-custom card-header-tabs border-top mt-2" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link px-3 active" data-bs-toggle="tab" href="#overview"
                                role="tab">{{ __('messages.save') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-3">{{ __('messages.actions') }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8 col-lg-8">
            <div class="tab-content">
                <div class="tab-pane active" id="overview" role="tabpanel">
                    <div class="card rounded-4">
                        <div class="card-header">
                            <h2> {{ __('messages.update') }}</h2>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('user_update', $user->id) }}" method="PUT" id="update_user">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <label class="mb-0"> {{ __('messages.fullname') }}: </label>
                                            <input type="text" name="name" class="form-control"
                                                value="{{ $user->name }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="mb-0"> {{ __('messages.email') }}: </label>
                                            <input type="email" name="email" class="form-control"
                                                value="{{ $user->email }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="mb-0"> {{ __('messages.password') }}: </label>
                                            <input type="password" name="password" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label class="mb-0"> {{ __('messages.confirm_password') }}: </label>
                                            <input type="password" name="confirm-password" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label for="middlename"> {{ __('messages.role') }}: </label>
                                            <select class="form-select" name="role" required>
                                                @foreach ($roles as $key => $value)
                                                    <option value={{ $key }}
                                                        @if ($key == $user->role) selected @endif>
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                    <div class="col" style="margin-top: 0px">
                                        <div class="mb-3">
                                            <label class="mb-0"> {{ __('messages.phone') }}: </label>
                                            <input type="text" name="phone" value="{{ $user->phone }}"
                                                class="form-control" id="phone_user" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="mb-0"> {{ __('messages.address') }}: </label>
                                            <input type="text" name="address" value="{{ $user->address }}"
                                                class="form-control" required>
                                        </div>
                                        <div class="mt-3">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="bosh"
                                                            id="formCheck2"
                                                            @if ($p[2] != '0') checked @endif>
                                                        <label class="form-check-label" for="formCheck2">
                                                            Bosh menu
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="client"
                                                            id="formCheck3"
                                                            @if ($p[3] != '0') checked @endif>
                                                        <label class="form-check-label" for="formCheck3">
                                                            Klientlar
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="formCheck4"
                                                            name="order"
                                                            @if ($p[4] != '0') checked @endif>
                                                        <label class="form-check-label" for="formCheck4">
                                                            Zakazlar
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="formCheck9"
                                                            name="product"
                                                            @if ($p[9] != '0') checked @endif>
                                                        <label class="form-check-label" for="formCheck9">
                                                            Tovarlar
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="formCheck6"
                                                            name="sklad"
                                                            @if ($p[6] != '0') checked @endif>
                                                        <label class="form-check-label" for="formCheck6">
                                                            Sklad
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="formCheck10"
                                                            name="users"
                                                            @if ($p[10] != '0') checked @endif>
                                                        <label class="form-check-label" for="formCheck10">
                                                            Xodimlar
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="formCheck5"
                                                            name="regions"
                                                            @if ($p[5] != '0') checked @endif>
                                                        <label class="form-check-label" for="formCheck5">
                                                            Regionlar
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="formCheck7"
                                                            name="sms"
                                                            @if ($p[7] != '0') checked @endif>
                                                        <label class="form-check-label" for="formCheck7">
                                                            Sms
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="formCheck8"
                                                            name="results"
                                                            @if ($p[8] != '0') checked @endif>
                                                        <label class="form-check-label" for="formCheck8">
                                                            Xisobotlar
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-4">

            <div class="card rounded-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">{{ __('messages.team_members') }}</h5>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle table-nowrap">
                            <tbody>
                                @foreach ($users as $item)
                                    <tr>
                                        <td style="width: 50px;"><img src="{{ asset('assets/images/user.jpg') }}"
                                                class="rounded-circle avatar-sm" alt=""></td>
                                        <td>
                                            <h5 class="font-size-14 m-0"><a href="{{ route('users.edit', $item->id) }}"
                                                    class="text-dark">{{ $item->name }}</a></h5>
                                        </td>
                                        <td>
                                            <div>
                                                <a href="javascript: void(0);"
                                                    class="badge bg-primary-subtle text-primary font-size-11">{{ $item->roleName() }}</a>
                                            </div>
                                        </td>
                                        <td>
                                            <i
                                                class="mdi mdi-circle-medium font-size-18 text-success align-middle me-1"></i>
                                            Online
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        IMask(document.getElementById("phone_user"), {
            mask: [{
                mask: "(00)0000000"
            }]
        });
    </script>
@endsection

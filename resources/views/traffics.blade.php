@extends('layouts.v2_master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ __('messages.traffics') }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('messages.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('messages.traffics') }}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    @if (auth()->user()->id == 1)
        <button class="btn btn-primary btn-lg waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#addTraffic"
            type="button"> <i class="fa fa-plus me-2"></i>
            {{ __('messages.add_traffic') }}</button>

        <div class="modal fade" id="addTraffic" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="title" id="defaultModalLabel">Tarif yaratish</h4>
                    </div>
                    <form action="{{ route('add_traffic') }}" method="post">
                        @csrf
                        <div class="modal-body">

                            <div class="mb-3">
                                <label style="margin-bottom: 0">{{ __('messages.traffic') }}:</label>
                                <input class="form-control" type="text" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label style="margin-bottom: 0">{{ __('messages.annotation') }}:</label>
                                <textarea class="form-control" type="text" name="annotation" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label style="margin-bottom: 0">{{ __('messages.price') }}:</label>
                                <input class="form-control" type="number" name="price" required>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label style="margin-bottom: 0">{{ __('messages.clients_count') }}:</label>
                                        <input class="form-control" type="number" name="clients_count" required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label style="margin-bottom: 0">{{ __('messages.reklama_count') }}:</label>
                                        <input class="form-control" type="number" name="sms_count" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label style="margin-bottom: 0">{{ __('messages.products_count') }}:</label>
                                        <input class="form-control" type="number" name="products_count" required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label style="margin-bottom: 0">{{ __('messages.users_count') }}:</label>
                                        <input class="form-control" type="number" name="users_count" required>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label style="margin-bottom: 0"> {{ __('messages.type') }}:</label>
                                <select class="form-select" name="status" required>
                                    <option value="0">Asosiy
                                    </option>
                                    <option value="1">Qo'shimcha
                                    </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label style="margin-bottom: 0"> {{ __('messages.category') }}:</label>
                                <select class="form-select" name="type_traffic" required>
                                    <option value="month">month</option>
                                    <option value="year">year</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-lg waves-effect waves-light"
                                data-bs-dismiss="modal"> <i class="fas fa-reply me-2"></i>
                                {{ __('messages.cancel') }}</button>
                            <button class="btn btn-success btn-lg waves-effect waves-light" type="submit"> <i
                                    class="fa fa-save me-2"></i>
                                {{ __('messages.save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12">

            <div class="text-center mb-4">
                <ul class="nav nav-pills card justify-content-center d-inline-block shadow py-1 px-2" id="pills-tab"
                    role="tablist">
                    <li class="nav-item d-inline-block">
                        <a class="nav-link px-3 rounded active monthly" id="Monthly" data-bs-toggle="pill" href="#month"
                            role="tab" aria-controls="Month" aria-selected="true">
                            {{ __('messages.month') }}</a>
                    </li>
                    <li class="nav-item d-inline-block">
                        <a class="nav-link px-3 rounded yearly" id="Yearly" data-bs-toggle="pill" href="#year"
                            role="tab" aria-controls="Year" aria-selected="false"> {{ __('messages.year') }}
                            <span class="badge bg-success rounded text-white">20% Off </span></a>
                    </li>
                </ul>
            </div>

            <div class="tab-content mb-3" id="pills-tabContent">
                <div class="tab-pane fade active show" id="month" role="tabpanel" aria-labelledby="monthly">
                    <div class="row">
                        @foreach ($month_traffics as $item)
                            @if ($traffic == $item->id)
                                <div class="col-xl-3 col-sm-6 mb-3">
                                    <div class="card bg-primary mb-xl-0">
                                        <div class="card-body">
                                            <div class="p-2">
                                                <div class="pricing-badge">
                                                    <span class="badge">Featured</span>
                                                </div>
                                                <h5 class="font-size-16 text-white">{{ $item->name }}</h5>
                                                <h1 class="mt-3 text-white">{{ $item->price }} <span
                                                        class="text-white font-size-16 fw-medium">/
                                                        {{ __('messages.month') }}</span>
                                                </h1>
                                                <p class="text-white mt-3 font-size-15">{{ $item->annotation }}</p>
                                                <div class="mt-4 pt-2 text-white">
                                                    <p class="mb-3 font-size-15"><i
                                                            class="mdi mdi-check-circle text-white font-size-18 me-2"></i>{{ $item->clients_count }}
                                                        - {{ __('messages.clients') }}</p>
                                                    <p class="mb-3 font-size-15"><i
                                                            class="mdi mdi-check-circle text-white font-size-18 me-2"></i>{{ $item->products_count }}
                                                        - {{ __('messages.products') }}</p>
                                                    <p class="mb-3 font-size-15"><i
                                                            class="mdi mdi-check-circle text-white font-size-18 me-2"></i>{{ $item->sms_count }}
                                                        - {{ __('messages.reklama_for_telegram') }}</p>
                                                    <p class="mb-3 font-size-15"><i
                                                            class="mdi mdi-check-circle text-white font-size-18 me-2"></i>{{ $item->users_count }}
                                                        - {{ __('messages.users') }}
                                                    </p>
                                                    <p class="mb-3 font-size-15"><i
                                                            class="mdi mdi-check-circle text-white font-size-18 me-2"></i>{{ __('messages.bezlimitniy_telegram_posts') }}
                                                    </p>
                                                </div>

                                                <div class="mt-4 pt-2">
                                                    <button type="button"
                                                        class="btn btn-light w-100 mb-3">{{ __('messages.selected') }}</button>
                                                </div>
                                                @if (auth()->user()->id == 1)
                                                    <div class="row">
                                                        <div class="col">
                                                            <button type="button" class="btn btn-dark w-100"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#edit{{ $item->id }}">{{ __('messages.update') }}</button>
                                                        </div>
                                                        <div class="col">
                                                            <button type="button" class="btn btn-danger w-100"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#delete{{ $item->id }}">{{ __('messages.delete') }}</button>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <!-- end card body -->
                                    </div>
                                    <!-- end card -->
                                </div>
                            @else
                                <div class="col-xl-3 col-sm-6 mb-3">
                                    <div class="card mb-xl-0">
                                        <div class="card-body">
                                            <div class="p-2">
                                                <h5 class="font-size-16">{{ $item->name }}</h5>
                                                <h1 class="mt-3">{{ $item->price }} <span
                                                        class="text-muted font-size-16 fw-medium">/
                                                        {{ __('messages.month') }}</span>
                                                </h1>
                                                <p class="text-muted mt-3 font-size-15">{{ $item->annotation }}</p>
                                                <div class="mt-4 pt-2 text-muted">
                                                    <p class="mb-3 font-size-15"><i
                                                            class="mdi mdi-check-circle text-secondary font-size-18 me-2"></i>{{ $item->clients_count }}
                                                        - {{ __('messages.clients') }}</p>
                                                    <p class="mb-3 font-size-15"><i
                                                            class="mdi mdi-check-circle text-secondary font-size-18 me-2"></i>{{ $item->products_count }}
                                                        - {{ __('messages.products') }}</p>
                                                    <p class="mb-3 font-size-15"><i
                                                            class="mdi mdi-check-circle text-secondary font-size-18 me-2"></i>{{ $item->sms_count }}
                                                        - {{ __('messages.reklama_for_telegram') }}</p>
                                                    <p class="mb-3 font-size-15"><i
                                                            class="mdi mdi-check-circle text-secondary font-size-18 me-2"></i>{{ $item->users_count }}
                                                        - {{ __('messages.users') }}
                                                    </p>
                                                    <p class="mb-3 font-size-15"><i
                                                            class="mdi mdi-check-circle text-secondary font-size-18 me-2"></i>{{ __('messages.bezlimitniy_telegram_posts') }}
                                                    </p>
                                                </div>

                                                <div class="mt-4 pt-2">
                                                    <a href=""
                                                        class="btn btn-outline-primary w-100 mb-3">{{ __('messages.selected') }}</a>

                                                </div>
                                                @if (auth()->user()->id == 1)
                                                    <div class="row">
                                                        <div class="col">
                                                            <button type="button" class="btn btn-dark w-100"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#edit{{ $item->id }}">{{ __('messages.update') }}</button>
                                                        </div>
                                                        <div class="col">
                                                            <button type="button" class="btn btn-danger w-100"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#delete{{ $item->id }}">{{ __('messages.delete') }}</button>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <!-- end card body -->
                                    </div>
                                    <!-- end card -->
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <div class="tab-pane fade" id="year" role="tabpanel" aria-labelledby="yearly">
                    <div class="row">
                        @foreach ($year_traffics as $item)
                            @if ($traffic == $item->id)
                                <div class="col-xl-3 col-sm-6 mb-3">
                                    <div class="card bg-primary mb-xl-0">
                                        <div class="card-body">
                                            <div class="p-2">
                                                <div class="pricing-badge">
                                                    <span class="badge">Featured</span>
                                                </div>
                                                <h5 class="font-size-16 text-white">{{ $item->name }}</h5>
                                                <h1 class="mt-3 text-white">{{ $item->price }} <span
                                                        class="text-white font-size-16 fw-medium">/
                                                        {{ __('messages.month') }}</span>
                                                </h1>
                                                <p class="text-white mt-3 font-size-15">{{ $item->annotation }}</p>
                                                <div class="mt-4 pt-2 text-white">
                                                    <p class="mb-3 font-size-15"><i
                                                            class="mdi mdi-check-circle text-white font-size-18 me-2"></i>{{ $item->clients_count }}
                                                        - {{ __('messages.clients') }}</p>
                                                    <p class="mb-3 font-size-15"><i
                                                            class="mdi mdi-check-circle text-white font-size-18 me-2"></i>{{ $item->products_count }}
                                                        - {{ __('messages.products') }}</p>
                                                    <p class="mb-3 font-size-15"><i
                                                            class="mdi mdi-check-circle text-white font-size-18 me-2"></i>{{ $item->sms_count }}
                                                        - {{ __('messages.reklama_for_telegram') }}</p>
                                                    <p class="mb-3 font-size-15"><i
                                                            class="mdi mdi-check-circle text-white font-size-18 me-2"></i>{{ $item->users_count }}
                                                        - {{ __('messages.users') }}
                                                    </p>
                                                    <p class="mb-3 font-size-15"><i
                                                            class="mdi mdi-check-circle text-white font-size-18 me-2"></i>{{ __('messages.bezlimitniy_telegram_posts') }}
                                                    </p>
                                                </div>

                                                <div class="mt-4 pt-2">
                                                    <button type="button"
                                                        class="btn btn-light w-100 mb-3">{{ __('messages.selected') }}</button>
                                                </div>
                                                @if (auth()->user()->id == 1)
                                                    <div class="row">
                                                        <div class="col">
                                                            <button type="button" class="btn btn-dark w-100"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#edit{{ $item->id }}">{{ __('messages.update') }}</button>
                                                        </div>
                                                        <div class="col">
                                                            <button type="button" class="btn btn-danger w-100"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#delete{{ $item->id }}">{{ __('messages.delete') }}</button>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <!-- end card body -->
                                    </div>
                                    <!-- end card -->
                                </div>
                            @else
                                <div class="col-xl-3 col-sm-6 mb-3">
                                    <div class="card mb-xl-0">
                                        <div class="card-body">
                                            <div class="p-2">
                                                <h5 class="font-size-16">{{ $item->name }}</h5>
                                                <h1 class="mt-3">{{ $item->price }} <span
                                                        class="text-muted font-size-16 fw-medium">/
                                                        {{ __('messages.month') }}</span>
                                                </h1>
                                                <p class="text-muted mt-3 font-size-15">{{ $item->annotation }}</p>
                                                <div class="mt-4 pt-2 text-muted">
                                                    <p class="mb-3 font-size-15"><i
                                                            class="mdi mdi-check-circle text-secondary font-size-18 me-2"></i>{{ $item->clients_count }}
                                                        - {{ __('messages.clients') }}</p>
                                                    <p class="mb-3 font-size-15"><i
                                                            class="mdi mdi-check-circle text-secondary font-size-18 me-2"></i>{{ $item->products_count }}
                                                        - {{ __('messages.products') }}</p>
                                                    <p class="mb-3 font-size-15"><i
                                                            class="mdi mdi-check-circle text-secondary font-size-18 me-2"></i>{{ $item->sms_count }}
                                                        - {{ __('messages.reklama_for_telegram') }}</p>
                                                    <p class="mb-3 font-size-15"><i
                                                            class="mdi mdi-check-circle text-secondary font-size-18 me-2"></i>{{ $item->users_count }}
                                                        - {{ __('messages.users') }}
                                                    </p>
                                                    <p class="mb-3 font-size-15"><i
                                                            class="mdi mdi-check-circle text-secondary font-size-18 me-2"></i>{{ __('messages.bezlimitniy_telegram_posts') }}
                                                    </p>
                                                </div>

                                                <div class="mt-4 pt-2">
                                                    <a href=""
                                                        class="btn btn-outline-primary w-100 mb-3">{{ __('messages.selected') }}</a>

                                                </div>
                                                @if (auth()->user()->id == 1)
                                                    <div class="row">
                                                        <div class="col">
                                                            <button type="button" class="btn btn-dark w-100"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#edit{{ $item->id }}">{{ __('messages.update') }}</button>
                                                        </div>
                                                        <div class="col">
                                                            <button type="button" class="btn btn-danger w-100"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#delete{{ $item->id }}">{{ __('messages.delete') }}</button>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <!-- end card body -->
                                    </div>
                                    <!-- end card -->
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <!-- end tab pane -->
            </div>
            <!-- end tab content -->
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->

    @if (auth()->user()->id == 1)
        @foreach ($month_traffics as $item)
            <div class="modal fade" id="edit{{ $item->id }}" tabindex="888" role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="title" id="defaultModalLabel">{{ __('messages.update') }}</h4>
                        </div>
                        <form action="{{ route('edit_traffic', ['id' => $item->id]) }}" method="post">
                            @csrf
                            <div class="modal-body">

                                <div class="mb-3">
                                    <label style="margin-bottom: 0">{{ __('messages.traffic') }}:</label>
                                    <input class="form-control" type="text" name="name"
                                        value="{{ $item->name }}" required>
                                </div>
                                <div class="mb-3">
                                    <label style="margin-bottom: 0">{{ __('messages.annotation') }}:</label>
                                    <textarea class="form-control" type="text" name="annotation" required>{{ $item->annotation }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label style="margin-bottom: 0">{{ __('messages.price') }}:</label>
                                    <input class="form-control" type="number" name="price"
                                        value="{{ $item->price }}" required>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label style="margin-bottom: 0">{{ __('messages.clients_count') }}:</label>
                                            <input class="form-control" type="number" name="clients_count"
                                                value="{{ $item->clients_count }}" required>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label style="margin-bottom: 0">{{ __('messages.reklama_count') }}:</label>
                                            <input class="form-control" type="number" name="sms_count"
                                                value="{{ $item->sms_count }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label style="margin-bottom: 0">{{ __('messages.products_count') }}:</label>
                                            <input class="form-control" type="number" name="products_count"
                                                value="{{ $item->products_count }}" required>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label style="margin-bottom: 0">{{ __('messages.users_count') }}:</label>
                                            <input class="form-control" type="number" name="users_count"
                                                value="{{ $item->users_count }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label style="margin-bottom: 0"> {{ __('messages.type') }}:</label>
                                    <select class="form-select" name="status" required>
                                        <option value="0" @if ($item->status == 0) selected @endif>Asosiy
                                        </option>
                                        <option value="1" @if ($item->status == 1) selected @endif>Qo'shimcha
                                        </option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label style="margin-bottom: 0"> {{ __('messages.category') }}:</label>
                                    <select class="form-select" name="type_traffic" required>
                                        <option value="month" @if ($item->type_traffic == 'month') selected @endif>month
                                        </option>
                                        <option value="year" @if ($item->type_traffic == 'year') selected @endif>year
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-lg waves-effect waves-light"
                                    data-bs-dismiss="modal"> <i class="fas fa-reply me-2"></i>
                                    {{ __('messages.cancel') }}</button>
                                <button class="btn btn-success btn-lg waves-effect waves-light" type="submit"> <i
                                        class="fa fa-save me-2"></i>
                                    {{ __('messages.save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="delete{{ $item->id }}" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="title" id="defaultModalLabel">{{ __('messages.delete') }}</h4>
                        </div>
                        <form action="{{ route('delete_traffic', ['id' => $item->id]) }}" method="post">
                            @csrf
                            <div class="modal-body">

                                <div class="mb-3">
                                    <label style="margin-bottom: 0">{{ $item->name }} {{ __('messages.delete') }}
                                        ?</label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-lg waves-effect waves-light"
                                    data-bs-dismiss="modal"> <i class="fas fa-reply me-2"></i>
                                    {{ __('messages.cancel') }}</button>
                                <button class="btn btn-danger btn-lg waves-effect waves-light" type="submit"> <i
                                        class="fa fa-save me-2"></i>
                                    {{ __('messages.delete') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

        @foreach ($year_traffics as $item)
            <div class="modal fade" id="edit{{ $item->id }}" tabindex="888" role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="title" id="defaultModalLabel">{{ __('messages.update') }}</h4>
                        </div>
                        <form action="{{ route('edit_traffic', ['id' => $item->id]) }}" method="post">
                            @csrf
                            <div class="modal-body">

                                <div class="mb-3">
                                    <label style="margin-bottom: 0">{{ __('messages.traffic') }}:</label>
                                    <input class="form-control" type="text" name="name"
                                        value="{{ $item->name }}" required>
                                </div>
                                <div class="mb-3">
                                    <label style="margin-bottom: 0">{{ __('messages.annotation') }}:</label>
                                    <textarea class="form-control" type="text" name="annotation" required>{{ $item->annotation }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label style="margin-bottom: 0">{{ __('messages.price') }}:</label>
                                    <input class="form-control" type="number" name="price"
                                        value="{{ $item->price }}" required>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label style="margin-bottom: 0">{{ __('messages.clients_count') }}:</label>
                                            <input class="form-control" type="number" name="clients_count"
                                                value="{{ $item->clients_count }}" required>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label style="margin-bottom: 0">{{ __('messages.reklama_count') }}:</label>
                                            <input class="form-control" type="number" name="sms_count"
                                                value="{{ $item->sms_count }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label style="margin-bottom: 0">{{ __('messages.products_count') }}:</label>
                                            <input class="form-control" type="number" name="products_count"
                                                value="{{ $item->products_count }}" required>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label style="margin-bottom: 0">{{ __('messages.users_count') }}:</label>
                                            <input class="form-control" type="number" name="users_count"
                                                value="{{ $item->users_count }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label style="margin-bottom: 0"> {{ __('messages.type') }}:</label>
                                    <select class="form-select" name="status" required>
                                        <option value="0" @if ($item->status == 0) selected @endif>Asosiy
                                        </option>
                                        <option value="1" @if ($item->status == 1) selected @endif>
                                            Qo'shimcha
                                        </option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label style="margin-bottom: 0"> {{ __('messages.category') }}:</label>
                                    <select class="form-select" name="type_traffic" required>
                                        <option value="month" @if ($item->type_traffic == 'month') selected @endif>month
                                        </option>
                                        <option value="year" @if ($item->type_traffic == 'year') selected @endif>year
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-lg waves-effect waves-light"
                                    data-bs-dismiss="modal"> <i class="fas fa-reply me-2"></i>
                                    {{ __('messages.cancel') }}</button>
                                <button class="btn btn-success btn-lg waves-effect waves-light" type="submit"> <i
                                        class="fa fa-save me-2"></i>
                                    {{ __('messages.save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="delete{{ $item->id }}" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="title" id="defaultModalLabel">{{ __('messages.delete') }}</h4>
                        </div>
                        <form action="{{ route('delete_traffic', ['id' => $item->id]) }}" method="post">
                            @csrf
                            <div class="modal-body">

                                <div class="mb-3">
                                    <label style="margin-bottom: 0">{{ $item->name }} {{ __('messages.delete') }}
                                        ?</label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-lg waves-effect waves-light"
                                    data-bs-dismiss="modal"> <i class="fas fa-reply me-2"></i>
                                    {{ __('messages.cancel') }}</button>
                                <button class="btn btn-danger btn-lg waves-effect waves-light" type="submit"> <i
                                        class="fa fa-save me-2"></i>
                                    {{ __('messages.delete') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
@endsection

@push('scripts')
@endpush

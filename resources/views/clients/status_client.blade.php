@extends('layouts.v2_master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ __('messages.accept_order') }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('messages.home') }}</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('messages.Orders') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('messages.accept_order') }}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-h-100 rounded-4">
                <!-- card body -->
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <span
                                class="text-muted mb-3 lh-1 d-block text-truncate">{{ __('messages.client_balance') }}</span>
                            <h4 class="mb-3">
                                <span class="counter-value" data-target="{{ $client_info->balance }}">0</span> UZS
                            </h4>
                            <div class="text-nowrap">
                                <span class="badge bg-success-subtle text-success">+$20.9k</span>
                                <span class="ms-1 text-muted font-size-13">Since last week</span>
                            </div>
                        </div>
                        <div class="flex-shrink-0 text-end">
                            <i class="fas fa-2x fa-dollar-sign text-success"></i>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-h-100 rounded-4">
                <!-- card body -->
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <span
                                class="text-muted mb-3 lh-1 d-block text-truncate">{{ __('messages.debt_container') }}</span>
                            <h4 class="mb-3">
                                <span class="counter-value" data-target="{{ $client_info->container }}">0</span>
                            </h4>
                            <div class="text-nowrap">
                                <span class="badge bg-danger-subtle text-danger">-29 Trades</span>
                                <span class="ms-1 text-muted font-size-13">Since last week</span>
                            </div>
                        </div>
                        <div class="flex-shrink-0 text-end">
                            <i class="fas fa-box-open fa-2x text-danger"></i>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col-->

        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-h-100 rounded-4">
                <!-- card body -->
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <span
                                class="text-muted mb-3 lh-1 d-block text-truncate">{{ __('messages.orders_count') }}</span>
                            <h4 class="mb-3">
                                <span class="counter-value" data-target="{{ $client_info->product_count }}">0</span>
                            </h4>
                            <div class="text-nowrap">
                                <span class="badge bg-primary-subtle text-primary">+ $2.8k</span>
                                <span class="ms-1 text-muted font-size-13">Since last week</span>
                            </div>
                        </div>
                        <div class="flex-shrink-0 text-end">
                            <i class="fab fa-first-order fa-2x text-primary"></i>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-h-100 rounded-4">
                <!-- card body -->
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <span
                                class="text-muted mb-3 lh-1 d-block text-truncate">{{ __('messages.product_price') }}</span>
                            <h4 class="mb-3">
                                <span class="counter-value" data-target="{{ $client_info->price }}">0</span> UZS
                            </h4>
                            <div class="text-nowrap">
                                <span class="badge bg-warning-subtle text-warning">+5.32%</span>
                                <span class="ms-1 text-muted font-size-13">Since last week</span>
                            </div>
                        </div>
                        <div class="flex-shrink-0 text-end">
                            <i class="fas fa-sort-amount-down fa-2x text-warning"></i>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div>

    <div class="row justify-content-center animate__animated animate__heartBeat">
        <div class="col-4">
            <div class="card card-h-100 rounded-4">
                <!-- card body -->
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h5 class="text-muted mb-3 lh-1 d-block text-center text-truncate">{{ $client_info->fullname }}
                            </h5>
                            <h4 class="mb-3 text-center">
                                <i class="fas fa-check-circle text-success"></i>
                                <span>{{ __('messages.order_delivery_confirmated_successfully') }}</span>
                            </h4>
                            <div class="row text-nowrap text-center">
                                <div class="col">
                                    <span class="ms-1 text-muted font-size-13">{{ __('messages.order_number') }}:</span>
                                    <span class="badge bg-danger-subtle text-danger">{{ $order }}</span>
                                </div>
                                <div class="col">
                                    <span class="ms-1 text-muted font-size-13">{{ __('messages.order_date') }}:</span>
                                    <span class="badge bg-primary-subtle text-primary">{{ now() }}</span>
                                </div>
                            </div>
                            <div class="text-center mt-3">
                                <a type="button" href="{{ route('orders') }}"
                                    class="btn btn-outline-primary btn-lg text-center rounded-5 waves-effect waves-light">
                                    <i class="fas fa-reply me-2"></i>{{ __('messages.return_to_list') }} </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

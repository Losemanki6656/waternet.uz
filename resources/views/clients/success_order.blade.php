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
                                <span class="counter-value" data-target="{{ $order->client->balance }}">0</span> UZS
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
                                <span class="counter-value" data-target="{{ $order->client->container }}">0</span>
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
                                <span class="counter-value" data-target="{{ $order->product_count }}">0</span>
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
                                <span class="counter-value" data-target="{{ $order->price }}">0</span> UZS
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

    <div class="row">
        <div class="col-lg-8 col-md-12">
            <form action="{{ route('success_order', ['id' => $order->id]) }}" method="post">
                @csrf
                <div class="card rounded-4">
                    <div class="card-header">
                        <h4>{{ __('messages.confirmation_of_product_delivery') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row clearfix">
                            <div class="col-lg-3 col-md-6">
                                <b>{{ __('messages.product') }}:</b>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" value="{{ $order->product->name }}"
                                        disabled>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="row">
                                    <div class="col">
                                        <div class="input-group mb-3">
                                            <b>{{ __('messages.sold_count') }}:</b>
                                            <div class="input-group mb-3">
                                                <input type="number" class="form-control" onchange="summa()"
                                                    id="product_count" name="product_count"
                                                    value="{{ $order->product_count }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="input-group mb-3">
                                            <b>{{ __('messages.price') }}:</b>
                                            <div class="input-group mb-3">
                                                <input type="number" class="form-control" onchange="summa()" id="price"
                                                    name="price" value="{{ $order->price }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-3 col-md-6">
                                <b>{{ __('messages.order_status') }}:</b>
                                <select class="form-select" name="order_status" id="order-stat">
                                    <option value="1">Yetqazildi</option>
                                    <option value="2">Olib ketildi</option>
                                    <option value="3">Bekor qilindi</option>
                                    <option value="4">Manzil topilmadi</option>
                                    <option value="5">Manzilda xech kim yo'q</option>
                                </select>
                            </div>

                        </div>
                        <div class="row clearfix">
                            @if ($order->container_status == 0)
                                <div class="col-lg-6 col-md-6">
                                    <div class="row">
                                        <div class="col">
                                            <b>{{ __('messages.returned_containers') }}:</b>
                                            <div class="input-group mb-3">
                                                <input type="number" class="form-control" name="container"
                                                    value="0">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <b>{{ __('messages.invalid_container') }}:</b>
                                            <div class="input-group mb-3">
                                                <input type="number" class="form-control" name="invalid_container_count"
                                                    value="0">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <input type="hidden" class="form-control" name="container" value="0">
                                <input type="hidden" class="form-control" name="invalid_container_count"
                                    value="0">
                            @endif
                            <div class="col-lg-6 col-md-6">
                                <div class="row">
                                    <div class="col">
                                        <b id="amount">{{ __('messages.given_amount') }}:
                                            {{ $order->price * $order->product_count }}</b>
                                        <div class="input-group mb-3">
                                            <input type="number" class="form-control" id="take_amount" name="amount"
                                                value="0">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <b>{{ __('messages.payment_type') }}:</b>
                                        <select class="form-control" name="payment" onchange="onsel()" id="tolov-usuli">
                                            <option value="1">Naqd</option>
                                            <option value="2">Plastik</option>
                                            <option value="3">Pul ko'chirish</option>
                                        </select>

                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <b>{{ __('messages.comment') }}:</b>
                                <div class="input-group mb-3">
                                    <textarea class="form-control" name="comment"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <button class="btn btn-success text-end btn-lg waves-effect waves-light" type="submit"
                                    style="margin-top: 23px"><i class="fa me-2 fa-save"></i>
                                    {{ __('messages.save') }}</button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function onsel() {
            if (document.getElementById("tolov-usuli").value == 3) {
                $("#take_amount").val(0);
                $("#take_amount").attr('readonly', true);

            } else {

                var x = document.getElementById("product_count").value;
                var y = document.getElementById("price").value;
                var z = x * y;
                $("#take_amount").val(0);
                $("#take_amount").attr('readonly', false);
            }
        }
    </script>>

    <script>
        function summa() {
            var x = document.getElementById("product_count").value;
            var y = document.getElementById("price").value;
            var z = x * y;
            document.getElementById("amount").innerHTML = "{{ __('messages.given_amount') }}:  " + z;
        }
    </script>
@endsection

@extends('layouts.v2_master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ $client->fullname }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('messages.home') }}</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('messages.Clients') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('messages.client_result') }}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-h-100  rounded-4">
                <!-- card body -->
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <span
                                class="text-muted mb-3 lh-1 d-block text-truncate">{{ __('messages.client_balance') }}</span>
                            <h4 class="mb-3">
                                <span class="counter-value" data-target="{{ $client->balance }}">0</span> UZS
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
            <div class="card card-h-100  rounded-4">
                <!-- card body -->
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <span
                                class="text-muted mb-3 lh-1 d-block text-truncate">{{ __('messages.debt_container') }}</span>
                            <h4 class="mb-3">
                                <span class="counter-value" data-target="{{ $client->container }}">0</span>
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
                                <span class="counter-value" data-target="{{ $soldproducts->count() }}">0</span>
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
                                class="text-muted mb-3 lh-1 d-block text-truncate">{{ __('messages.all_amounts') }}</span>
                            <h4 class="mb-3">
                                <span class="counter-value" data-target="{{ $summ }}">0</span> UZS
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
        <div class="col-lg-6 col-md-12">

            <div class="card rounded-4">
                <div class="card-header align-items-center d-flex p-3">
                    <h4 class="card-title mb-0 flex-grow-1">{{ __('messages.amount_receipts') }}</h4>
                </div>

                <div class="card-body px-0 pt-2">
                    <div class="table-responsive px-3" data-simplebar style="max-height: 250px;">
                        <table class="table align-middle table-nowrap table-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('messages.amount') }}</th>
                                    <th>{{ __('messages.payment_type') }}</th>
                                    <th>{{ __('messages.who_got_it') }} </th>
                                    <th>{{ __('messages.comment') }}</th>
                                    <th>{{ __('messages.go_it_time') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clientprices as $prices)
                                    <tr>
                                        <td style="width: 50px;">
                                            {{ $loop->index + 1 }}
                                        </td>

                                        <td>
                                            {{ $prices->amount }}
                                        </td>

                                        <td>
                                            @if ($prices->payment == 1)
                                                <span class="badge bg-primary fs-7">{{ __('messages.cash') }}</span>
                                            @elseif ($prices->payment == 2)
                                                <span class="badge bg-warning fs-7">{{ __('messages.card') }}</span>
                                            @else
                                                <span class="badge bg-success fs-7">{{ __('messages.transfer') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($clientprices->count() == $loop->index + 1)
                                                <button type="button"
                                                    class="btn btn-primary waves-effect waves-light btn-sm"
                                                    data-bs-toggle="modal" data-bs-target="#priceedit">
                                                    {{ $prices->user->name }}
                                                </button>
                                            @else
                                                {{ $prices->user->name }}
                                            @endif
                                        </td>
                                        <td>
                                            {{ $prices->comment }}
                                        </td>
                                        <td>
                                            {{ $prices->created_at->format('Y-m-d') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- end card body -->
            </div>
        </div>
        <div class="col-lg-6 col-md-12">
            <div class="card rounded-4">
                <div class="card-header align-items-center d-flex p-3">
                    <h4 class="card-title mb-0 flex-grow-1">{{ __('messages.returned_containers') }}
                    </h4>
                </div>

                <div class="card-body px-0 pt-2">
                    <div class="table-responsive px-3" data-simplebar style="max-height: 250px;">
                        <table class="table align-middle table-nowrap table-sm">
                            <thead>
                                <tr>
                                    <th>{{ __('messages.product') }}</th>
                                    <th>{{ __('messages.count') }}</th>
                                    <th>{{ __('messages.invalid') }}</th>
                                    <th>{{ __('messages.who_got_it') }}</th>
                                    <th>{{ __('messages.comment') }}</th>
                                    <th>{{ __('messages.go_it_time') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clientcontainer as $container)
                                    <tr>
                                        <td>{{ $container->product->name }}</td>
                                        <td>{{ $container->count }}</td>
                                        <td>{{ $container->invalid_count }}</td>
                                        <td>
                                            @if ($clientcontainer->count() == $loop->index + 1)
                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#container_edit"> {{ $container->user->name }}
                                                </button>
                                            @else
                                                {{ $container->user->name }}
                                            @endif
                                        </td>
                                        <td>{{ $container->comment }}</td>
                                        <td>{{ $container->created_at->format('Y-m-d') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- end card body -->
            </div>
        </div>
    </div>

    @if ($clientprices->count())
        <div id="priceedit" class="modal fade" tabindex="-1" z-index="999" aria-labelledby="myModalLabel"
            aria-hidden="true" data-bs-scroll="true">
            <div class="modal-dialog modal-dialog-centered modal-rounded">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">
                            {{ __('messages.amount_receipts') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('client_price_edit', ['id' => $prices->id]) }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="mb-0">{{ __('messages.payment_type') }}:</label>
                                <select class="form-control" name="payment" id="tolov-usuli">
                                    <option value="1">Naqd</option>
                                    <option value="2">Plastik</option>
                                    <option value="3">Pul ko'chirish</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="mb-0">{{ __('messages.amount') }}:</label>
                                <input class="form-control" type="input" name="amount" value="{{ $prices->amount }}"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="mb-0">{{ __('messages.comment') }}:</label>
                                <textarea class="form-control" name="comment" id="" rows="2" required>{{ $prices->comment }}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="{{ route('client_price_delete', ['id' => $prices->id]) }}"
                                class="btn btn-danger btn-lg waves-effect waves-light" type="button"> <i
                                    class="fa fa-trash me-2"></i>
                                {{ __('messages.delete') }}</a>
                            <button type="button" class="btn btn-secondary btn-lg waves-effect waves-light"
                                data-bs-dismiss="modal">
                                <i class="fas fa-reply me-2"></i>
                                {{ __('messages.cancel') }}</button>
                            <button class="btn btn-primary btn-lg waves-effect waves-light" type="submit"> <i
                                    class="fa fa-save me-2"></i>
                                {{ __('messages.save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    @if ($clientcontainer->count())
        <div id="container_edit" class="modal fade" tabindex="-1" z-index="999" aria-labelledby="myModalLabel"
            aria-hidden="true" data-bs-scroll="true">
            <div class="modal-dialog modal-dialog-centered modal-rounded">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">
                            {{ __('messages.returned_containers') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('client_container_edit', ['id' => $container->id]) }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="mb-0">{{ __('messages.product') }}:</label>
                                <select class="form-control" name="product_id" id="tolov-usuli" required>
                                    <option value="">Tanlanmadi</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">
                                            {{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="mb-0">{{ __('messages.returned_count') }}:</label>
                                <input class="form-control" type="number" name="count"
                                    value="{{ $container->count }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="mb-0">{{ __('messages.invalid_count') }}:</label>
                                <input class="form-control" type="number" name="invalid_count"
                                    value="{{ $container->invalid_count }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="mb-0">{{ __('messages.comment') }}:</label>
                                <textarea class="form-control" name="comment" id="" rows="2">{{ $container->comment }}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="{{ route('client_container_delete', ['id' => $container->id]) }}"
                                class="btn btn-danger btn-lg waves-effect waves-light" type="button"> <i
                                    class="fa fa-trash me-2"></i>
                                {{ __('messages.delete') }}</a>
                            <button type="button" class="btn btn-secondary btn-lg waves-effect waves-light"
                                data-bs-dismiss="modal">
                                <i class="fas fa-reply me-2"></i>
                                {{ __('messages.cancel') }}</button>
                            <button class="btn btn-primary btn-lg waves-effect waves-light" type="submit"> <i
                                    class="fa fa-save me-2"></i>
                                {{ __('messages.save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif



    <div class="card rounded-4">
        <div class="card-body px-0">
            <div class="table-responsive px-3" data-simplebar style="max-height: 250px;">
                <table class="table align-middle table-nowrap table-sm">
                    <thead>
                        <tr>
                            <th>{{ __('messages.product') }}</th>
                            <th>{{ __('messages.order_count') }}</th>
                            <th>{{ __('messages.price') }} </th>
                            <th>{{ __('messages.order_time') }}</th>
                            <th>{{ __('messages.received_count') }}</th>
                            <th>{{ __('messages.received_price') }}</th>
                            <th>{{ __('messages.returned_containers') }}</th>
                            <th>{{ __('messages.payment_type') }}</th>
                            <th>{{ __('messages.total_amount') }}</th>
                            <th>{{ __('messages.delevired_count') }}</th>
                            <th>{{ __('messages.delevired_time') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($soldproducts as $soldproduct)
                            @if ($soldproduct->order_status == 1 || $soldproduct->order_status == 2)
                                <tr>
                                    <td>{{ $soldproduct->product->name }}</td>
                                    <td>{{ $soldproduct->order_count }}</td>
                                    <td>{{ $soldproduct->order_price }}</td>
                                    <td>{{ $soldproduct->order_date }}</td>
                                    <td>{{ $soldproduct->count }}</td>
                                    <td>{{ $soldproduct->price }}</td>
                                    <td>{{ $soldproduct->container }}</td>
                                    <td>
                                        @if ($soldproduct->payment == 1)
                                            <span class="badge bg-primary fs-7">{{ __('messages.cash') }}</span>
                                        @elseif ($soldproduct->payment == 2)
                                            <span class="badge bg-warning fs-7">{{ __('messages.card') }}</span>
                                        @else
                                            <span class="badge bg-success fs-7">{{ __('messages.transfer') }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $soldproduct->amount }}</td>
                                    <td>{{ $soldproduct->comment }}</td>
                                    <td>{{ $soldproduct->created_at }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

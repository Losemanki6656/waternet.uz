@extends('layouts.v2_master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ __('messages.Orders') }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('messages.home') }}</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('messages.results') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('messages.Orders') }}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-sm-3 mb-2">
            <div class="card mb-0">
                <form action="{{ route('result_orders') }}" method="get" id="form">
                    <input type="hidden" name="date1" value="{{ request('date1') }}">
                    <input type="hidden" name="date2" value="{{ request('date2') }}">
                    <input type="hidden" name="id" value="{{ request('id') }}">
                    <select class="form-control" data-trigger name="product_id" id="product_id">
                        @foreach ($products as $product)
                            <option value={{ $product->id }} @if ($product->id == request('product_id')) selected @endif>
                                {{ $product->name }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>
        @push('scripts')
            <script>
                $('#product_id').change(function(e) {
                    $('#form').submit();
                });
            </script>
        @endpush
    </div>

    <div class="card rounded-4">
        <div class="card-header">
            <h5>{{ __('messages.orders_in_the_period') }}: <span class="text-primary">{{ request('date1') }}</span> --
                <span class="text-primary"> {{ request('date2') }} </span>; {{ __('messages.user') }} -
                <span class="text-primary">{{ $orders[0]->user->name ?? __('messages.user_not_found') }}</span>
            </h5>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm align-middle table-bordered table-nowrap">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center fw-bold" width="60">#</th>
                            <th class="text-center fw-bold">{{ __('messages.fullname') }}</th>
                            <th class="text-center fw-bold">{{ __('messages.phone') }}</th>
                            <th class="text-center fw-bold">{{ __('messages.product') }}</th>
                            <th class="text-center fw-bold">{{ __('messages.count') }}</th>
                            <th class="text-center fw-bold">{{ __('messages.price') }}</th>
                            <th class="text-center fw-bold">{{ __('messages.time') }}</th>
                            <th class="text-center fw-bold">{{ __('messages.comment') }} </th>
                            <th class="text-center fw-bold">{{ __('messages.user') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td class="text-center">{{ $orders->currentPage() * 10 - 10 + $loop->index + 1 }}</td>

                                <td class="text-center">{{ $order->client->fullname ?? __('messages.client_not_found') }}
                                </td>
                                <td class="text-center">{{ $order->client->phone ?? '' }}</td>
                                <td class="text-center">{{ $order->product->name ?? '' }}</td>
                                <td class="text-center">{{ $order->product_count }}</td>
                                <td class="text-center">{{ $order->price }}</td>
                                <td class="text-center">{{ $order->created_at }}</td>
                                <td class="text-center">{{ $order->comment }}</td>
                                <td class="text-center">{{ $order->user->name }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td class="text-center fw-bold" colspan="4">{{ __('messages.total') }}:</td>
                            <td class="text-center fw-bold">
                                {{ $total }}
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            @if ($orders->total() > 10)
                <div class="row justify-content-between">
                    <div class="col-md-2">
                        <label class="mx-2">
                        </label>
                    </div>
                    <div class="col-md-8 text-center">
                        <label class="mb-0 p-0">{{ $orders->onEachSide(1)->withQueryString() }}</label>
                    </div>
                    <div class="col-md-2 text-end">
                        <label class="me-2">
                        </label>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

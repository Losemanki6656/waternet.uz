@extends('layouts.v2_master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ __('messages.inflows_of_funds') }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('messages.home') }}</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('messages.results') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('messages.inflows_of_funds') }}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-sm-3 mb-2">
            <div class="card mb-0">
                <form action="{{ route('summresult') }}" method="get" id="form">
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
            <h5>{{ __('messages.given_products_in_the_period') }}: <span
                    class="text-primary">{{ request('date1') }}</span>
                --
                <span class="text-primary"> {{ request('date2') }} </span>; {{ __('messages.user') }} -
                <span class="text-primary">{{ $soldproducts[0]->user->name ?? __('messages.user_not_found') }}</span>
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm align-middle table-bordered table-nowrap">
                    <thead class="table-light">
                        <tr>
                            <th class="fw-bold text-center">#</th>
                            <th class="fw-bold text-center">{{ __('messages.client') }}</th>
                            <th class="fw-bold text-center">{{ __('messages.phone') }}</th>
                            <th class="fw-bold text-center">{{ __('messages.product') }}</th>
                            <th class="fw-bold text-center">{{ __('messages.order_count') }}</th>
                            <th class="fw-bold text-center">{{ __('messages.price') }} </th>
                            <th class="fw-bold text-center">{{ __('messages.order_time') }}</th>
                            <th class="fw-bold text-center">{{ __('messages.received_count') }}</th>
                            <th class="fw-bold text-center">{{ __('messages.received_price') }}</th>
                            <th class="fw-bold text-center">{{ __('messages.returned_container') }}</th>
                            <th class="fw-bold text-center">{{ __('messages.payment_type') }}</th>
                            <th class="fw-bold text-center">{{ __('messages.amount') }}</th>
                            <th class="fw-bold text-center">{{ __('messages.comment') }}</th>
                            <th class="fw-bold text-center">{{ __('messages.delivery_time') }}</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($soldproducts as $soldproduct)
                            <tr>
                                <td class="text-center">{{ $soldproducts->currentPage() * 10 - 10 + $loop->index + 1 }}
                                </td>
                                <td class="text-center">{{ $soldproduct->fullname }}</td>
                                <td class="text-center">{{ $soldproduct->phone }}</td>
                                <td class="text-center">{{ $soldproduct->product->name ?? '' }}</td>
                                <td class="text-center">{{ $soldproduct->order_count }}</td>
                                <td class="text-center">{{ $soldproduct->order_price }}</td>
                                <td class="text-center">{{ $soldproduct->order_date }}</td>
                                <td class="text-center">{{ $soldproduct->count }}</td>
                                <td class="text-center">{{ $soldproduct->price }}</td>
                                <td class="text-center">{{ $soldproduct->container }}</td>
                                <td class="text-center">
                                    @if ($soldproduct->payment == 1)
                                        <span class="badge bg-primary fs-7">{{ __('messages.cash') }}</span>
                                    @elseif ($soldproduct->payment == 2)
                                        <span class="badge bg-warning fs-7">{{ __('messages.card') }}</span>
                                    @else
                                        <span class="badge bg-success fs-7">{{ __('messages.transfer') }}</span>
                                    @endif
                                </td>
                                <td class="text-center">{{ $soldproduct->amount }}</td>
                                <td class="text-center">{{ $soldproduct->comment }}</td>
                                <td class="text-center">{{ $soldproduct->created_at }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="4" class="text-center fw-bold">{{ __('messages.total') }}</td>
                            <td class="text-center fw-bold">{{ $order_count_total }}</td>
{{--                            <td class="text-center fw-bold">{{ $order_price_total }}</td>--}}
                            <td class="text-center fw-bold"></td>
                            <td class="text-center"></td>
                            <td class="text-center fw-bold">{{ $count_total }}</td>
{{--                            <td class="text-center fw-bold">{{ $price_total }}</td>--}}
                            <td class="text-center fw-bold"></td>
                            <td class="text-center fw-bold">{{ $container_total }}</td>
                            <td class="text-center fw-bold"></td>
                            <td class="text-center fw-bold">{{ $amount_total }}</td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            @if ($soldproducts->total() > 10)
                <div class="row justify-content-between">
                    <div class="col-md-2">
                        <label class="mx-2">
                        </label>
                    </div>
                    <div class="col-md-8 text-center">
                        <label class="mb-0 p-0">{{ $soldproducts->onEachSide(1)->withQueryString() }}</label>
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

@section('scripts')
@endsection

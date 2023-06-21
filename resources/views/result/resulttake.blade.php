@extends('layouts.v2_master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ __('messages.given_product') }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('messages.home') }}</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('messages.results') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('messages.given_product') }}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="card rounded-4">
        <div class="card-header">
            <h5>{{ __('messages.given_products_in_the_period') }}: <span class="text-primary">{{ request('date1') }}</span>
                --
                <span class="text-primary"> {{ request('date2') }} </span>; {{ __('messages.user') }} -
                <span class="text-primary">{{ $takeproducts[0]->received->name ?? __('messages.user_not_found') }}</span>
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm align-middle table-bordered table-nowrap">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center fw-bold">#</th>
                            <th class="text-center fw-bold">{{ __('messages.received_product') }}</th>
                            <th class="text-center fw-bold">{{ __('messages.product') }}</th>
                            <th class="text-center fw-bold">{{ __('messages.count') }}</th>
                            <th class="text-center fw-bold">{{ __('messages.time') }}</th>
                            <th class="text-center fw-bold">{{ __('messages.gave_product') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($takeproducts as $takeproduct)
                            <tr>
                                <td class="text-center">{{ $takeproducts->currentPage() * 10 - 10 + $loop->index + 1 }}
                                </td>
                                <td class="text-center">
                                    {{ $takeproduct->received->name ?? __('messages.user_not_found') }}
                                </td>
                                <td class="text-center">
                                    {{ $takeproduct->product->name ?? __('messages.product_not_found') }}
                                </td>
                                <td class="text-center">
                                    {{ $takeproduct->product_count }}
                                </td>
                                <td class="text-center">{{ $takeproduct->created_at }}</td>

                                <td class="text-center">{{ $takeproduct->sent->name ?? __('messages.user_not_found') }}
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td class="text-center fw-bold" colspan="3">{{ __('messages.total') }}:</td>
                            <td class="text-center fw-bold">
                                {{ $total }}
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            @if ($takeproducts->total() > 10)
                <div class="row justify-content-between">
                    <div class="col-md-2">
                        <label class="mx-2">
                        </label>
                    </div>
                    <div class="col-md-8 text-center">
                        <label class="mb-0 p-0">{{ $takeproducts->onEachSide(1)->withQueryString() }}</label>
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

@push('scripts')
@endpush

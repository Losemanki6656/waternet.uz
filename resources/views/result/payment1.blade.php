@extends('layouts.v2_master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ __('messages.payment_cash') }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('messages.home') }}</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('messages.results') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('messages.payment_cash') }}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="card rounded-4">
        <div class="card-header">
            <h5>{{ __('messages.payment_cash_in_the_period') }}: <span class="text-primary">{{ request('date1') }}</span> --
                <span class="text-primary"> {{ request('date2') }} </span>; {{ __('messages.user') }} -
                <span class="text-primary">{{ $clientprices[0]->user->name ?? __('messages.user_not_found') }}</span>
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm align-middle table-bordered table-nowrap">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center fw-bold">#</th>
                            <th class="text-center fw-bold">{{ __('messages.who_gave') }}</th>
                            <th class="text-center fw-bold">{{ __('messages.count') }}</th>
                            <th class="text-center fw-bold">{{ __('messages.payment_type') }}</th>
                            <th class="text-center fw-bold">{{ __('messages.who_tok') }}</th>
                            <th class="text-center fw-bold">{{ __('messages.comment') }}</th>
                            <th class="text-center fw-bold">{{ __('messages.time') }}</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($clientprices as $prices)
                            <tr>
                                <td class="text-center">{{ $clientprices->currentPage() * 10 - 10 + $loop->index + 1 }}
                                </td>
                                <td class="text-center">{{ $prices->client->fullname ?? '' }}</td>
                                <td class="text-center">{{ $prices->amount }}</td>
                                <td class="text-center">
                                    <span class="badge bg-primary fs-7">{{ __('messages.cash') }}</span>
                                </td>
                                <td class="text-center">{{ $prices->user->name }}</td>
                                <td class="text-center">{{ $prices->comment }}</td>
                                <td class="text-center">{{ $prices->created_at->format('Y-m-d') }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="2" class="text-center fw-bold"> {{ __('messages.total') }}:</td>
                            <td class="text-center fw-bold">{{ $total }}</td>
                            <td class="text-center fw-bold"></td>
                            <td class="text-center fw-bold"></td>
                            <td class="text-center fw-bold"></td>
                            <td class="text-center fw-bold"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            @if ($clientprices->total() > 10)
                <div class="row justify-content-between">
                    <div class="col-md-2">
                        <label class="mx-2">
                        </label>
                    </div>
                    <div class="col-md-8 text-center">
                        <label class="mb-0 p-0">{{ $clientprices->onEachSide(1)->withQueryString() }}</label>
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

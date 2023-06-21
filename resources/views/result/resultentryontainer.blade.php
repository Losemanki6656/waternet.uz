@extends('layouts.v2_master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ __('messages.took_to_bak') }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('messages.home') }}</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('messages.results') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('messages.took_to_bak') }}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="card rounded-4">
        <div class="card-header">
            <h5>{{ __('messages.took_to_bak_in_the_period') }}: <span class="text-primary">{{ request('date1') }}</span> --
                <span class="text-primary"> {{ request('date2') }} </span>; {{ __('messages.user') }} -
                <span class="text-primary">{{ $entrycontainer[0]->user->name ?? __('messages.user_not_found') }}</span>
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm align-middle table-bordered table-nowrap">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center fw-bold">#</th>
                            <th class="text-center fw-bold">{{ __('messages.product') }}</th>
                            <th class="text-center fw-bold">{{ __('messages.fwom_whom') }}</th>
                            <th class="text-center fw-bold">{{ __('messages.count') }}</th>
                            <th class="text-center fw-bold">{{ __('messages.invalid') }}</th>
                            <th class="text-center fw-bold">{{ __('messages.accepted') }}</th>
                            <th class="text-center fw-bold">{{ __('messages.when') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($entrycontainer as $entrycon)
                            <tr>
                                <td class="text-center">{{ $entrycontainer->currentPage() * 10 - 10 + $loop->index + 1 }}
                                </td>
                                <td class="text-center">
                                    {{ $entrycon->product->name ?? '' }}
                                </td>
                                <td class="text-center">
                                    {{ $entrycon->client->fullname ?? '' }}
                                </td>
                                <td class="text-center">
                                    {{ $entrycon->container }}
                                </td>
                                <td class="text-center">
                                    {{ $entrycon->invalid_container_count }}
                                </td>
                                <td class="text-center">{{ $entrycon->user->name }}</td>
                                <td class="text-center">{{ $entrycon->created_at }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td class="text-center fw-bold" colspan="3">
                                {{ __('messages.total') }}:
                            </td>
                            <td class="text-center fw-bold">
                                {{ $summ_con }}
                            </td>
                            <td class="text-center fw-bold">
                                {{ $summ_con_in }}
                            </td>
                            <td class="text-center fw-bold"></td>
                            <td class="text-center fw-bold"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            @if ($entrycontainer->total() > 10)
                <div class="row justify-content-between">
                    <div class="col-md-2">
                        <label class="mx-2">
                        </label>
                    </div>
                    <div class="col-md-8 text-center">
                        <label class="mb-0 p-0">{{ $entrycontainer->onEachSide(1)->withQueryString() }}</label>
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

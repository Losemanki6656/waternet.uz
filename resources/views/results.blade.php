@extends('layouts.v2_master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ __('messages.results') }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('messages.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('messages.results') }}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    {{-- <div class="body taskboard">
        <div class="dd" data-plugin="nestable">
            <ol class="dd-list">
                <div class="dd-handle">
                    <ul class="list-unstyled team-info">
                        <li><a href="{{ route('results') }}" class="btn btn-primary mr-3"><i class="fa fa-calendar"></i>
                                Xisobot</a></li>
                        <li><button class="btn btn-warning mr-3"><i class="fa fa-money"></i> Tushum</button></li>
                        <li><button class="btn btn-dark mr-3"><i class="fa fa-users"></i> Xodimlar</button></li>
                        <li><a href="{{ route('dolgs') }}" class="btn btn-danger mr-3"><i class="fa fa-info-circle"></i>
                                Qarzdorlar</a></li>
                    </ul>
                </div>
                </li>
            </ol>
        </div>
    </div> --}}

    <div class="card rounded-4">
        <div class="card-header">
            <form action="{{ route('results') }}">
                <div class="row">
                    <div class="col-lg-2 col-md-6">
                        <input type="date" value="{{ request('date1', now()->format('Y-m-d')) }}" id="date1"
                            name="date1" class="form-control">
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <input type="date" value="{{ request('date2', now()->format('Y-m-d')) }}" id="date2"
                            name="date2" class="form-control">
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <button type="submit" class="btn btn-soft-primary waves-effect waves-light"><i
                                class="fa fa-filter me-2"></i> {{ __('messages.filtr') }}</button>
                    </div>
                    <div class="col-lg-6 col-md-6 text-end">
                        <a type="button" onclick="ExportToExcel()" class="btn btn-soft-success waves-effect waves-light">
                            <i class="far fa-file-excel me-2"></i>
                            {{ __('messages.export') }}</a>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle table-bordered table-nowrap" id="table">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center fw-bold">{{ __('messages.fullname') }}</th>
                            <th class="text-center fw-bold">{{ __('messages.role') }}</th>
                            <th class="text-center fw-bold">{{ __('messages.given_order') }}</th>
                            <th class="text-center fw-bold">{{ __('messages.given_product') }}</th>
                            <th class="text-center fw-bold">{{ __('messages.sold_product') }}</th>
                            <th class="text-center fw-bold">{{ __('messages.amount') }}</th>
                            <th class="text-center fw-bold">{{ __('messages.given_container') }}</th>
                            <th class="text-center fw-bold">{{ __('messages.returned_container') }}</th>
                            <th class="text-center fw-bold">{{ __('messages.cash') }}</th>
                            <th class="text-center fw-bold">{{ __('messages.card') }}</th>
                            <th class="text-center fw-bold">{{ __('messages.transfer') }}</th>
                            <th class="text-center fw-bold">{{ __('messages.debt') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $user)
                            <tr>
                                <td class="text-center fw-bold">
                                    {{ $user->name }}
                                </td>
                                <td class="text-center fw-bold">
                                    {{ $user->roleName() }}
                                </td>
                                <td class="text-center">
                                    <a
                                        href="{{ route('result_orders', ['date1' => request('date1'), 'date2' => request('date2'), 'id' => $user->id]) }}">
                                        {{ $order[$user->id] }}</a>
                                </td>
                                <td class="text-center">
                                    <a
                                        href="{{ route('result_take', ['date1' => request('date1'), 'date2' => request('date2'), 'id' => $user->id]) }}">{{ $takeproduct[$user->id] }}</a>
                                </td>
                                <td class="text-center">
                                    <a
                                        href="{{ route('resultsold', ['date1' => request('date1'), 'date2' => request('date2'), 'id' => $user->id]) }}">{{ $soldproducts[$user->id] }}</a>
                                </td>
                                <td class="text-center">
                                    <a
                                        href="{{ route('summresult', ['date1' => request('date1'), 'date2' => request('date2'), 'id' => $user->id]) }}">{{ $soldsumm[$user->id] }}</a>
                                </td>
                                <td class="text-center">
                                    <a
                                        href="{{ route('resultentrycontainer', ['date1' => request('date1'), 'date2' => request('date2'), 'id' => $user->id]) }}">{{ $entrycon[$user->id] }}</a>
                                </td>
                                <td class="text-center">
                                    {{ $takecon[$user->id] }}
                                </td>
                                <td class="text-center">
                                    <a
                                        href="{{ route('payment1', ['date1' => request('date1'), 'date2' => request('date2'), 'id' => $user->id]) }}">{{ $payment1[$user->id] }}</a>
                                </td>
                                <td class="text-center">
                                    <a
                                        href="{{ route('payment2', ['date1' => request('date1'), 'date2' => request('date2'), 'id' => $user->id]) }}">{{ $payment2[$user->id] }}</a>
                                </td>
                                <td class="text-center">
                                    <a
                                        href="{{ route('payment3', ['date1' => request('date1'), 'date2' => request('date2'), 'id' => $user->id]) }}">{{ $payment3[$user->id] }}</a>
                                </td>
                                <td class="text-center">
                                    <a
                                        href="{{ route('dolgresult', ['date1' => request('date1'), 'date2' => request('date2'), 'id' => $user->id]) }}">{{ $amount[$user->id] }}</a>
                                </td>
                            </tr>
                        @endforeach
                        <td colspan="2" class="text-center fw-bold"> {{ __('messages.total') }}:</td>
                        <td class="text-center fw-bold">{{ $summorder }}</td>
                        <td class="text-center fw-bold">{{ $summtakeproduct }}</td>
                        <td class="text-center fw-bold">{{ $summsoldproducts }}</td>
                        <td class="text-center fw-bold">{{ $summsoldsumm }}</td>
                        <td class="text-center fw-bold">{{ $summentrycon }}</td>
                        <td class="text-center fw-bold">{{ $takesumm }}</td>
                        <td class="text-center fw-bold">{{ $summpayment1 }}</td>
                        <td class="text-center fw-bold">{{ $summpayment2 }}</td>
                        <td class="text-center fw-bold">{{ $summpayment3 }}</td>
                        <td class="text-center fw-bold">{{ $dolgsumm }}</td>
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content mt-3">
                <ul class="pagination mb-0">
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function ExportToExcel() {

            let date1 = $('#date1').val();
            let date2 = $('#date2').val();
            let url = '{{ route('export_results') }}';
            window.location.href = `${url}?date1=${date1}&date2=${date2}`;
        }
    </script>
@endsection

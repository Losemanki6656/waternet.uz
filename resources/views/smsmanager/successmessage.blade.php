@extends('layouts.v2_master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ __('messages.sent_messages') }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('messages.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('messages.sent_messages') }}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="row mb-2 animate__animated animate__fadeIn">
        <div class="col-sm-3 mb-2">
            <input type="search" class="form-control" name="search" id="search" value="{{ request('search') }}"
                placeholder="{{ __('messages.search') }}">
        </div>
        <div class="col-sm-3 mb-2">
            <input type="date" name="data" id="data" value="{{ request('data') }}" class="form-control">
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive animate__animated animate__fadeIn">
                <table class="table table-sm align-middle table-bordered table-nowrap">
                    <thead class="table-light">
                        <tr>
                            <th class="align-middle text-center">#</th>
                            <th class="align-middle text-center">{{ __('messages.to_whom') }}</th>
                            <th class="align-middle text-center">{{ __('messages.type') }}</th>
                            <th class="align-middle text-center">{{ __('messages.text') }}</th>
                            <th class="align-middle text-center">{{ __('messages.from_whom') }}</th>
                            <th class="align-middle text-center">{{ __('messages.when') }}</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($smsmanagers as $smsmanager)
                            <tr>
                                <td class="text-center">{{ $smsmanagers->currentPage() * 10 - 10 + $loop->index + 1 }}</td>
                                <td class="text-center"><a
                                        href="{{ route('soldproducts', ['id' => $smsmanager->client->id]) }}"
                                        class="fw-bold text-dark">
                                        {{ $smsmanager->client->fullname ?? '' }} </a></td>
                                <td class="text-center">
                                    @if ($smsmanager->type == 0)
                                        <span class="badge bg-primary fs-7">{{ __('messages.sms') }}</span>
                                    @else
                                        <span class="badge bg-success fs-7">{{ __('messages.telegram') }}</span>
                                    @endif
                                </td>
                                <td class="text-center">{{ $smsmanager->sms_text }}</td>
                                <td class="text-center">{{ $smsmanager->user->name ?? '' }}</td>
                                <td class="text-center">{{ $smsmanager->created_at->format('Y-m-d') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($smsmanagers->total() > 10)
                <div class="row justify-content-between">
                    <div class="col-md-2">
                        <label>
                            <select class="form-select mx-3" name="paginate_select" id="paginate_select"
                                style="max-width: 100px">
                                <option value="10" @if ($smsmanagers->perPage() == 10) selected @endif>10
                                </option>
                                <option value="30" @if ($smsmanagers->perPage() == 30) selected @endif>30
                                </option>
                                <option value="50" @if ($smsmanagers->perPage() == 50) selected @endif>50
                                </option>
                                <option value="100" @if ($smsmanagers->perPage() == 100) selected @endif>100
                                </option>
                            </select>
                        </label>
                    </div>
                    <div class="col-md-10 text-end">
                        <label class="me-3">{{ $smsmanagers->onEachSide(1)->withQueryString() }}</label>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('#search').keyup(function(e) {
            if (e.keyCode == 13) {
                myFilter();
            }
        });

        $('#data').change(function(e) {
            myFilter();
        });

        $('#paginate_select').change(function(e) {
            myFilter();
        });

        function myFilter() {
            let search = $('#search').val();
            let data = $('#data').val();
            let paginate_select = $('#paginate_select').val() ?? 10;

            let url = '{{ route('success_message') }}';
            window.location.href =
                `${url}?search=${search}&per_page=${paginate_select}&data=${data}`;
        }
    </script>
@endpush

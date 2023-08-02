@extends('layouts.v2_master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ __('messages.rate_users') }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('messages.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('messages.rate_users') }}</li>
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

    <div class="row">

        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-h-100  rounded-4">
                <!-- card body -->
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <span class="text-muted mb-3 lh-1 d-block text-truncate">{{ __('messages.evaluations') }}</span>
                            <h4 class="mb-3">
                                <span class="counter-value" data-target="{{ $users->total() }}">0</span>
                            </h4>
                            <div class="text-nowrap">
                                <span class="badge bg-success-subtle text-success">{{ $users->total() }} ta</span>
                                <span class="ms-1 text-muted font-size-13">{{ __('messages.all_time') }}</span>
                            </div>
                        </div>

                        <div class="flex-shrink-0 text-end">
                            <i class="fas fa-2x fa-hashtag text-success"></i>
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
                            <span class="text-muted mb-3 lh-1 d-block text-truncate">{{ __('messages.best_user') }}</span>
                            <h4 class="mb-3">
                                <span class="counter-value" data-target="{{ round($rateMax->rateMax ?? 0) }}">0</span>
                            </h4>
                            <div class="text-nowrap">
                                <span class="badge bg-danger-subtle text-danger">{{ round($rateMax->rateMax ?? 0) }}
                                    ball</span>
                                <span class="ms-1 text-muted font-size-13">{{ $rateMax->user->name ?? '' }}</span>
                            </div>
                        </div>
                        <div class="flex-shrink-0 text-end">
                            <i class="fas fa-grin-stars fa-2x text-primary"></i>
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
                            <span class="text-muted mb-3 lh-1 d-block text-truncate">{{ __('messages.worst_user') }}</span>
                            <h4 class="mb-3">
                                <span class="counter-value" data-target="{{ round($rateMin->rateMax ?? 0) }}">0</span>
                            </h4>
                            <div class="text-nowrap">
                                <span class="badge bg-primary-subtle text-primary">{{ round($rateMin->rateMax ?? 0) }}
                                    ball</span>
                                <span class="ms-1 text-muted font-size-13">{{ $rateMin->user->name ?? '' }}</span>
                            </div>
                        </div>
                        <div class="flex-shrink-0 text-end">
                            <i class="fas fa-sad-tear fa-2x text-danger"></i>
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
                                class="text-muted mb-3 lh-1 d-block text-truncate">{{ __('messages.most_rated_client') }}</span>
                            <h4 class="mb-3">
                                <span class="counter-value" data-target="{{ $clientMax->total ?? 0 }}">0</span>
                            </h4>
                            <div class="text-nowrap">
                                <span class="badge bg-warning-subtle text-warning">{{ $clientMax->total ?? 0 }} ta</span>
                                <span class="ms-1 text-muted font-size-13">{{ $clientMax->client->fullname ?? 0 }}</span>
                            </div>
                        </div>
                        <div class="flex-shrink-0 text-end">
                            <i class="fas fa-sort-amount-up fa-2x text-warning"></i>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive animate__animated animate__fadeIn">
                <table class="table table-sm align-middle table-bordered table-nowrap">
                    <thead class="table-light">
                        <tr>
                            <th class="align-middle text-center">#</th>
                            <th class="align-middle text-center">{{ __('messages.user') }}</th>
                            <th class="align-middle text-center">{{ __('messages.client') }}</th>
                            <th class="align-middle text-center">{{ __('messages.rate') }}</th>
                            <th class="align-middle text-center">{{ __('messages.comment') }}</th>
                            <th class="align-middle text-center">{{ __('messages.date') }}</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($users as $user)
                            <tr>
                                <td class="text-center">{{ $users->currentPage() * 10 - 10 + $loop->index + 1 }}</td>
                                <td class="text-center">{{ $user->user->name ?? '' }}</td>
                                <td class="text-center"><a href="{{ route('soldproducts', ['id' => $user->client->id]) }}"
                                        class="fw-bold text-dark">
                                        {{ $user->client->fullname ?? '' }} </a></td>
                                <td class="text-center">
                                    @if ($user->rate >= 7)
                                        <span class="badge bg-primary fs-7">{{ $user->rate }}</span>
                                    @elseif ($user->rate < 7 && $user->rate >= 5)
                                        <span class="badge bg-warning fs-7">{{ $user->rate }}</span>
                                    @else
                                        <span class="badge bg-danger fs-7">{{ $user->rate }}</span>
                                    @endif
                                </td>
                                <td class="text-center">{{ $user->comment }}</td>
                                <td class="text-center">{{ $user->created_at->format('Y-m-d') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($users->total() > 10)
                <div class="row justify-content-between">
                    <div class="col-md-2">
                        <label>
                            <select class="form-select mx-3" name="paginate_select" id="paginate_select"
                                style="max-width: 100px">
                                <option value="10" @if ($users->perPage() == 10) selected @endif>10
                                </option>
                                <option value="30" @if ($users->perPage() == 30) selected @endif>30
                                </option>
                                <option value="50" @if ($users->perPage() == 50) selected @endif>50
                                </option>
                                <option value="100" @if ($users->perPage() == 100) selected @endif>100
                                </option>
                            </select>
                        </label>
                    </div>
                    <div class="col-md-10 text-end">
                        <label class="me-3">{{ $users->onEachSide(1)->withQueryString() }}</label>
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

            let url = '{{ route('rate_users') }}';
            window.location.href =
                `${url}?search=${search}&per_page=${paginate_select}&data=${data}`;
        }
    </script>
@endpush

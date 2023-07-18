@extends('layouts.v2_master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ __('messages.members') }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('messages.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('messages.messages') }}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="row mb-2 animate__animated animate__fadeIn">
        <div class="col-sm-3 mb-2">
            <div class="card mb-0">
                <select class="form-control" data-trigger name="city_id" id="city_id">
                    <option value="">{{ __('messages.select_region') }}</option>
                    @foreach ($sities as $sity)
                        <option value={{ $sity->id }} @if ($sity->id == request('city_id')) selected @endif>
                            {{ $sity->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-3 mb-2">
            <div class="card mb-0">
                <select class="form-control" data-trigger name="area_id" id="area_id">
                    <option value="">{{ __('messages.select_city') }}</option>
                    @foreach ($areas as $area)
                        <option value={{ $area->id }} @if ($area->id == request('area_id')) selected @endif>
                            {{ $area->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-3 mb-2">
            <input type="search" class="form-control" name="search" id="search" value="{{ request('search') }}"
                placeholder="{{ __('messages.search') }}">
        </div>
        <div class="col-sm-2 mb-2">
            <button class="btn btn-primary rounded-3 waves-effect waves-light" data-bs-toggle="offcanvas"
                data-bs-target="#send" aria-controls="offcanvasBottom">
                <i class="fab fa-telegram-plane me-2"></i>
                <span> {{ __('messages.send_message') }}</span></button>
        </div>
    </div>

    <div class="offcanvas offcanvas-bottom" tabindex="-1" id="send" aria-labelledby="offcanvasBottomLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasBottomLabel"><i class="fab fa-telegram-plane me-2"></i>{{ __('messages.send_message') }}</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form action="{{ route('members') }}" method="get">
                @csrf
                <div class="row mb-3">
                    <div class="col-8">
                        <label class="mb-0">{{ __('messages.message') }}:</label>
                        <textarea name="" class="form-control"></textarea>
                    </div>
                    <div class="col-4">
                        <button type="button" class="btn btn-secondary btn-lg waves-effect waves-light"
                            data-bs-dismiss="offcanvas" style="margin-top: 20px"> <i class="fas fa-reply me-2"></i>
                            {{ __('messages.cancel') }}</button>
                        <button class="btn btn-primary btn-lg waves-effect waves-light" type="submit"
                            style="margin-top: 20px"> <i class="fab fa-telegram-plane me-2"></i>
                            {{ __('messages.send') }}</button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive animate__animated animate__fadeIn">
                <table class="table table-sm align-middle table-bordered table-nowrap table-check">
                    <thead class="table-light">
                        <tr>
                            <th class="align-middle text-center">#</th>
                            <th class="align-middle text-center"> {{ __('messages.fullname') }}</th>
                            <th class="align-middle text-center"> {{ __('messages.phone') }}</th>
                            <th class="align-middle text-center"> {{ __('messages.address') }}</th>
                            <th class="align-middle text-center"> {{ __('messages.balance') }}</th>
                            <th class="align-middle text-center"> {{ __('messages.container') }}</th>
                            <th class="align-middle text-center"> {{ __('messages.telegram') }}</th>
                            <th class="align-middle text-center">
                                <div class="form-check font-size-16 text-center">
                                    <input class="form-check-input" type="checkbox" id="checkAll" name="checkbox"
                                        style="float: none">
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <form id="sendsms" action="{{ route('send_sms') }}" method="post">
                            @csrf
                            @foreach ($clients as $client)
                                <tr>
                                    <td class="text-center">{{ $clients->currentPage() * 10 - 10 + $loop->index + 1 }}
                                    </td>
                                    <td class="text-center">{{ $client->client->fullname }}</td>
                                    <td class="text-center">{{ $client->phone }}</td>
                                    <td class="text-center">{{ $client->client->city->name }},
                                        {{ $client->client->area->name }}</td>
                                    <td class="text-center">{{ $client->client->balance }}</td>
                                    <td class="text-center">{{ $client->client->container }}</td>
                                    <td width="200" class="text-center">
                                        <button type="button"
                                            class="btn btn-soft-primary btn-sm waves-effect waves-light"><i
                                                class="fab fa-telegram-plane me-2"></i>{{ $client->chat_id }}</button>
                                    </td>

                                    <td class="text-center"style="width: 50px;">
                                        <div class="form-check font-size-16 text-center">
                                            <input class="form-check-input" type="checkbox" style="float: none"
                                                form="order_all_form" name="checkbox[{{ $client->id }}]">
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </form>
                    </tbody>
                </table>
            </div>
            @if ($clients->total() > 10)
                <div class="row justify-content-between">
                    <div class="col-md-2">
                        <label>
                            <select class="form-select mx-3" name="paginate_select" id="paginate_select"
                                style="max-width: 100px">
                                <option value="10" @if ($clients->perPage() == 10) selected @endif>10
                                </option>
                                <option value="30" @if ($clients->perPage() == 30) selected @endif>30
                                </option>
                                <option value="50" @if ($clients->perPage() == 50) selected @endif>50
                                </option>
                                <option value="100" @if ($clients->perPage() == 100) selected @endif>100
                                </option>
                            </select>
                        </label>
                    </div>
                    <div class="col-md-10 text-end">
                        <label class="me-3">{{ $clients->onEachSide(1)->withQueryString() }}</label>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('#search').keyup(function(e) {
            if (e.keyCode == 13) {
                myFilter();
            }
        });

        $('#city_id').change(function(e) {
            let search = $('#search').val();
            let city_id = $('#city_id').val();
            let paginate_select = $('#paginate_select').val() ?? 10;
            let page = $('#page').val() ?? 1;

            let url = '{{ route('members') }}';
            window.location.href =
                `${url}?search=${search}&city_id=${city_id}&paginate_select=${paginate_select}&page=${page}`;
        });

        $('#area_id').change(function(e) {
            myFilter();
        });

        $('#paginate_select').change(function(e) {
            myFilter();
        });

        function myFilter() {
            let search = $('#search').val();
            let city_id = $('#city_id').val();
            let area_id = $('#area_id').val() ?? null;
            let paginate_select = $('#paginate_select').val() ?? 10;
            let page = $('#page').val() ?? 1;

            let url = '{{ route('members') }}';
            window.location.href =
                `${url}?search=${search}&city_id=${city_id}&area_id=${area_id}&paginate_select=${paginate_select}&page=${page}`;
        }
    </script>
@endsection

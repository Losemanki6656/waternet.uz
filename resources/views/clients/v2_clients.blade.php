@extends('layouts.v2_master')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ __('messages.Clients') }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('messages.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('messages.Clients') }}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="row mb-2  animate__animated animate__fadeIn">
        <div class="col-sm-8 mb-2">
            <div class="text-sm-start">
                <div class="d-flex flex-wrap gap-2">
                    <button type="button" class="btn btn-primary rounded-3 waves-effect waves-light"
                        data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                        <i class="fas fa-plus-circle me-2"></i>{{ __('messages.add_client') }}
                    </button>
                    <button type="button" class="btn btn-danger rounded-3 waves-effect waves-light"
                        data-bs-target="#orderAll" data-bs-toggle="modal">
                        <i class="fab fa-first-order"></i> {{ __('messages.get_order') }}
                    </button>
                    <div class="dropdown">
                        <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-bs-toggle="dropdown" aria-expanded="false"> <i class="fa fa-filter"></i>
                            {{ __('messages.filtr') }} <i class="mdi mdi-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" onclick="orderBy('balance')">{{ __('messages.by_balance') }}</a>
                            <a class="dropdown-item" onclick="orderBy('container')">{{ __('messages.by_container') }}</a>
                            <a class="dropdown-item" onclick="orderBy('activated_at')">{{ __('messages.by_active') }}</a>
                        </div>
                        <input type="hidden" value="{{ request('filtr', 'activated_at') }}" name="filtr" id="filtr">
                    </div>

                    <label class="col-form-label"> {{ __('messages.by_filter') }} <span
                            class="text-primary fw-bold">{{ __('messages.' . request('filtr', 'active')) }};</span></label>

                    <label class="col-form-label"> {{ __('messages.client_count') }} - <span
                            class="counter-value text-primary fw-bold"
                            data-target="{{ $clients->total() }}">0</span></label>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="text-sm-end">
                <button type="button" onclick="ExportToExcel()" class="btn btn-success rounded-3 waves-effect waves-light">
                    <i class="fas fa-cloud-download-alt"></i> {{ __('messages.export') }}
                </button>
            </div>
        </div>

    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasRightLabel">{{ __('messages.add_new_customer') }}</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form class="needs-validation" novalidate action="{{ route('add_client') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label class="mb-0"> {{ __('messages.fullname') }} </label>
                    <input type="text" class="form-control" name="fullname" placeholder="{{ __('messages.fullname') }}"
                        required>
                </div>
                <div class="mb-3">
                    <label class="mb-0">
                        {{ __('messages.select_region') }}:</label>
                    <select class="form-select" name="city_id" id="create_region_id" required>
                        <option value="">--{{ __('messages.select_region') }}-- </option>
                        @foreach ($sities as $city)
                            <option value="{{ $city->id }}">
                                {{ $city->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="mb-0">
                        {{ __('messages.select_city') }}:</label>
                    <select class="form-select" name="area_id" id="create_area_id" required>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="mb-0">{{ __('messages.street') }}:</label>
                    <input class="form-control" type="text" name="street">
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label class="mb-0">{{ __('messages.home_number') }}:</label>
                        <input class="form-control" type="text" name="home_number">
                    </div>
                    <div class="col">
                        <label class="mb-0">{{ __('messages.apartment_number') }}:</label>
                        <input class="form-control" type="text" name="apartment_number">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label class="mb-0">{{ __('messages.entrance') }}:</label>
                        <input class="form-control" type="text" name="entrance">
                    </div>
                    <div class="col">
                        <label class="mb-0">{{ __('messages.floor') }}:</label>
                        <input class="form-control" type="text" name="floor">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label class="mb-0">
                            {{ __('messages.phone') }}:</label>
                        <input type="text" class="form-control" name="phone1" id="create_phone"
                            onchange="login_pass()" required>
                    </div>
                    <div class="col">
                        <label class="mb-0">{{ __('messages.phone2') }}:</label>
                        <input class="form-control" type="text" name="phone2" id="create_phone2">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <label class="mb-0">
                            {{ __('messages.login') }}:</label>
                        <input type="text" class="form-control" name="login" id="create_login" required>
                    </div>
                    <div class="col">
                        <label class="mb-0">{{ __('messages.password') }}:</label>
                        <input class="form-control" type="text" name="password" id="create_password" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="mb-0">{{ __('messages.comment') }}:</label>
                    <textarea name="address" class="form-control"></textarea>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <div class="d-grid">
                            <button type="button" class="btn btn-secondary btn-lg waves-effect waves-light"
                                data-bs-dismiss="offcanvas"><i class="fas fa-reply me-2"></i>
                                {{ __('messages.cancel') }}</button>
                        </div>
                    </div>
                    <div class="col">
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg waves-effect waves-light"><i
                                    class="fas fa-save me-2"></i> {{ __('messages.save') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div id="orderAll" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
        data-bs-scroll="true">
        <div class="modal-dialog modal-dialog-centered modal-rounded">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">{{ __('messages.take_order_selected') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('add_order_check') }}" method="post" id="order_all_form">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>{{ __('messages.product_name') }}:</label>
                            <select class="form-select" id="prod_sel_all" name="product_id" onchange="onselall()"
                                required>
                                @foreach ($products as $product)
                                    <option data-amount="{{ $product->price }}" value={{ $product->id }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label>{{ __('messages.amount') }}:</label>
                                <input class="form-control" type="text" id="sena_product_order_all" name="sena"
                                    readonly @if ($products->count()) value="{{ $products[0]->price }}" @endif
                                    required>
                            </div>
                            <div class="col">
                                <label>{{ __('messages.count') }}:</label>
                                <input class="form-control" type="number" value="1" name="count" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>{{ __('messages.comment') }}:</label>
                            <textarea class="form-control" name="izoh" id="" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-lg waves-effect waves-light"
                            data-bs-dismiss="modal"> <i class="fas fa-reply me-2"></i>
                            {{ __('messages.cancel') }}</button>
                        <button class="btn btn-success btn-lg waves-effect waves-light" type="submit"> <i
                                class="fa fa-save me-2"></i>
                            {{ __('messages.save') }}</button>
                    </div>
                </form>
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
        <div class="col-sm-4">
            <div class="text-sm-end">
            </div>
        </div>
        <div class="col-sm-2 mb-2">
            <div class="text-sm-end">
                <input type="search" class="form-control" name="search" id="search"
                    value="{{ request('search') }}" placeholder="{{ __('messages.search') }}">
            </div>
        </div>
    </div>

    <div class="row animate__animated animate__fadeIn">
        <div class="col-12">
            <div class="card rounded-3">
                <div class="card-body p-0">
                    <div id="filter-table">
                        @include('include_tables.clients_table')
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
                                <div class="col-md-8 text-center">
                                    <label class="mb-0 p-0">{{ $clients->onEachSide(1)->withQueryString() }}</label>
                                </div>
                                <div class="col-md-2 text-end">
                                    <label>
                                        <input type="number" class="form-control me-3" style="width: 100px"
                                            name="page" id="page" placeholder="{{ __('messages.page') }}"
                                            value="{{ $clients->currentPage() }}">
                                    </label>
                                </div>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            var L = window.L;
            var map = L.map('map', {
                // scrollWheelZoom: false,
                tap: false
            });
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

            marker = L.marker([41.2942336, 69.2518912]).addTo(map)
                .bindPopup('asdasd')
                .openPopup();

            map.setView(new L.LatLng(41.2942336, 69.2518912), 7);

            window.map = map;
        });
    </script>
    <script>
        function onselall() {
            const $this = $("#prod_sel_all");
            const dataVal = $this.find(':selected').data('amount');
            $('#sena_product_order_all').val(dataVal);
        }
    </script>
    <script>
        function login_pass() {
            var x = document.getElementById("create_phone").value;

            var newstr = x.replace('(', '');
            newstr = newstr.replace(')', '');

            $("#create_login").val(newstr);
            $("#create_password").val(newstr);
        }
    </script>
    <script>
        IMask(document.getElementById("phone"), {
            mask: [{
                mask: "(00)0000000"
            }]
        });
        IMask(document.getElementById("phone2"), {
            mask: [{
                mask: "(00)0000000"
            }]
        });
        IMask(document.getElementById("create_phone"), {
            mask: [{
                mask: "(00)0000000"
            }]
        });
        IMask(document.getElementById("create_phone2"), {
            mask: [{
                mask: "(00)0000000"
            }]
        });
    </script>
    <script>
        $(document).ready(function(e) {
            $('#create_region_id').change('change', function() {
                let region_id = $('#create_region_id').val();
                $.ajax({
                    url: "{{ route('search_areas') }}",
                    method: "GET",
                    data: {
                        region_id: region_id
                    },
                    success: function(res) {
                        console.log(res);
                        var $area = $('#create_area_id');
                        $area.empty();
                        for (var i = 0; i < res.length; i++) {
                            $area.append('<option value=' + res[i]
                                .id + '>' + res[i].name + '</option>');
                        }
                        $area.change();
                    }
                });
            });
        })
    </script>
    <script>
        $('#search').keyup(function(e) {
            if (e.keyCode == 13) {
                myFilter();
            }
        });

        $('#city_id').change(function(e) {
            myFilter();
        });

        $('#area_id').change(function(e) {
            myFilter();
        });

        $('#paginate_select').change(function(e) {
            myFilter();
        });

        $('#page').keyup(function(e) {
            if (e.keyCode == 13) {
                myFilter();
            }
        });

        function orderBy(text) {
            $('#filtr').val(text);
            myFilter();
        }

        function myFilter() {
            let filtr = $('#filtr').val();
            let search = $('#search').val();
            let city_id = $('#city_id').val();
            let area_id = $('#area_id').val() ?? null;
            let page = 1;
            let paginate_select = $('#paginate_select').val() ?? 10;

            let url = '{{ route('clients') }}';
            window.location.href =
                `${url}?search=${search}&city_id=${city_id}&area_id=${area_id}&page=${page}&filtr=${filtr}&paginate_select=${paginate_select}`;
        }
    </script>
    <script>
        function ExportToExcel() {
            let filtr = $('#filtr').val();
            let search = $('#search').val();
            let city_id = $('#city_id').val();
            let area_id = $('#area_id').val() ?? null;
            let paginate_select = $('#paginate_select').val() ?? 10;
            let page = $('#page').val() ?? 1;

            let url = '{{ route('ClientsExportToExcel') }}';
            window.location.href =
                `${url}?search=${search}&city_id=${city_id}&area_id=${area_id}&page=${page}&filtr=${filtr}`;
        }
    </script>
@endsection

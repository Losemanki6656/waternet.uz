@extends('layouts.v2_master')

@section('content')
    {{-- Page title --}}
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ __('messages.Clients') }}</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('messages.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('messages.Clients') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    {{-- Action bar --}}
    <div class="row mb-2">
        <div class="col-sm-8 mb-2">
            <div class="d-flex flex-wrap gap-2 align-items-center">
                <button type="button" class="btn btn-primary rounded-3 waves-effect waves-light"
                    data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight">
                    <i class="fas fa-plus-circle me-2"></i>{{ __('messages.add_client') }}
                </button>
                <button type="button" class="btn btn-danger rounded-3 waves-effect waves-light"
                    data-bs-target="#orderAll" data-bs-toggle="modal">
                    <i class="fab fa-first-order me-1"></i>{{ __('messages.get_order') }}
                    <span id="selectedCount" class="badge bg-white text-danger ms-1" style="display:none">0</span>
                </button>
                <div class="dropdown">
                    <button class="btn btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fa fa-filter"></i> {{ __('messages.filtr') }} <i class="mdi mdi-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" onclick="orderBy('balance')">{{ __('messages.by_balance') }}</a>
                        <a class="dropdown-item" onclick="orderBy('container')">{{ __('messages.by_container') }}</a>
                        <a class="dropdown-item" onclick="orderBy('activated_at')">{{ __('messages.by_active') }}</a>
                    </div>
                    <input type="hidden" value="{{ request('filtr', 'activated_at') }}" name="filtr" id="filtr">
                </div>
                <label class="col-form-label mb-0">
                    {{ __('messages.by_filter') }}
                    <span class="text-primary fw-bold">{{ __('messages.' . request('filtr', 'active')) }};</span>
                </label>
                <label class="col-form-label mb-0">
                    {{ __('messages.client_count') }} -
                    <span class="text-primary fw-bold" id="clientTotal">{{ $clients->total() }}</span>
                </label>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="text-sm-end">
                @if(auth()->user()->hasPermissionTo('ClientExport'))
                    <button type="button" onclick="ExportToExcel()" class="btn btn-success rounded-3">
                        <i class="fas fa-cloud-download-alt"></i> {{ __('messages.export') }}
                    </button>
                @endif
            </div>
        </div>
    </div>

    {{-- Add client offcanvas --}}
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight">
        <div class="offcanvas-header">
            <h5>{{ __('messages.add_new_customer') }}</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <form class="needs-validation" novalidate action="{{ route('add_client') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label class="mb-0"> {{ __('messages.fullname') }} </label>
                    <input type="text" class="form-control" name="fullname"
                        placeholder="{{ __('messages.fullname') }}" required>
                </div>
                <div class="mb-3">
                    <label class="mb-0">{{ __('messages.select_region') }}:</label>
                    <select class="form-select" name="city_id" id="create_region_id" required>
                        <option value="">--{{ __('messages.select_region') }}--</option>
                        @foreach ($sities as $city)
                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="mb-0">{{ __('messages.select_city') }}:</label>
                    <select class="form-select" name="area_id" id="create_area_id"></select>
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
                        <label class="mb-0">{{ __('messages.phone') }}:</label>
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
                        <label class="mb-0">{{ __('messages.login') }}:</label>
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
                    <div class="col"><div class="d-grid">
                        <button type="button" class="btn btn-secondary btn-lg" data-bs-dismiss="offcanvas">
                            <i class="fas fa-reply me-2"></i>{{ __('messages.cancel') }}
                        </button>
                    </div></div>
                    <div class="col"><div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i>{{ __('messages.save') }}
                        </button>
                    </div></div>
                </div>
            </form>
        </div>
    </div>

    {{-- Bulk order modal --}}
    <div id="orderAll" class="modal fade" tabindex="-1" data-bs-scroll="true">
        <div class="modal-dialog modal-dialog-centered modal-rounded">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('messages.take_order_selected') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('add_order_check') }}" method="post" id="order_all_form">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>{{ __('messages.product_name') }}:</label>
                            <select class="form-select" id="prod_sel_all" name="product_id"
                                onchange="onselall()" required>
                                @foreach ($products as $product)
                                    <option data-amount="{{ $product->price }}" value="{{ $product->id }}">
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label>{{ __('messages.amount') }}:</label>
                                <input class="form-control" type="text" id="sena_product_order_all" name="sena"
                                    readonly @if($products->count()) value="{{ $products[0]->price }}" @endif required>
                            </div>
                            <div class="col">
                                <label>{{ __('messages.count') }}:</label>
                                <input class="form-control" type="number" value="1" name="count" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>{{ __('messages.comment') }}:</label>
                            <textarea class="form-control" name="izoh" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-lg" data-bs-dismiss="modal">
                            <i class="fas fa-reply me-2"></i>{{ __('messages.cancel') }}
                        </button>
                        <button class="btn btn-success btn-lg" type="submit">
                            <i class="fa fa-save me-2"></i>{{ __('messages.save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Filter row --}}
    <div class="row mb-2">
        <div class="col-sm-3 mb-2">
            <div class="card mb-0">
                <select class="form-control" name="city_id" id="city_id">
                    <option value="">{{ __('messages.select_region') }}</option>
                    @foreach ($sities as $sity)
                        <option value="{{ $sity->id }}" @if($sity->id == request('city_id')) selected @endif>
                            {{ $sity->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-3 mb-2">
            <div class="card mb-0">
                <select class="form-control" name="area_id" id="area_id">
                    <option value="">{{ __('messages.select_city') }}</option>
                    @foreach ($areas as $area)
                        <option value="{{ $area->id }}" @if($area->id == request('area_id')) selected @endif>
                            {{ $area->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-4"></div>
        <div class="col-sm-2 mb-2">
            <input type="search" class="form-control" name="search" id="search"
                value="{{ request('search') }}" placeholder="{{ __('messages.search') }}">
        </div>
    </div>

    {{-- Table region (AJAX-replaced) --}}
    <div class="row">
        <div class="col-12">
            <div class="card rounded-3">
                <div class="card-body p-0">
                    <div id="filter-table">
                        @include('include_tables.clients_table')
                        @if ($clients->total() > 10)
                            <div class="row justify-content-between px-3 py-2">
                                <div class="col-md-2">
                                    <select class="form-select" id="paginate_select" style="max-width:100px">
                                        <option value="10"  @if($clients->perPage()==10)  selected @endif>10</option>
                                        <option value="30"  @if($clients->perPage()==30)  selected @endif>30</option>
                                        <option value="50"  @if($clients->perPage()==50)  selected @endif>50</option>
                                        <option value="100" @if($clients->perPage()==100) selected @endif>100</option>
                                    </select>
                                </div>
                                <div class="col-md-8 text-center">
                                    {{ $clients->onEachSide(1)->withQueryString() }}
                                </div>
                                <div class="col-md-2 text-end">
                                    <input type="number" class="form-control" id="page" style="width:100px"
                                        placeholder="{{ __('messages.page') }}"
                                        value="{{ $clients->currentPage() }}">
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════
         Location offcanvas — Yandex Maps
         Lives OUTSIDE #filter-table to survive AJAX replacements.
         ══════════════════════════════════════════════════════════════ --}}
    <div class="offcanvas offcanvas-bottom" tabindex="-1" id="viewLocation"
         style="height:560px; border-radius:20px 20px 0 0; overflow:hidden; border:none">

        {{-- Gradient header --}}
        <div class="d-flex align-items-center justify-content-between px-4"
             style="min-height:72px; background:linear-gradient(135deg,#556ee6 0%,#6610f2 100%); flex-shrink:0">
            <div class="d-flex align-items-center gap-3">
                <div id="loc-avatar"
                     style="width:44px;height:44px;min-width:44px;border-radius:50%;
                            background:rgba(255,255,255,.2);display:flex;align-items:center;
                            justify-content:center;font-weight:700;font-size:17px;color:#fff">?</div>
                <div>
                    <div id="locationLabel"
                         style="color:#fff;font-weight:600;font-size:15px;line-height:1.3">—</div>
                    <div style="color:rgba(255,255,255,.65);font-size:12px;margin-top:2px">
                        <i class="bx bx-crosshair"></i>
                        <span id="coordText">{{ __('messages.no_location') }}</span>
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <button id="saveLocationBtn" type="button" onclick="addLocation()"
                        style="background:rgba(255,255,255,.18);color:#fff;
                               border:1px solid rgba(255,255,255,.4);border-radius:8px;
                               padding:6px 14px;font-size:13px;cursor:pointer;transition:.2s">
                    <i class="bx bx-save me-1"></i>{{ __('messages.update_location') }}
                </button>
                <button type="button" data-bs-dismiss="offcanvas"
                        style="background:none;border:none;color:#fff;font-size:22px;
                               line-height:1;cursor:pointer;padding:0 4px;opacity:.8">×</button>
            </div>
        </div>

        {{-- Yandex Map + floating coord pill --}}
        <div class="position-relative" style="flex:1;height:calc(100% - 72px)">
            <div id="map" style="width:100%;height:100%"></div>

            <div style="position:absolute;bottom:18px;left:50%;transform:translateX(-50%);
                        background:#fff;border-radius:20px;padding:6px 18px;
                        box-shadow:0 4px 16px rgba(0,0,0,.15);font-size:13px;color:#444;
                        z-index:500;white-space:nowrap;pointer-events:none;
                        display:flex;align-items:center;gap:6px">
                <i class="bx bx-map-pin text-primary"></i>
                <span id="coordDisplay">{{ __('messages.click_map_to_set') }}</span>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
{{-- Yandex Maps 2.1 API --}}
<script src="https://api-maps.yandex.ru/2.1/?apikey={{ env('YANDEX_MAPS_KEY', '') }}&lang=ru_RU" type="text/javascript"></script>

<script>
// ═══════════════════════════════════════════════════════════════════════
// 1. YANDEX MAPS — init
// ═══════════════════════════════════════════════════════════════════════
ymaps.ready(function () {
    var ymap = new ymaps.Map('map', {
        center: [41.2942336, 69.2518912],
        zoom: 7,
        controls: ['zoomControl', 'typeSelector', 'fullscreenControl']
    });

    window.ymap      = ymap;
    window.yplacemark = null;

    // Recalculate viewport when offcanvas opens
    document.getElementById('viewLocation').addEventListener('shown.bs.offcanvas', function () {
        ymap.container.fitToViewport();
    });
});

// ── Shared coord update helper ────────────────────────────────────────
function _updateCoords(lat, lng) {
    var str = parseFloat(lat).toFixed(6) + ', ' + parseFloat(lng).toFixed(6);
    document.getElementById('coordText').textContent    = str;
    document.getElementById('coordDisplay').textContent = str;
    window._locationInput = lat + ',' + lng;
}

// ── showLocation(location, fullname, clientId) ────────────────────────
// Called from clients table row buttons.
// If window._locationFormMode is set, save goes to the form input instead of AJAX.
function showLocation(location, fullname, clientId) {
    localStorage.setItem('client', clientId);
    document.getElementById('loc-avatar').textContent  = (fullname || '?').charAt(0).toUpperCase();
    document.getElementById('locationLabel').textContent = fullname;

    new bootstrap.Offcanvas(document.getElementById('viewLocation')).show();

    var lat = 41.2942336, lng = 69.2518912;
    if (location && location.length > 3) {
        var p = location.split(',');
        lat = parseFloat(p[0]);
        lng = parseFloat(p[1]);
    }

    var ymap = window.ymap;
    if (window.yplacemark) ymap.geoObjects.remove(window.yplacemark);

    window.yplacemark = new ymaps.Placemark([lat, lng],
        { balloonContent: fullname },
        { preset: 'islands#redCircleDotIcon', draggable: true }
    );
    ymap.geoObjects.add(window.yplacemark);
    ymap.setCenter([lat, lng], 15);
    _updateCoords(lat, lng);

    // Dragging the marker updates coords
    window.yplacemark.events.add('dragend', function () {
        var c = window.yplacemark.geometry.getCoordinates();
        _updateCoords(c[0], c[1]);
    });

    // Clicking the map moves the marker
    ymap.events.remove('click');
    ymap.events.add('click', function (e) {
        var coords = e.get('coords');
        ymap.geoObjects.remove(window.yplacemark);
        window.yplacemark = new ymaps.Placemark(coords,
            { balloonContent: fullname },
            { preset: 'islands#redCircleDotIcon', draggable: true }
        );
        ymap.geoObjects.add(window.yplacemark);
        window.yplacemark.events.add('dragend', function () {
            var c = window.yplacemark.geometry.getCoordinates();
            _updateCoords(c[0], c[1]);
        });
        _updateCoords(coords[0], coords[1]);
    });
}

// ── setlocation(event, clientId) — used in edit offcanvas ─────────────
// Opens the map picker in "form mode": save writes to hidden input, not AJAX.
function setlocation(event, clientId) {
    event.preventDefault();
    window._locationFormMode = clientId; // signal addLocation() to write to form

    var currentVal = (document.getElementById('location' + clientId) || {}).value || '0';
    showLocation(currentVal === '0' ? '' : currentVal, '', clientId);
}

// ── addLocation() — Save button ───────────────────────────────────────
function addLocation() {
    var location = window._locationInput;
    if (!location) { alertify.error('{{ __("messages.add_location") }}'); return; }

    // ── Form mode: write to hidden input ──
    if (window._locationFormMode) {
        var cid = window._locationFormMode;
        window._locationFormMode = null;

        var hiddenInput = document.getElementById('location' + cid);
        if (hiddenInput) hiddenInput.value = location;

        var btn = document.getElementById('select_location' + cid);
        if (btn) {
            btn.classList.replace('btn-warning', 'btn-success');
            btn.innerHTML = '<i class="fa fa-map-marker me-1"></i>✓ Selected';
        }
        bootstrap.Offcanvas.getInstance(document.getElementById('viewLocation')).hide();
        return;
    }

    // ── Direct mode: AJAX save ──
    var id = localStorage.getItem('client');
    if (!id) { alertify.error('Client not set'); return; }

    var btn = document.getElementById('saveLocationBtn');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>...';

    $.ajax({
        url: '{{ route('update_location') }}',
        method: 'GET',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        data: { client_id: id, location: location },
        success: function (res) {
            alertify.success(res.message || '{{ __("messages.location_updated_successfully") }}');
            bootstrap.Offcanvas.getInstance(document.getElementById('viewLocation')).hide();
            loadClients({ page: parseInt($('#page').val()) || 1 });
        },
        error: function (xhr) {
            alertify.error((xhr.responseJSON && xhr.responseJSON.message) || 'Error');
        },
        complete: function () {
            btn.disabled = false;
            btn.innerHTML = '<i class="bx bx-save me-1"></i>{{ __("messages.update_location") }}';
        }
    });
}

// No-op kept for backward compatibility (was used on hidden location input's onchange)
function dotReplace() {}

// ═══════════════════════════════════════════════════════════════════════
// 2. CHECKBOX PERSISTENCE across AJAX pagination
// ═══════════════════════════════════════════════════════════════════════
var _selectedClients = new Set();

function _clientIdFromName(name) {
    var m = name.match(/\[(\d+)\]/);
    return m ? parseInt(m[1]) : null;
}

function _updateSelectedBadge() {
    var n = _selectedClients.size;
    var badge = document.getElementById('selectedCount');
    if (n > 0) { badge.textContent = n; badge.style.display = ''; }
    else          badge.style.display = 'none';
}

function _updateCheckAllState() {
    var $boxes = $('#filter-table input[name^="checkbox["]');
    var total   = $boxes.length;
    var checked = $boxes.filter(':checked').length;
    var $all = $('#checkAll');
    if (!$all.length) return;
    if (total === 0 || checked === 0) {
        $all.prop({ indeterminate: false, checked: false });
    } else if (checked === total) {
        $all.prop({ indeterminate: false, checked: true });
    } else {
        $all.prop({ indeterminate: true });
    }
}

// Restore checked state after AJAX table replacement
function _restoreCheckboxes() {
    $('#filter-table input[name^="checkbox["]').each(function () {
        var id = _clientIdFromName($(this).attr('name'));
        if (id && _selectedClients.has(id)) $(this).prop('checked', true);
    });
    _updateCheckAllState();
    _updateSelectedBadge();
}

// Individual checkbox toggle
$(document).on('change', '#filter-table input[name^="checkbox["]', function () {
    var id = _clientIdFromName($(this).attr('name'));
    if (!id) return;
    if ($(this).prop('checked')) _selectedClients.add(id);
    else                          _selectedClients.delete(id);
    _updateCheckAllState();
    _updateSelectedBadge();
});

// Check-all toggle
$(document).on('change', '#checkAll', function () {
    var checked = $(this).prop('checked');
    $('#filter-table input[name^="checkbox["]').each(function () {
        var id = _clientIdFromName($(this).attr('name'));
        if (!id) return;
        $(this).prop('checked', checked);
        if (checked) _selectedClients.add(id);
        else          _selectedClients.delete(id);
    });
    _updateSelectedBadge();
});

// Before bulk order modal opens: inject hidden inputs for off-page selected clients
$('#orderAll').on('show.bs.modal', function () {
    $('#order_all_form input.x-cross-page').remove(); // remove previous
    var visibleIds = new Set();
    $('#filter-table input[name^="checkbox["]').each(function () {
        var id = _clientIdFromName($(this).attr('name'));
        if (id) visibleIds.add(id);
    });
    _selectedClients.forEach(function (id) {
        if (!visibleIds.has(id)) {
            $('#order_all_form').append(
                '<input type="hidden" class="x-cross-page" name="checkbox[' + id + ']" value="1">'
            );
        }
    });
});

// ═══════════════════════════════════════════════════════════════════════
// 3. AJAX CLIENTS TABLE
// ═══════════════════════════════════════════════════════════════════════
var _loadTimer = null;

function _getFilterParams(extra) {
    return $.extend({
        search:          $('#search').val(),
        city_id:         $('#city_id').val(),
        area_id:         $('#area_id').val(),
        filtr:           $('#filtr').val(),
        paginate_select: $('#paginate_select').val() || 10,
        page:            1,
    }, extra || {});
}

function loadClients(extra) {
    clearTimeout(_loadTimer);
    _loadTimer = setTimeout(function () {
        var params = _getFilterParams(extra);
        $('#filter-table').css('opacity', .5);

        $.ajax({
            url: '{{ route('clients') }}',
            method: 'GET',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            data: params,
            success: function (res) {
                var pagHtml = '';
                if (res.pagination) {
                    pagHtml = '<div class="row justify-content-between px-3 py-2">'
                        + '<div class="col-md-2"><select class="form-select" id="paginate_select" style="max-width:100px">'
                        + [10, 30, 50, 100].map(function (v) {
                            return '<option value="' + v + '"' + (v == res.perPage ? ' selected' : '') + '>' + v + '</option>';
                        }).join('')
                        + '</select></div>'
                        + '<div class="col-md-8 text-center">' + res.pagination + '</div>'
                        + '<div class="col-md-2 text-end"><input type="number" class="form-control" id="page"'
                        + ' style="width:100px" placeholder="{{ __('messages.page') }}" value="' + (params.page || 1) + '"></div>'
                        + '</div>';
                }

                $('#filter-table').html(res.table + pagHtml).css('opacity', 1);
                document.getElementById('clientTotal').textContent = res.total;
                $('[data-bs-toggle="tooltip"]').tooltip();
                _restoreCheckboxes();
            },
            error: function () {
                $('#filter-table').css('opacity', 1);
                alertify.error('Error loading clients');
            }
        });
    }, 200);
}

// ── Filters outside #filter-table ─────────────────────────────────────
$('#search').on('keyup', function (e) {
    if (e.keyCode === 13) loadClients({ page: 1 });
});

// city_id change: reload areas then reload table
$('#city_id').on('change', function () {
    var cityId = $(this).val();
    if (cityId) {
        $.get('{{ route('search_areas') }}', { region_id: cityId }, function (res) {
            var newChoices = [{ value: '', label: '{{ __("messages.select_city") }}', placeholder: true }]
                .concat(res.map(function (r) { return { value: String(r.id), label: r.name }; }));
            if (window._areaChoices) {
                window._areaChoices.setChoices(newChoices, 'value', 'label', true);
            }
        });
    } else if (window._areaChoices) {
        window._areaChoices.setChoices(
            [{ value: '', label: '{{ __("messages.select_city") }}', placeholder: true }],
            'value', 'label', true
        );
    }
    loadClients({ page: 1 });
});

$('#area_id').on('change', function () { loadClients({ page: 1 }); });

function orderBy(text) { $('#filtr').val(text); loadClients({ page: 1 }); }

// ── Elements inside #filter-table (event delegation) ──────────────────
$(document).on('change', '#paginate_select', function () {
    loadClients({ page: 1, paginate_select: $(this).val() });
});
$(document).on('keyup', '#page', function (e) {
    if (e.keyCode === 13) loadClients({ page: $(this).val() });
});
$(document).on('click', '#filter-table .pagination a', function (e) {
    e.preventDefault();
    var href = $(this).attr('href');
    if (!href || href === '#') return;
    try {
        var p = new URLSearchParams(new URL(href).search).get('page') || 1;
        loadClients({ page: p });
        window.scrollTo({ top: document.getElementById('filter-table').offsetTop - 80, behavior: 'smooth' });
    } catch (_) {}
});

// ═══════════════════════════════════════════════════════════════════════
// 4. UNIVERSAL AJAX FORM SUBMIT — modals & offcanvases in #filter-table
// ═══════════════════════════════════════════════════════════════════════
$(document).on('submit', '#filter-table form', function (e) {
    e.preventDefault();
    var $form = $(this);
    var $btn  = $form.find('[type="submit"]');
    var origHtml = $btn.html();
    $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>');

    $.ajax({
        url:     $form.attr('action'),
        method:  ($form.attr('method') || 'POST').toUpperCase(),
        data:    $form.serialize(),
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        success: function (res) {
            if (res.success === false) {
                alertify.error(res.message || 'Error');
                return;
            }
            alertify.success(res.message || '{{ __("messages.success") }}');

            // Close parent modal or offcanvas
            var $modal     = $form.closest('.modal.show');
            var $offcanvas = $form.closest('.offcanvas.show');
            if ($modal.length)     bootstrap.Modal.getInstance($modal[0]).hide();
            if ($offcanvas.length) bootstrap.Offcanvas.getInstance($offcanvas[0]).hide();

            loadClients({ page: parseInt($('#page').val()) || 1 });
        },
        error: function (xhr) {
            alertify.error((xhr.responseJSON && xhr.responseJSON.message) || 'Error');
        },
        complete: function () {
            $btn.prop('disabled', false).html(origHtml);
        }
    });
});

// Bulk order form (#orderAll) — outside #filter-table, handle separately
$('#order_all_form').on('submit', function (e) {
    e.preventDefault();
    var $form = $(this);
    var $btn  = $form.find('[type="submit"]');
    var origHtml = $btn.html();
    $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>');

    $.ajax({
        url:     $form.attr('action'),
        method:  'POST',
        data:    $form.serialize(),
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        success: function (res) {
            if (res.success === false) {
                alertify.error(res.message || 'Error');
                return;
            }
            alertify.success(res.message || '{{ __("messages.success") }}');
            bootstrap.Modal.getInstance(document.getElementById('orderAll')).hide();
            _selectedClients.clear();
            _updateSelectedBadge();
            loadClients({ page: parseInt($('#page').val()) || 1 });
        },
        error: function (xhr) {
            alertify.error((xhr.responseJSON && xhr.responseJSON.message) || 'Error');
        },
        complete: function () {
            $btn.prop('disabled', false).html(origHtml);
        }
    });
});

// ── Misc helpers ──────────────────────────────────────────────────────
function onselall() {
    $('#sena_product_order_all').val($('#prod_sel_all').find(':selected').data('amount'));
}

function login_pass() {
    var x = document.getElementById('create_phone').value.replace('(','').replace(')','');
    $('#create_login').val(x);
    $('#create_password').val(x);
}

function ExportToExcel() {
    var p = _getFilterParams({ page: $('#page').val() || 1 });
    delete p.paginate_select;
    window.location.href = '{{ route('ClientsExportToExcel') }}?' + $.param(p);
}

$(document).ready(function () {
    // Initialize Choices.js for filter selects (styling + searchable dropdown)
    window._cityChoices = new Choices('#city_id', {
        searchEnabled: true,
        itemSelectText: '',
        shouldSort: false,
        allowHTML: false,
        placeholder: true,
        placeholderValue: '{{ __("messages.select_region") }}',
    });
    window._areaChoices = new Choices('#area_id', {
        searchEnabled: true,
        itemSelectText: '',
        shouldSort: false,
        allowHTML: false,
        placeholder: true,
        placeholderValue: '{{ __("messages.select_city") }}',
    });

    // Create-client: region → area AJAX
    $('#create_region_id').on('change', function () {
        $.get('{{ route('search_areas') }}', { region_id: $(this).val() }, function (res) {
            var $a = $('#create_area_id').empty();
            res.forEach(function (r) {
                $a.append('<option value="' + r.id + '">' + r.name + '</option>');
            });
        });
    });

    // Phone masks for add-client form
    ['#create_phone', '#create_phone2'].forEach(function (sel) {
        var el = document.querySelector(sel);
        if (el) IMask(el, { mask: [{ mask: '(00)0000000' }] });
    });

    // Restore scroll position
    var sp = localStorage.getItem('scrollpos');
    if (sp) window.scrollTo(0, sp);
});

window.onscroll = function () { localStorage.setItem('scrollpos', window.scrollY); };
</script>
@endsection

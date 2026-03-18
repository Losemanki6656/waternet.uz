@extends('layouts.v2_master')

@section('content')

    {{-- Page title --}}
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ __('messages.Orders') }}</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('messages.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('messages.Orders') }}</li>
                    </ol>
                </div>
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
        <div class="col-sm-3 mb-2 d-flex align-items-center">
            <label class="col-form-label mb-0">
                {{ __('messages.orders_count') }}
                <span class="text-primary fw-bold" id="summOrder">{{ $summ_order }}</span>;
                {{ __('messages.client_count') }} -
                <span class="text-primary fw-bold" id="orderTotal">{{ $orders->total() }}</span>
            </label>
        </div>
        <div class="col-sm-3 mb-2">
            <input type="search" class="form-control" id="search"
                   value="{{ request('search') }}" placeholder="{{ __('messages.search') }}">
        </div>
    </div>

    {{-- client_id filter (from /clients page link) --}}
    <input type="hidden" id="client_id" value="{{ request('client_id') }}">

    {{-- Table region (AJAX-replaced) --}}
    <div class="row">
        <div class="col-12">
            <div class="card rounded-3">
                <div class="card-body p-0">
                    <div id="filter-table">
                        @include('include_tables.orders_table')
                        @if ($orders->total() > 10)
                            <div class="row justify-content-between px-3 py-2">
                                <div class="col-md-2">
                                    <select class="form-select" id="paginate_select" style="max-width:100px">
                                        <option value="10"  @if($orders->perPage()==10)  selected @endif>10</option>
                                        <option value="30"  @if($orders->perPage()==30)  selected @endif>30</option>
                                        <option value="50"  @if($orders->perPage()==50)  selected @endif>50</option>
                                        <option value="100" @if($orders->perPage()==100) selected @endif>100</option>
                                    </select>
                                </div>
                                <div class="col-md-8 text-center">
                                    {{ $orders->onEachSide(1)->withQueryString() }}
                                </div>
                                <div class="col-md-2 text-end">
                                    <input type="number" class="form-control" id="page" style="width:100px"
                                           placeholder="{{ __('messages.page') }}"
                                           value="{{ $orders->currentPage() }}">
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- View order modal — outside #filter-table --}}
    <div class="modal fade" id="view-order" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('messages.view_order') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label class="fw-bold">{{ __('messages.fullname') }}:</label>
                        <span id="view_full_name"></span>
                    </div>
                    <div class="mb-2">
                        <label class="fw-bold">{{ __('messages.phone') }}:</label>
                        <span id="view_phone"></span>
                    </div>
                    <div class="mb-2">
                        <label class="fw-bold">{{ __('messages.address') }}:</label>
                        <span id="view_address"></span>
                    </div>
                    <div class="mb-2">
                        <label class="fw-bold">{{ __('messages.comment') }}:</label>
                        <span id="view_comment"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
<script>
// ═══════════════════════════════════════════════════════════════════════
// 1. AJAX ORDERS TABLE
// ═══════════════════════════════════════════════════════════════════════
var _orderTimer = null;

function _getOrderParams(extra) {
    return $.extend({
        search:          $('#search').val(),
        city_id:         $('#city_id').val(),
        area_id:         $('#area_id').val(),
        client_id:       $('#client_id').val(),
        paginate_select: $('#paginate_select').val() || 10,
        page:            1,
    }, extra || {});
}

function loadOrders(extra) {
    clearTimeout(_orderTimer);
    _orderTimer = setTimeout(function () {
        var params = _getOrderParams(extra);
        $('#filter-table').css('opacity', .5);

        $.ajax({
            url:     '{{ route('orders') }}',
            method:  'GET',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            data:    params,
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
                document.getElementById('orderTotal').textContent = res.total;
                document.getElementById('summOrder').textContent  = res.summOrder;
                $('[data-bs-toggle="tooltip"]').tooltip();
                initSortable();
            },
            error: function () {
                $('#filter-table').css('opacity', 1);
                alertify.error('Error loading orders');
            }
        });
    }, 200);
}

// ── Sortable rows ──────────────────────────────────────────────────────
function initSortable() {
    $('#table_order tbody').sortable({
        update: function () {
            var order = [];
            $('#table_order tr.row1').each(function (index) {
                order.push({ id: $(this).data('id'), position: index + 1 });
            });
            $.ajax({
                type: 'POST',
                url:  '{{ url('orders/sortable') }}',
                data: { order: order, _token: '{{ csrf_token() }}' },
                success: function (res) { alertify.success(res.message); }
            });
        }
    });
}

// ── View order (reads from <tr> data attributes) ───────────────────────
$(document).on('click', '#filter-table .view-order-btn', function () {
    var $tr = $(this).closest('tr');
    var city    = $tr.data('city') || '';
    var area    = $tr.data('area') || '';
    var address = $tr.data('address') || '';
    var loc     = [city, area, address].filter(Boolean).join(', ');

    $('#view_full_name').text($tr.data('fullname'));
    $('#view_phone').text($tr.data('phone'));
    $('#view_address').text(loc);
    $('#view_comment').text($tr.data('comment'));
    $('#view-order').modal('show');
});

// ── DeleteOrder ────────────────────────────────────────────────────────
function DeleteOrder(fullname, id) {
    Swal.fire({
        title: "{{ __('messages.Do_you_want_to_delete') }} ?",
        text:  fullname,
        icon:  'warning',
        showCancelButton:  true,
        cancelButtonText:  "{{ __('messages.no') }}",
        confirmButtonColor: '#1c84ee',
        cancelButtonColor:  '#fd625e',
        confirmButtonText: "{{ __('messages.Yes_delete') }} !"
    }).then(function (e) {
        if (!e.isConfirmed) return;
        $.ajax({
            url:    '{{ route('delete_Order') }}',
            method: 'POST',
            data:   { _token: '{{ csrf_token() }}', id: id },
            success: function () {
                Swal.fire("{{ __('messages.deleted') }}!",
                    "{{ __('messages.success_removed') }}", 'success')
                    .then(function () {
                        loadOrders({ page: parseInt($('#page').val()) || 1 });
                    });
            },
            error: function (xhr) {
                alertify.error((xhr.responseJSON && xhr.responseJSON.message) || 'Error');
            }
        });
    });
}

// ── Universal AJAX form submit for forms inside #filter-table ──────────
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
            if (res.success === false) { alertify.error(res.message || 'Error'); return; }
            alertify.success(res.message || '{{ __("messages.success") }}');
            var $modal = $form.closest('.modal.show');
            if ($modal.length) bootstrap.Modal.getInstance($modal[0]).hide();
            loadOrders({ page: parseInt($('#page').val()) || 1 });
        },
        error: function (xhr) {
            alertify.error((xhr.responseJSON && xhr.responseJSON.message) || 'Error');
        },
        complete: function () { $btn.prop('disabled', false).html(origHtml); }
    });
});

// ── onsel (edit modal product change) ─────────────────────────────────
function onsel(id) {
    var $sel = $('#prod_sel' + id);
    var price = $sel.find(':selected').data('amount');
    $('#sena_product_order' + id).val(price);
}

// ═══════════════════════════════════════════════════════════════════════
// 2. FILTERS — outside #filter-table
// ═══════════════════════════════════════════════════════════════════════
$('#search').on('keyup', function (e) {
    if (e.keyCode === 13) loadOrders({ page: 1 });
});

$('#city_id').on('change', function () {
    var cityId = $(this).val();
    if (cityId) {
        $.get('{{ route('search_areas') }}', { region_id: cityId }, function (res) {
            var newChoices = [{ value: '', label: '{{ __("messages.select_city") }}', placeholder: true }]
                .concat(res.map(function (r) { return { value: String(r.id), label: r.name }; }));
            if (window._areaChoicesOrders) {
                window._areaChoicesOrders.setChoices(newChoices, 'value', 'label', true);
            }
        });
    } else if (window._areaChoicesOrders) {
        window._areaChoicesOrders.setChoices(
            [{ value: '', label: '{{ __("messages.select_city") }}', placeholder: true }],
            'value', 'label', true
        );
    }
    loadOrders({ page: 1 });
});

$('#area_id').on('change', function () { loadOrders({ page: 1 }); });

// ── Elements inside #filter-table (event delegation) ──────────────────
$(document).on('change', '#paginate_select', function () {
    loadOrders({ page: 1, paginate_select: $(this).val() });
});
$(document).on('keyup', '#page', function (e) {
    if (e.keyCode === 13) loadOrders({ page: $(this).val() });
});
$(document).on('click', '#filter-table .pagination a', function (e) {
    e.preventDefault();
    var href = $(this).attr('href');
    if (!href || href === '#') return;
    try {
        var p = new URLSearchParams(new URL(href).search).get('page') || 1;
        loadOrders({ page: p });
        window.scrollTo({ top: document.getElementById('filter-table').offsetTop - 80, behavior: 'smooth' });
    } catch (_) {}
});

// ═══════════════════════════════════════════════════════════════════════
// 3. INIT
// ═══════════════════════════════════════════════════════════════════════
$(document).ready(function () {
    // Choices.js for filter selects
    window._cityChoicesOrders = new Choices('#city_id', {
        searchEnabled: true, itemSelectText: '', shouldSort: false, allowHTML: false,
        placeholder: true, placeholderValue: '{{ __("messages.select_region") }}',
    });
    window._areaChoicesOrders = new Choices('#area_id', {
        searchEnabled: true, itemSelectText: '', shouldSort: false, allowHTML: false,
        placeholder: true, placeholderValue: '{{ __("messages.select_city") }}',
    });

    // Init sortable on first load
    initSortable();

    // Restore scroll
    var sp = localStorage.getItem('orders_scrollpos');
    if (sp) window.scrollTo(0, sp);
});

window.onscroll = function () { localStorage.setItem('orders_scrollpos', window.scrollY); };
</script>
@endsection

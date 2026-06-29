@extends('layouts.v2_master')

@section('styles')
    <style>
        #drivers-map {
            width: 100%;
            height: calc(100vh - 200px);
            min-height: 460px;
            border-radius: 12px;
            overflow: hidden;
        }

        .dl-search {
            position: relative;
            display: flex;
            align-items: center;
            background: #fff;
            border: 1px solid #e6e9f0;
            border-radius: 12px;
            padding: 0 12px;
        }

        .dl-search i {
            width: 16px;
            height: 16px;
            color: #2563EB;
        }

        .dl-search input {
            border: 0;
            outline: 0;
            background: transparent;
            height: 42px;
            width: 100%;
            padding-left: 10px;
            font-size: 14px;
        }

        .dl-filters {
            display: flex;
            gap: 8px;
        }

        .dl-filter {
            flex: 1;
            border: 1px solid #e6e9f0;
            background: #fff;
            border-radius: 10px;
            padding: 7px 0;
            font-size: 12.5px;
            font-weight: 600;
            color: #5f6b80;
            cursor: pointer;
        }

        .dl-filter.active {
            background: #1D4ED8;
            border-color: #1D4ED8;
            color: #fff;
        }

        .dl-filter .cnt {
            display: inline-block;
            min-width: 18px;
            font-size: 11px;
            opacity: .8;
        }

        .driver-list {
            max-height: calc(100vh - 320px);
            overflow-y: auto;
            padding-right: 2px;
        }

        .driver-card {
            background: #fff;
            border: 1px solid #eef1f5;
            border-radius: 12px;
            padding: 12px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: box-shadow .15s ease, transform .1s ease;
        }

        .driver-card:hover {
            box-shadow: 0 10px 24px -14px rgba(11, 31, 58, .4);
            transform: translateY(-1px);
        }

        .driver-card .dc-head {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .driver-card .dc-name {
            font-weight: 600;
            color: #0B1F3A;
            flex: 1;
        }

        .driver-card .dc-meta {
            font-size: 12px;
            color: #8a93a6;
            margin-top: 4px;
            margin-left: 18px;
        }

        .driver-card .dc-km {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            margin-top: 8px;
            margin-left: 18px;
            background: #EAF1FF;
            color: #1D4ED8;
            font-size: 12px;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 8px;
        }

        .status-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
        }

        .status-dot.on { background: #16B981; }
        .status-dot.off { background: #9aa7b8; }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row align-items-center mb-3">
            <div class="col">
                <h4 class="mb-0">{{ __('messages.drivers_map_title') }}</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3 mb-3">
                <div class="dl-search mb-2">
                    <i data-feather="search"></i>
                    <input type="text" id="driver-search" placeholder="{{ __('messages.search_driver') }}">
                </div>

                <div class="dl-filters mb-3">
                    <button type="button" class="dl-filter active" data-filter="all">
                        {{ __('messages.all') }} <span class="cnt" id="cnt-all">0</span>
                    </button>
                    <button type="button" class="dl-filter" data-filter="online">
                        {{ __('messages.online') }} <span class="cnt" id="cnt-online">0</span>
                    </button>
                    <button type="button" class="dl-filter" data-filter="offline">
                        {{ __('messages.offline') }} <span class="cnt" id="cnt-offline">0</span>
                    </button>
                </div>

                <div class="driver-list" id="driver-list"></div>
            </div>

            <div class="col-lg-9">
                <div id="drivers-map"></div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://api-maps.yandex.ru/2.1/?apikey={{ env('MAPS_YANDEX_KEY') }}&lang=ru_RU"
            type="text/javascript"></script>
    <script>
        (function () {
            var map, placemarks = {}, allDrivers = [], firstFit = true;
            var state = {filter: 'all', search: ''};
            var locationsUrl = "{{ route('drivers.locations') }}";
            var lastSeenLabel = "{{ __('messages.last_seen') }}";
            var kmLabel = "{{ __('messages.km_today') }}";
            var emptyLabel = "{{ __('messages.no_drivers_online') }}";

            function init() {
                map = new ymaps.Map('drivers-map', {
                    center: [41.311081, 69.240562],
                    zoom: 11,
                    controls: ['zoomControl', 'geolocationControl', 'fullscreenControl']
                });

                document.getElementById('driver-search').addEventListener('input', function (e) {
                    state.search = (e.target.value || '').toLowerCase();
                    applyView();
                });

                document.querySelectorAll('.dl-filter').forEach(function (btn) {
                    btn.addEventListener('click', function () {
                        document.querySelectorAll('.dl-filter').forEach(function (b) { b.classList.remove('active'); });
                        btn.classList.add('active');
                        state.filter = btn.getAttribute('data-filter');
                        applyView();
                    });
                });

                load();
                setInterval(load, 12000);
            }

            function load() {
                fetch(locationsUrl, {headers: {'X-Requested-With': 'XMLHttpRequest'}, credentials: 'same-origin'})
                    .then(function (r) { return r.json(); })
                    .then(function (drivers) {
                        allDrivers = drivers || [];
                        updateCounts();
                        applyView();
                    })
                    .catch(function () { });
            }

            function updateCounts() {
                var on = allDrivers.filter(function (d) { return d.online; }).length;
                document.getElementById('cnt-all').textContent = allDrivers.length;
                document.getElementById('cnt-online').textContent = on;
                document.getElementById('cnt-offline').textContent = allDrivers.length - on;
            }

            function visible() {
                return allDrivers.filter(function (d) {
                    if (state.filter === 'online' && !d.online) return false;
                    if (state.filter === 'offline' && d.online) return false;
                    if (state.search && (d.name || '').toLowerCase().indexOf(state.search) === -1) return false;
                    return true;
                });
            }

            function applyView() {
                var vis = visible();
                renderList(vis);
                syncMarkers(vis);
            }

            function preset(online) {
                return online ? 'islands#greenDotIconWithCaption' : 'islands#grayDotIconWithCaption';
            }

            function balloon(d) {
                return '<strong>' + d.name + '</strong>' +
                    (d.organization ? '<br><small style="color:#888">' + d.organization + '</small>' : '') +
                    '<br>' + (d.phone || '') +
                    '<br>' + lastSeenLabel + ': ' + (d.last_location_at || '-') +
                    '<br>' + (d.km_today || 0) + ' ' + kmLabel;
            }

            function syncMarkers(vis) {
                var ids = {};
                var coordsList = [];

                vis.forEach(function (d) {
                    ids[d.id] = true;
                    var coords = [d.lat, d.lng];
                    coordsList.push(coords);

                    if (placemarks[d.id]) {
                        placemarks[d.id].geometry.setCoordinates(coords);
                    } else {
                        var pm = new ymaps.Placemark(coords, {
                            iconCaption: d.name,
                            balloonContent: balloon(d)
                        }, {preset: preset(d.online)});
                        map.geoObjects.add(pm);
                        placemarks[d.id] = pm;
                    }

                    placemarks[d.id].options.set('preset', preset(d.online));
                    placemarks[d.id].properties.set('balloonContent', balloon(d));
                });

                Object.keys(placemarks).forEach(function (id) {
                    if (!ids[id]) {
                        map.geoObjects.remove(placemarks[id]);
                        delete placemarks[id];
                    }
                });

                if (firstFit && coordsList.length) {
                    firstFit = false;
                    try {
                        map.setBounds(map.geoObjects.getBounds(), {checkZoomRange: true, zoomMargin: 40});
                    } catch (e) { }
                }
            }

            function renderList(drivers) {
                var box = document.getElementById('driver-list');

                if (!drivers.length) {
                    box.innerHTML = '<div class="text-muted p-3 text-center">' + emptyLabel + '</div>';
                    return;
                }

                var html = '';
                drivers.forEach(function (d) {
                    html += '<div class="driver-card" onclick="focusDriver(' + d.id + ')">' +
                        '<div class="dc-head">' +
                        '<span class="status-dot ' + (d.online ? 'on' : 'off') + '"></span>' +
                        '<span class="dc-name">' + d.name + '</span>' +
                        '</div>' +
                        (d.organization ? '<div class="dc-meta">' + d.organization + '</div>' : '') +
                        '<div class="dc-meta">' + (d.phone || '') + ' · ' + (d.last_location_at || '-') + '</div>' +
                        '<div class="dc-km"><i class="fas fa-route"></i>' + (d.km_today || 0) + ' ' + kmLabel + '</div>' +
                        '</div>';
                });
                box.innerHTML = html;
            }

            window.focusDriver = function (id) {
                if (placemarks[id]) {
                    map.setCenter(placemarks[id].geometry.getCoordinates(), 15, {duration: 300});
                    placemarks[id].balloon.open();
                }
            };

            function boot() {
                if (typeof ymaps === 'undefined') return;
                ymaps.ready(init);
            }

            if (document.readyState === 'complete') boot();
            else window.addEventListener('load', boot);
        })();
    </script>
@endsection

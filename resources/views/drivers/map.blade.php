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

        .mode-tabs { display: flex; gap: 8px; margin-bottom: 10px; }
        .mode-tab {
            flex: 1; border: 1px solid #e6e9f0; background: #fff; border-radius: 10px;
            padding: 9px 0; font-size: 13px; font-weight: 600; color: #5f6b80; cursor: pointer;
        }
        .mode-tab.active { background: #1D4ED8; border-color: #1D4ED8; color: #fff; }

        .dl-input {
            display: flex; align-items: center; background: #fff; border: 1px solid #e6e9f0;
            border-radius: 12px; padding: 0 12px; margin-bottom: 10px;
        }
        .dl-input i { width: 16px; height: 16px; color: #2563EB; }
        .dl-input input { border: 0; outline: 0; background: transparent; height: 42px; width: 100%; padding-left: 10px; font-size: 14px; }

        .dl-filters { display: flex; gap: 8px; margin-bottom: 12px; }
        .dl-filter {
            flex: 1; border: 1px solid #e6e9f0; background: #fff; border-radius: 10px; padding: 7px 0;
            font-size: 12.5px; font-weight: 600; color: #5f6b80; cursor: pointer;
        }
        .dl-filter.active { background: #1D4ED8; border-color: #1D4ED8; color: #fff; }
        .dl-filter .cnt { display: inline-block; min-width: 18px; font-size: 11px; opacity: .8; }

        .driver-list { max-height: calc(100vh - 380px); overflow-y: auto; padding-right: 2px; }
        .driver-card {
            background: #fff; border: 1px solid #eef1f5; border-radius: 12px; padding: 12px;
            margin-bottom: 10px; transition: box-shadow .15s ease;
        }
        .driver-card:hover { box-shadow: 0 10px 24px -14px rgba(11, 31, 58, .4); }
        .driver-card .dc-head { display: flex; align-items: center; gap: 8px; }
        .driver-card .dc-name { font-weight: 600; color: #0B1F3A; flex: 1; cursor: pointer; }
        .driver-card .dc-meta { font-size: 12px; color: #8a93a6; margin-top: 4px; margin-left: 18px; }
        .driver-card .dc-actions { display: flex; gap: 8px; margin-top: 10px; margin-left: 18px; }
        .dc-km {
            display: inline-flex; align-items: center; gap: 5px; background: #EAF1FF; color: #1D4ED8;
            font-size: 12px; font-weight: 600; padding: 3px 10px; border-radius: 8px;
        }
        .dc-track-btn {
            border: 0; background: #1D4ED8; color: #fff; font-size: 12px; font-weight: 600;
            padding: 4px 12px; border-radius: 8px; cursor: pointer;
        }

        .status-dot { width: 10px; height: 10px; border-radius: 50%; display: inline-block; }
        .status-dot.on { background: #16B981; }
        .status-dot.off { background: #9aa7b8; }

        .track-banner { background: #EAF1FF; border: 1px solid #c9ddfb; border-radius: 12px; padding: 12px; margin-bottom: 10px; }
        .track-banner .tb-name { font-weight: 600; color: #0B1F3A; }
        .track-banner .tb-info { font-size: 12px; color: #5f6b80; margin-top: 3px; }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row align-items-center mb-3">
            <div class="col"><h4 class="mb-0">{{ __('messages.drivers_map_title') }}</h4></div>
        </div>

        <div class="row">
            <div class="col-lg-3 mb-3">
                <div class="mode-tabs">
                    <button type="button" class="mode-tab active" data-mode="drivers">{{ __('messages.drivers') }}</button>
                    <button type="button" class="mode-tab" data-mode="clients">{{ __('messages.clients_word') }}</button>
                </div>

                {{-- Drivers panel --}}
                <div id="drivers-panel">
                    <div class="dl-input">
                        <i data-feather="calendar"></i>
                        <input type="date" id="track-date" value="{{ now()->toDateString() }}">
                    </div>

                    <div class="dl-input">
                        <i data-feather="search"></i>
                        <input type="text" id="driver-search" placeholder="{{ __('messages.search_driver') }}">
                    </div>

                    <div class="dl-filters">
                        <button type="button" class="dl-filter active" data-filter="all">{{ __('messages.all') }} <span class="cnt" id="cnt-all">0</span></button>
                        <button type="button" class="dl-filter" data-filter="online">{{ __('messages.online') }} <span class="cnt" id="cnt-online">0</span></button>
                        <button type="button" class="dl-filter" data-filter="offline">{{ __('messages.offline') }} <span class="cnt" id="cnt-offline">0</span></button>
                    </div>

                    {{-- Track banner (shown while viewing a track) --}}
                    <div class="track-banner" id="track-banner" style="display:none">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <div class="tb-name" id="track-name"></div>
                                <div class="tb-info" id="track-info"></div>
                            </div>
                            <button type="button" class="btn btn-sm btn-success" onclick="backToLive()">
                                <i class="fas fa-broadcast-tower me-1"></i>{{ __('messages.live') }}
                            </button>
                        </div>
                        <div class="tb-info text-danger mt-1" id="track-empty" style="display:none">{{ __('messages.no_track') }}</div>
                    </div>

                    <div class="driver-list" id="driver-list"></div>
                </div>

                {{-- Clients panel --}}
                <div id="clients-panel" style="display:none">
                    <div class="text-muted small p-2">
                        <i data-feather="map-pin"></i>
                        <span id="clients-count">0</span> {{ __('messages.clients_word') }}
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <div id="drivers-map"></div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://api-maps.yandex.ru/2.1/?apikey={{ env('YANDEX_MAPS_KEY') }}&lang=ru_RU" type="text/javascript"></script>
    <script>
        (function () {
            var map;
            var driverPM = {}, clientClusterer = null, trackObjects = [], allDrivers = [], pollTimer = null;
            var state = {mode: 'drivers', filter: 'all', search: '', date: '{{ now()->toDateString() }}', trackId: null};

            var locationsUrl = "{{ route('drivers.locations') }}";
            var clientsUrl = "{{ route('drivers.clients') }}";
            var trackUrlTpl = "{{ route('drivers.track', ['id' => '__ID__']) }}";
            var lastSeenLabel = "{{ __('messages.last_seen') }}";
            var kmLabel = "{{ __('messages.km_today') }}";
            var trackLabel = "{{ __('messages.track') }}";
            var emptyLabel = "{{ __('messages.no_drivers_online') }}";

            function get(url) {
                return fetch(url, {headers: {'X-Requested-With': 'XMLHttpRequest'}, credentials: 'same-origin'}).then(function (r) { return r.json(); });
            }

            function init() {
                map = new ymaps.Map('drivers-map', {
                    center: [39.767, 64.421], zoom: 12,
                    controls: ['zoomControl', 'geolocationControl', 'fullscreenControl']
                });

                document.querySelectorAll('.mode-tab').forEach(function (t) {
                    t.addEventListener('click', function () { setMode(t.getAttribute('data-mode')); });
                });
                document.getElementById('driver-search').addEventListener('input', function (e) {
                    state.search = (e.target.value || '').toLowerCase(); applyDriverView();
                });
                document.querySelectorAll('.dl-filter').forEach(function (b) {
                    b.addEventListener('click', function () {
                        document.querySelectorAll('.dl-filter').forEach(function (x) { x.classList.remove('active'); });
                        b.classList.add('active'); state.filter = b.getAttribute('data-filter'); applyDriverView();
                    });
                });
                document.getElementById('track-date').addEventListener('change', function (e) {
                    state.date = e.target.value;
                    if (state.trackId) showTrack(state.trackId, document.getElementById('track-name').textContent);
                });

                setMode('drivers');
            }

            function clearLive() { Object.keys(driverPM).forEach(function (id) { map.geoObjects.remove(driverPM[id]); }); driverPM = {}; }
            function clearClients() { if (clientClusterer) { map.geoObjects.remove(clientClusterer); clientClusterer = null; } }
            function clearTrack() { trackObjects.forEach(function (o) { map.geoObjects.remove(o); }); trackObjects = []; }
            function stopPoll() { if (pollTimer) { clearInterval(pollTimer); pollTimer = null; } }

            function setMode(mode) {
                state.mode = mode; state.trackId = null;
                clearLive(); clearClients(); clearTrack(); stopPoll();

                document.querySelectorAll('.mode-tab').forEach(function (t) { t.classList.toggle('active', t.getAttribute('data-mode') === mode); });
                document.getElementById('drivers-panel').style.display = mode === 'drivers' ? '' : 'none';
                document.getElementById('clients-panel').style.display = mode === 'clients' ? '' : 'none';
                document.getElementById('track-banner').style.display = 'none';

                if (mode === 'drivers') { loadLive(); pollTimer = setInterval(loadLive, 12000); }
                else { loadClients(); }
            }

            // ---- Drivers (live) ----
            function loadLive() {
                get(locationsUrl).then(function (drivers) { allDrivers = drivers || []; updateCounts(); applyDriverView(); }).catch(function () { });
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
            function preset(online) { return online ? 'islands#greenDotIconWithCaption' : 'islands#grayDotIconWithCaption'; }
            function balloon(d) {
                return '<strong>' + d.name + '</strong>' + (d.organization ? '<br><small style="color:#888">' + d.organization + '</small>' : '') +
                    '<br>' + (d.phone || '') + '<br>' + lastSeenLabel + ': ' + (d.last_location_at || '-') + '<br>' + (d.km_today || 0) + ' ' + kmLabel;
            }
            function applyDriverView() {
                if (state.mode !== 'drivers' || state.trackId) return;
                var vis = visible(), ids = {}, coords = [];
                vis.forEach(function (d) {
                    ids[d.id] = true; coords.push([d.lat, d.lng]);
                    if (driverPM[d.id]) { driverPM[d.id].geometry.setCoordinates([d.lat, d.lng]); }
                    else {
                        var pm = new ymaps.Placemark([d.lat, d.lng], {iconCaption: d.name, balloonContent: balloon(d)}, {preset: preset(d.online)});
                        map.geoObjects.add(pm); driverPM[d.id] = pm;
                    }
                    driverPM[d.id].options.set('preset', preset(d.online));
                    driverPM[d.id].properties.set('balloonContent', balloon(d));
                });
                Object.keys(driverPM).forEach(function (id) { if (!ids[id]) { map.geoObjects.remove(driverPM[id]); delete driverPM[id]; } });
                renderList(vis);
            }
            function renderList(drivers) {
                var box = document.getElementById('driver-list');
                if (!drivers.length) { box.innerHTML = '<div class="text-muted p-3 text-center">' + emptyLabel + '</div>'; return; }
                var html = '';
                drivers.forEach(function (d) {
                    html += '<div class="driver-card">' +
                        '<div class="dc-head"><span class="status-dot ' + (d.online ? 'on' : 'off') + '"></span>' +
                        '<span class="dc-name" onclick="focusDriver(' + d.id + ')">' + d.name + '</span></div>' +
                        (d.organization ? '<div class="dc-meta">' + d.organization + '</div>' : '') +
                        '<div class="dc-meta">' + (d.phone || '') + ' · ' + (d.last_location_at || '-') + '</div>' +
                        '<div class="dc-actions">' +
                        '<span class="dc-km"><i class="fas fa-route"></i>' + (d.km_today || 0) + ' ' + kmLabel + '</span>' +
                        '<button class="dc-track-btn" onclick="showTrack(' + d.id + ',\'' + (d.name || '').replace(/'/g, '') + '\')"><i class="fas fa-map-signs me-1"></i>' + trackLabel + '</button>' +
                        '</div></div>';
                });
                box.innerHTML = html;
            }
            window.focusDriver = function (id) {
                if (driverPM[id]) { map.setCenter(driverPM[id].geometry.getCoordinates(), 15, {duration: 300}); driverPM[id].balloon.open(); }
            };

            // ---- Clients ----
            function loadClients() {
                get(clientsUrl).then(function (clients) {
                    var marks = (clients || []).map(function (c) {
                        return new ymaps.Placemark([c.lat, c.lng], {
                            balloonContentHeader: c.fullname,
                            balloonContentBody: (c.phone ? ('☎ +998' + c.phone + '<br>') : '') + 'Balans: ' + (c.balance || 0) + '<br>Idish: ' + (c.container || 0),
                            hintContent: c.fullname
                        }, {preset: 'islands#blueIcon'});
                    });
                    clientClusterer = new ymaps.Clusterer({preset: 'islands#invertedBlueClusterIcons', groupByCoordinates: false});
                    clientClusterer.add(marks);
                    map.geoObjects.add(clientClusterer);
                    document.getElementById('clients-count').textContent = marks.length;
                    if (marks.length) { try { map.setBounds(clientClusterer.getBounds(), {checkZoomRange: true, zoomMargin: 40}); } catch (e) { } }
                }).catch(function () { });
            }

            // ---- Track ----
            window.showTrack = function (id, name) {
                state.trackId = id; stopPoll(); clearLive(); clearClients(); clearTrack();
                document.getElementById('track-banner').style.display = '';
                document.getElementById('track-name').textContent = name;
                document.getElementById('track-info').textContent = '';
                document.getElementById('track-empty').style.display = 'none';

                var url = trackUrlTpl.replace('__ID__', id) + '?date=' + encodeURIComponent(state.date);
                get(url).then(function (t) {
                    var pts = (t.points || []).map(function (p) { return [p.lat, p.lng]; });
                    document.getElementById('track-info').textContent = (t.date || '') + ' · ' + (t.km || 0) + ' km · ' + pts.length;
                    if (!pts.length) { document.getElementById('track-empty').style.display = ''; return; }

                    var line = new ymaps.Polyline(pts, {}, {strokeColor: '#2563EB', strokeWidth: 4, strokeOpacity: 0.85});
                    var start = new ymaps.Placemark(pts[0], {hintContent: 'Start'}, {preset: 'islands#greenCircleDotIcon'});
                    var end = new ymaps.Placemark(pts[pts.length - 1], {hintContent: name}, {preset: 'islands#redCircleDotIcon'});
                    trackObjects = [line, start, end];
                    trackObjects.forEach(function (o) { map.geoObjects.add(o); });
                    try { map.setBounds(line.geometry.getBounds(), {checkZoomRange: true, zoomMargin: 40}); } catch (e) { }
                }).catch(function () { });
            };

            window.backToLive = function () { setMode('drivers'); };

            function boot() { if (typeof ymaps === 'undefined') return; ymaps.ready(init); }
            if (document.readyState === 'complete') boot(); else window.addEventListener('load', boot);
        })();
    </script>
@endsection

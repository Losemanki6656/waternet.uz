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

        .driver-list .driver-card {
            cursor: pointer;
            border: 1px solid #eef1f5;
            border-radius: 12px;
            transition: box-shadow .15s ease;
        }

        .driver-list .driver-card:hover {
            box-shadow: 0 8px 20px -12px rgba(11, 31, 58, .35);
        }

        .driver-list {
            max-height: calc(100vh - 200px);
            overflow-y: auto;
        }

        .status-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 7px;
        }

        .status-dot.on {
            background: #16B981;
        }

        .status-dot.off {
            background: #9aa7b8;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row align-items-center mb-3">
            <div class="col">
                <h4 class="mb-0">{{ __('messages.drivers_map_title') }}</h4>
            </div>
            <div class="col-auto">
                <span class="text-muted small"><span class="status-dot on"></span>{{ __('messages.online') }}
                    &nbsp;&nbsp;<span class="status-dot off"></span>{{ __('messages.offline') }}</span>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3 mb-3">
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
            var map, placemarks = {};
            var locationsUrl = "{{ route('drivers.locations') }}";
            var lastSeenLabel = "{{ __('messages.last_seen') }}";
            var emptyLabel = "{{ __('messages.no_drivers_online') }}";
            var firstFit = true;

            function init() {
                map = new ymaps.Map('drivers-map', {
                    center: [41.311081, 69.240562],
                    zoom: 11,
                    controls: ['zoomControl', 'geolocationControl', 'fullscreenControl']
                });

                load();
                setInterval(load, 12000);
            }

            function load() {
                fetch(locationsUrl, {headers: {'X-Requested-With': 'XMLHttpRequest'}, credentials: 'same-origin'})
                    .then(function (r) { return r.json(); })
                    .then(render)
                    .catch(function () { });
            }

            function preset(online) {
                return online ? 'islands#greenDotIconWithCaption' : 'islands#grayDotIconWithCaption';
            }

            function balloon(d) {
                return '<strong>' + d.name + '</strong><br>' + (d.phone || '') +
                    '<br>' + lastSeenLabel + ': ' + (d.last_location_at || '-');
            }

            function render(drivers) {
                renderList(drivers);

                var seen = {};
                var coordsList = [];

                drivers.forEach(function (d) {
                    seen[d.id] = true;
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
                    if (!seen[id]) {
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
                    box.innerHTML = '<div class="text-muted p-3">' + emptyLabel + '</div>';
                    return;
                }

                var html = '';
                drivers.forEach(function (d) {
                    html += '<div class="driver-card p-2 mb-2" onclick="focusDriver(' + d.id + ')">' +
                        '<div><span class="status-dot ' + (d.online ? 'on' : 'off') + '"></span>' +
                        '<strong>' + d.name + '</strong></div>' +
                        '<div class="text-muted small ms-3">' + (d.phone || '') + '</div>' +
                        '<div class="text-muted small ms-3">' + (d.last_location_at || '-') + '</div>' +
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

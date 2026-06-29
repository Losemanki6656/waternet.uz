<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $locations[0] ?? 'Location' }}</title>
    <style>
        html, body { margin: 0; padding: 0; height: 100%; }
        #map { width: 100%; height: 100vh; }
        .loc-label {
            background: #1D4ED8; color: #fff; font: 600 13px/1 -apple-system, Segoe UI, sans-serif;
            padding: 7px 12px; border-radius: 10px; white-space: nowrap;
            box-shadow: 0 6px 16px -6px rgba(11,31,58,.5); transform: translateY(-6px);
        }
    </style>
</head>

<body>
    <div id="map"></div>

<script>
    function initialize() {
        var locations = [@json($locations)];

        window.map = new google.maps.Map(document.getElementById('map'), {
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            zoom: 16,
            gestureHandling: 'greedy',
            streetViewControl: false,
            mapTypeControl: false,
            fullscreenControl: true
        });

        // Big, clear teardrop pin with a white centre dot.
        var pinSvg =
            '<svg xmlns="http://www.w3.org/2000/svg" width="54" height="72" viewBox="0 0 54 72">' +
            '<path d="M27 0C12.1 0 0 12.1 0 27c0 19.5 27 45 27 45s27-25.5 27-45C54 12.1 41.9 0 27 0z" ' +
            'fill="#1D4ED8" stroke="#ffffff" stroke-width="3"/>' +
            '<circle cx="27" cy="27" r="10" fill="#ffffff"/>' +
            '<circle cx="27" cy="27" r="4.5" fill="#1D4ED8"/></svg>';

        var icon = {
            url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(pinSvg),
            scaledSize: new google.maps.Size(54, 72),
            anchor: new google.maps.Point(27, 72)
        };

        var bounds = new google.maps.LatLngBounds();
        var infowindow = new google.maps.InfoWindow();
        var first = null;

        for (var i = 0; i < locations.length; i++) {
            var pos = new google.maps.LatLng(Number(locations[i][1]), Number(locations[i][2]));
            if (!first) first = pos;

            var marker = new google.maps.Marker({
                position: pos,
                map: map,
                icon: icon,
                title: locations[i][0],
                animation: google.maps.Animation.DROP
            });

            // Emphasis circle around the client.
            new google.maps.Circle({
                map: map, center: pos, radius: 60,
                strokeColor: '#1D4ED8', strokeOpacity: 0.5, strokeWeight: 1,
                fillColor: '#1D4ED8', fillOpacity: 0.12
            });

            bounds.extend(pos);

            google.maps.event.addListener(marker, 'click', (function (marker, i) {
                return function () {
                    infowindow.setContent('<div class="loc-label">' + locations[i][0] + '</div>');
                    infowindow.open(map, marker);
                };
            })(marker, i));

            if (i === 0) {
                infowindow.setContent('<div class="loc-label">' + locations[i][0] + '</div>');
                infowindow.open(map, marker);
            }
        }

        if (locations.length > 1) {
            map.fitBounds(bounds);
            var listener = google.maps.event.addListener(map, "idle", function () {
                if (map.getZoom() > 17) map.setZoom(17);
                google.maps.event.removeListener(listener);
            });
        } else if (first) {
            map.setCenter(first);
            map.setZoom(16);
        }
    }

    function loadScript() {
        var script = document.createElement('script');
        script.type = 'text/javascript';
        script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyCWdCZwISLuqFF-IBrtdeWCHyAkL-qJH4k&v=3.exp&sensor=false&' + 'callback=initialize';
        document.body.appendChild(script);
    }

    window.onload = loadScript;
</script>

</body>
</html>

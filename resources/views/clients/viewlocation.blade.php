<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div id="map" style="width: 100%; height: 100vh;"></div>
    <!-- <button type="button" id="test" onclick="map.setZoom(5)">TEST</button> -->
</body>

<script>
    function initialize() {
        var locations = [@json($locations)];

        window.map = new google.maps.Map(document.getElementById('map'), {
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        var infowindow = new google.maps.InfoWindow();

        var bounds = new google.maps.LatLngBounds();

        for (i = 0; i < locations.length; i++) {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                map: map
            });

            bounds.extend(marker.position);

            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    infowindow.setContent(locations[i][0]);
                    infowindow.open(map, marker);
                }
            })(marker, i));
        }

        map.fitBounds(bounds);

        var listener = google.maps.event.addListener(map, "idle", function() {
            map.setZoom(15);
            google.maps.event.removeListener(listener);
        });
    }

    function loadScript() {
        var script = document.createElement('script');
        script.type = 'text/javascript';
        script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyCWdCZwISLuqFF-IBrtdeWCHyAkL-qJH4k&v=3.exp&sensor=false&' + 'callback=initialize';
        document.body.appendChild(script);
    }

    window.onload = loadScript;
</script>

</html>


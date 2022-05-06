
<!DOCTYPE html>
<html>

<head>
    <title>Location</title>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script src="./index.js"></script>
    <style>
        #map {
            height: 100vh;
            width: 100%;
        }
        
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        
        #pac-input {
            padding: 10px;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-shadow: 0px 1px 1px rgb(0, 0, 0, 0.3);
        }
    </style>
</head>

<body>
    <input id="pac-input" class="controls" type="text" placeholder="Search ... " />
    <div id="map"></div>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCWdCZwISLuqFF-IBrtdeWCHyAkL-qJH4k&callback=initMap&libraries=&v=weekly&&libraries=places" async></script>
</body>

<script>
    function initMap() {

        const myLatlng = {
            lat: 39.72137252830563,
            lng: 64.53869625420622
        };
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 14,
            center: myLatlng,
        });


        const input = document.getElementById("pac-input");
        const searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        map.addListener("bounds_changed", () => {
            searchBox.setBounds(map.getBounds());
        });
        let markers = [];

        searchBox.addListener("places_changed", () => {
            const places = searchBox.getPlaces();

            if (places.length == 0) {
                return;
            }

            markers.forEach((marker) => {
                marker.setMap(null);
            });
            markers = [];

            const bounds = new google.maps.LatLngBounds();
            places.forEach((place) => {
                if (!place.geometry || !place.geometry.location) {
                    console.log("Returned place contains no geometry");
                    return;
                }

                const icon = {
                    url: place.icon,
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(25, 25),
                };

                markers.push(
                    new google.maps.Marker({
                        map,
                        icon,
                        title: place.name,
                        position: place.geometry.location,
                    })
                );
                
            marker.setMap(map);

                if (place.geometry.viewport) {
                    
                    bounds.union(place.geometry.viewport);
                } else {
                    bounds.extend(place.geometry.location);
                }
            });
            map.fitBounds(bounds);
        });

        let infoWindow = new google.maps.InfoWindow({
            content: "Marker",
            position: myLatlng,
        });
        infoWindow.open(map);
        
        map.addListener("click", (mapsMouseEvent) => {
            console.log(mapsMouseEvent.latLng.lat(), mapsMouseEvent.latLng.lng())
            infoWindow.close();
            infoWindow = new google.maps.InfoWindow({
                position: mapsMouseEvent.latLng,
            });
            infoWindow.setContent(
                JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2)
            );
            infoWindow.open(map);

            if (confirm("Do you want to mark this location?")){
                //console.log({!! $id_client !!});
                window.opener.document.getElementById("location" + {!! $id_client !!}).value = mapsMouseEvent.latLng.lat() + "," + mapsMouseEvent.latLng.lng();

                window.opener.document.getElementById("select_location" + {!! $id_client !!}).classList.remove("btn-warning");
                window.opener.document.getElementById("select_location" + {!! $id_client !!}).classList.add("btn-success");

                window.opener.document.getElementById("select_location" + {!! $id_client !!}).innerText="Selected location!"
                window.close()
    }
        });
    }
</script>

</html>
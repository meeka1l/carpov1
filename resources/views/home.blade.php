<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Carpo</title>
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap" async defer></script>
    <style>
        nav {
            background-color: white;
            overflow: hidden;
        }

        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        nav ul a {
            display: inline-block;
            color: black;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            background-color: white;
            transition: background-color 0.1s, color 0.1s, font-weight 0.1s;
            flex: 1;
        }

        nav ul a:hover {
            color: black;
        }

        nav ul a.active {
            font-weight: bold;
        }

        nav ul a:not(.active) {
            opacity: 0.6;
        }

        #map {
            height: 400px;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <header class="header">
            <h1>CARPO</h1>
            <h2>Welcome to CARPO</h2>
            <nav>
                <ul>
                    <a href="#" id="show-navigator" >Navigator Mode</a>
                    <a href="#" id="show-commuter"class="active">Commuter Mode</a>
                </ul>
            </nav>
        </header>

        <!-- Navigator Page Section -->
        <section class="navigator-page" id="navigator-page" style="display: none;">
            <h2>Share Your Ride</h2>
            <form action="{{ route('rides.store') }}" method="POST">
                @csrf
                <label for="vehicle_number">Vehicle Number:</label>
                <input type="text" id="vehicle_number" name="vehicle_number" required>
                <br>
                <label for="vehicle_color">Vehicle Color:</label>
                <input type="text" id="vehicle_color" name="vehicle_color" required>
                <br>
                <label for="vehicle_model">Vehicle Model:</label>
                <input type="text" id="vehicle_model" name="vehicle_model" required>
                <br>
                <label for="start_location">Start Location:</label>
                <input type="text" id="start_location" name="start_location" required readonly>
                <br>
                <label for="end_location">End Location:</label>
                <input type="text" id="end_location" name="end_location" required readonly>
                <br>
                <button type="submit">Share Ride</button>
            </form>
            <div id="map" style="height: 500px;"></div>
        </section>

        <!-- Commuter Page Section -->
        <section class="commuter-page" id="commuter-page">
            <h2>Available Rides</h2>
            <ul>
                @foreach($rides as $ride)
                    <li>
                        Vehicle: {{ $ride->vehicle_model }} ({{ $ride->vehicle_number }})<br>
                        Color: {{ $ride->vehicle_color }}<br>
                        Start: {{ $ride->start_location }}<br>
                        End: {{ $ride->end_location }}<br>
                        <form action="{{ route('rides.join') }}" method="POST">
                            @csrf
                            <input type="hidden" name="ride_id" value="{{ $ride->id }}">
                            <input type="hidden" id="pickup_location_{{ $ride->id }}" name="pickup_location" required>
                            <button type="submit" onclick="setPickupLocation({{ $ride->id }})">Join Ride</button>
                        </form>
                    </li>
                @endforeach
            </ul>
            <div id="map"></div>
        </section>

        <!-- Logout Form -->
        <form action="{{ route('logout') }}" method="POST" style="text-align: center; margin-top: 20px;">
            @csrf
            <button type="submit" class="logout-button">Logout</button>
        </form>
    </div>

    <script>document.addEventListener('DOMContentLoaded', function() {
    const navigatorLink = document.getElementById('show-navigator');
    const commuterLink = document.getElementById('show-commuter');
    const navigatorPage = document.getElementById('navigator-page');
    const commuterPage = document.getElementById('commuter-page');
    let map, startMarker, endMarker, mode;

    // Default view
    navigatorPage.style.display = 'none';
    commuterPage.style.display = 'block';

    navigatorLink.addEventListener('click', function(event) {
        event.preventDefault();
        navigatorPage.style.display = 'block';
        commuterPage.style.display = 'none';
        initMap('navigator');
    });

    commuterLink.addEventListener('click', function(event) {
        event.preventDefault();
        commuterPage.style.display = 'block';
        navigatorPage.style.display = 'none';
        initMap('commuter');
    });

    function initMap(currentMode) {
        mode = currentMode;
        const defaultLocation = { lat: -34.397, lng: 150.644 };
        map = new google.maps.Map(document.getElementById('map'), {
            center: defaultLocation,
            zoom: 8,
        });

        // Find user's current location and center the map
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude,
                    };
                    map.setCenter(pos);
                },
                () => {
                    handleLocationError(true, map.getCenter());
                }
            );
        } else {
            // Browser doesn't support Geolocation
            handleLocationError(false, map.getCenter());
        }

        startMarker = new google.maps.Marker({
            position: defaultLocation,
            map: map,
            draggable: true,
            label: 'S'
        });

        endMarker = new google.maps.Marker({
            position: defaultLocation,
            map: map,
            draggable: true,
            label: 'E'
        });

        const geocoder = new google.maps.Geocoder();
        const infoWindow = new google.maps.InfoWindow();

        startMarker.addListener('dragend', (event) => {
            updateLocationInput(event.latLng, 'start');
            geocodeLatLng(geocoder, event.latLng, infoWindow, startMarker, 'start');
        });

        endMarker.addListener('dragend', (event) => {
            updateLocationInput(event.latLng, 'end');
            geocodeLatLng(geocoder, event.latLng, infoWindow, endMarker, 'end');
        });

        map.addListener('click', (event) => {
            if (mode === 'navigator') {
                placeMarker(event.latLng);
            } else if (mode === 'commuter') {
                placePickupMarker(event.latLng);
            }
        });

        document.getElementById('submit').addEventListener('click', () => {
            const latlngStr = document.getElementById('start_location').value.split(',', 2);
            const latlng = {
                lat: parseFloat(latlngStr[0]),
                lng: parseFloat(latlngStr[1]),
            };
            geocodeLatLng(geocoder, latlng, infoWindow, startMarker, 'start');
        });
    }

    async function geocodeLatLng(geocoder, latlng, infoWindow, marker, type) {
        try {
            const response = await geocoder.geocode({ location: latlng });
            const address = response.results[0].formatted_address;
            infoWindow.setContent(address);
            infoWindow.open({
                anchor: marker,
                map,
                shouldFocus: false,
            });

            if (type === 'start') {
                document.getElementById('start_location').value = address;
            } else if (type === 'end') {
                document.getElementById('end_location').value = address;
            }
        } catch (e) {
            window.alert(`Geocoder failed due to: ${e}`);
        }
    }

    function placeMarker(location) {
        if (!startMarker.getPosition() || startMarker.getPosition().equals(endMarker.getPosition())) {
            startMarker.setPosition(location);
            updateLocationInput(location, 'start');
            geocodeLatLng(new google.maps.Geocoder(), location, new google.maps.InfoWindow(), startMarker, 'start');
        } else {
            endMarker.setPosition(location);
            updateLocationInput(location, 'end');
            geocodeLatLng(new google.maps.Geocoder(), location, new google.maps.InfoWindow(), endMarker, 'end');
        }
    }

    function placePickupMarker(location) {
        const rideId = getActiveRideId();
        const pickupMarker = new google.maps.Marker({
            position: location,
            map: map,
            draggable: true,
            label: 'P'
        });
        pickupMarker.addListener('dragend', (event) => {
            updatePickupLocationInput(event.latLng, rideId);
            geocodeLatLng(new google.maps.Geocoder(), event.latLng, new google.maps.InfoWindow(), pickupMarker);
        });
        updatePickupLocationInput(location, rideId);
        geocodeLatLng(new google.maps.Geocoder(), location, new google.maps.InfoWindow(), pickupMarker);
    }

    function updateLocationInput(location, type) {
        if (type === 'start') {
            document.getElementById('start_location').value = location.lat() + ',' + location.lng();
        } else if (type === 'end') {
            document.getElementById('end_location').value = location.lat() + ',' + location.lng();
        }
    }

    function updatePickupLocationInput(location, rideId) {
        document.getElementById(`pickup_location_${rideId}`).value = location.lat() + ',' + location.lng();
    }

    function getActiveRideId() {
        const activeButton = document.querySelector('.commuter-page button.active');
        return activeButton ? activeButton.dataset.rideId : null;
    }

    function handleLocationError(browserHasGeolocation, pos) {
        const infoWindow = new google.maps.InfoWindow({
            position: pos,
        });
        infoWindow.setContent(
            browserHasGeolocation
                ? "Error: The Geolocation service failed."
                : "Error: Your browser doesn't support geolocation."
        );
        infoWindow.open(map);
    }

    document.querySelectorAll('nav ul a').forEach(item => {
        item.addEventListener('click', event => {
            document.querySelectorAll('nav ul a').forEach(link => {
                link.classList.remove('active');
            });
            event.target.classList.add('active');
        });
    });
});

window.initMap = initMap;

    </script>
</body>
</html>

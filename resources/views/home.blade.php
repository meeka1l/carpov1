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

        #map.disabled {
            pointer-events: none; /* Disable interaction */
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
                    <a href="#" id="show-navigator">Navigator Mode</a>
                    <a href="#" id="show-rides">Ride Matches</a>
                    <a href="#" id="show-commuter" class="active">Commuter Mode</a>             
                </ul>
            </nav>
        </header>

        <!-- Navigator Page Section -->
        <section class="navigator-page" id="navigator-page" style="display: none;">
            <h2>Share Your Ride</h2>
            <form action="{{ route('rides.store') }}" method="post">
                @csrf
                

                <label><input type="checkbox" id="from-apiit"> From APIIT</label>
                <label><input type="checkbox" id="to-apiit"> To APIIT</label>
                <br>

                <label for="vehicle_number">Vehicle Number:</label>
                <input type="text" id="vehicle_number" name="vehicle_number" required>
                <br>
                <label for="vehicle_color">Vehicle Color:</label>
                <input type="text" id="vehicle_color" name="vehicle_color" required>
                <br>
                <label for="vehicle_model">Vehicle Model:</label>
                <input type="text" id="vehicle_model" name="vehicle_model" required>
                <br>
                <label for="description">Ride Description:</label>
                <input type="text" id="description" name="description" required>
                <br>

        <label for="start_location">Start Location:</label>
        <gmpx-place-picker id="place-picker" for-map="map"></gmpx-place-picker>             
        <input type="text" id="start_location" name="start_location" required readonly onclick="toggleDropdown('start_location')">

        <select id="start_location_dropdown" name="start_location_dropdown" style="display: none;" required onchange="updateLocation('start_location')">
            <option disabled selected>Select</option>
            <option value="6.918688426614458,79.8612400882712">Location 1</option>
            <option value="6.920275317391224,79.85747472886152">Location 2</option>
        </select>
        <br>

        <label for="end_location">End Location:</label>
        <gmpx-place-picker id="place-picker" for-map="map"></gmpx-place-picker>
        <input type="text" id="end_location" name="end_location" required readonly onclick="toggleDropdown('end_location')">

        <select id="end_location_dropdown" name="end_location_dropdown" style="display: none;" required onchange="updateLocation('end_location')">
            <option disabled selected>Select</option>
            <option value="6.918688426614458,79.8612400882712">Location 1</option>
            <option value="6.920275317391224,79.85747472886152">Location 2</option>
        </select>
        <br>
        
              <button type="submit" id="shareride">Share Ride</button>
            </form>
            <div id="map" class="disabled"></div>
        </section>

        <!-- Commuter Page Section -->
        <section class="commuter-page" id="commuter-page">
          @include('rides')
        </section>
        
        <!-- Rides Page Section -->
        <section class="rides-page" id="rides-page">
        @include('test')
        <a href="{{ route('ridematch') }}" class="btn btn-primary">View Ride Match</a>
        </section>

        <!-- Logout Form -->
        <form action="{{ route('logout') }}" method="POST" style="text-align: center; margin-top: 20px;">
            @csrf
            <button type="submit" class="logout-button">Logout</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navigatorLink = document.getElementById('show-navigator');
            const commuterLink = document.getElementById('show-commuter');
            const ridesLink = document.getElementById('show-rides');
            const navigatorPage = document.getElementById('navigator-page');
            const commuterPage = document.getElementById('commuter-page');
            const ridesPage = document.getElementById('rides-page');
            
            let map, startMarker, endMarker;
            let canSelectStart = false;
            let canSelectEnd = false;

            navigatorPage.style.display = 'none';
            ridesPage.style.display = 'none';
            commuterPage.style.display = 'block';


            function toggleActiveClass(currentLink) {
                navigatorLink.classList.remove('active');
                commuterLink.classList.remove('active');
                ridesLink.classList.remove('active');
                currentLink.classList.add('active');
            }

            navigatorLink.addEventListener('click', function(event) {
                event.preventDefault();
                navigatorPage.style.display = 'block';
                commuterPage.style.display = 'none';
                ridesPage.style.display = 'none';
                toggleActiveClass(navigatorLink);
                initMap('navigator');
            });

            commuterLink.addEventListener('click', function(event) {
                event.preventDefault();
                commuterPage.style.display = 'block';
                navigatorPage.style.display = 'none';
                ridesPage.style.display = 'none';
                toggleActiveClass(commuterLink);
                initMap('commuter');
            });
            
            ridesLink.addEventListener('click', function(event) {
                event.preventDefault();
                commuterPage.style.display = 'none';
                navigatorPage.style.display = 'none';
                ridesPage.style.display = 'block';
                toggleActiveClass(ridesLink);
                initMap('rides');
            });

            function initMap(currentMode) {
                const defaultLocation = { lat: -34.397, lng: 150.644 };
                map = new google.maps.Map(document.getElementById('map'), {
                    center: defaultLocation,
                    zoom: 8,
                });

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

                // Disable map clicks until dropdown is selected
                map.addListener('click', (event) => {
                    if (canSelectStart) {
                        startMarker.setPosition(event.latLng);
                        updateLocationInput(event.latLng, 'start');
                        geocodeLatLng(geocoder, event.latLng, infoWindow, startMarker, 'start');
                    } else if (canSelectEnd) {
                        endMarker.setPosition(event.latLng);
                        updateLocationInput(event.latLng, 'end');
                        geocodeLatLng(geocoder, event.latLng, infoWindow, endMarker, 'end');
                    }
                });

                // Initialize the dropdowns state
                toggleDropdowns();
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
                    window.alert(`Geocode failed: ${e}`);
                }
            }

            function updateLocationInput(location, type) {
                const lat = location.lat();
                const lng = location.lng();
                if (type === 'start') {
                    document.getElementById('start_location').value = `${lat},${lng}`;
                } else if (type === 'end') {
                    document.getElementById('end_location').value = `${lat},${lng}`;
                }
            }

            function setPickupLocation(rideId) {
                const pickupInput = document.getElementById('pickup_location_' + rideId);
                if (startMarker.getPosition()) {
                    const location = startMarker.getPosition();
                    pickupInput.value = `${location.lat()},${location.lng()}`;
                }
            }

            function handleLocationError(browserHasGeolocation, pos) {
                const content = browserHasGeolocation
                    ? 'Error: The Geolocation service failed.'
                    : "Error: Your browser doesn't support geolocation.";

                const infoWindow = new google.maps.InfoWindow({
                    content: content,
                    position: pos,
                });
                infoWindow.open(map);
            }

            const fromApiitCheckbox = document.getElementById('from-apiit');
            const toApiitCheckbox = document.getElementById('to-apiit');
            const startLocationInput = document.getElementById('start_location');
            const endLocationInput = document.getElementById('end_location');
            const startLocationDropdown = document.getElementById('start_location_dropdown');
            const endLocationDropdown = document.getElementById('end_location_dropdown');

            function toggleDropdowns() {
                if (fromApiitCheckbox.checked) {
                    startLocationDropdown.style.display = 'block';
                    startLocationInput.style.display = 'none';
                    endLocationDropdown.style.display = 'none';
                    endLocationInput.style.display = 'block';
                    canSelectStart = false;
                    canSelectEnd = true;
                } else if (toApiitCheckbox.checked) {
                    startLocationDropdown.style.display = 'none';
                    startLocationInput.style.display = 'block';
                    endLocationDropdown.style.display = 'block';
                    endLocationInput.style.display = 'none';
                    canSelectStart = true;
                    canSelectEnd = false;
                } else {
                    startLocationDropdown.style.display = 'none';
                    startLocationInput.style.display = 'block';
                    endLocationDropdown.style.display = 'none';
                    endLocationInput.style.display = 'block';
                    canSelectStart = false;
                    canSelectEnd = false;
                }
                updateMapInteraction();
            }

            function updateMapInteraction() {
                const mapElement = document.getElementById('map');
                if (fromApiitCheckbox.checked || toApiitCheckbox.checked) {
                    mapElement.classList.remove('disabled');
                    mapElement.classList.add('active');
                } else {
                    mapElement.classList.remove('active');
                    mapElement.classList.add('disabled');
                }
            }

            fromApiitCheckbox.addEventListener('change', function() {
                toApiitCheckbox.checked = false;
                toggleDropdowns();
            });

            toApiitCheckbox.addEventListener('change', function() {
                fromApiitCheckbox.checked = false;
                toggleDropdowns();
            });

            startLocationDropdown.addEventListener('change', function() {
                const [lat, lng] = startLocationDropdown.value.split(',');
                const location = { lat: parseFloat(lat), lng: parseFloat(lng) };
                startMarker.setPosition(location);
                map.setCenter(location);
                startLocationInput.value = startLocationDropdown.value;
                updateMapInteraction();
            });

            endLocationDropdown.addEventListener('change', function() {
                const [lat, lng] = endLocationDropdown.value.split(',');
                const location = { lat: parseFloat(lat), lng: parseFloat(lng) };
                endMarker.setPosition(location);
                map.setCenter(location);
                endLocationInput.value = endLocationDropdown.value;
                updateMapInteraction();
            });

            document.addEventListener('DOMContentLoaded', function() {
        fetch("{{ route('ridematch') }}")
            .then(response => response.text())
            .then(html => {
                document.getElementById('rides-page').innerHTML = html;
            })
            .catch(error => console.error('Error loading rides:', error));
    });
    // Handle form submission and active class change
    const shareRideForm = document.querySelector('form[action="{{ route('rides.store') }}"]');
    shareRideForm.addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(shareRideForm);

        fetch(shareRideForm.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            }
        })
        .then(response => {
            if (response.ok) {
                return response.text(); // or response.json() depending on your endpoint
            } else {
                throw new Error('Failed to submit form');
            }
        })
        .then(data => {
            // Assuming a successful submission
            navigatorLink.classList.remove('active');
            commuterLink.classList.remove('active');
            ridesLink.classList.add('active');
            commuterPage.style.display = 'none';
            navigatorPage.style.display = 'none';
            ridesPage.style.display = 'block';
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });

          
        });
       
    </script>
</body>
</html>

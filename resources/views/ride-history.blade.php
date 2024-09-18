<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ride History</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Krona+One&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"> <!-- Font Awesome for icons -->
    <style>
        h1 {
            font-family: 'Krona One', sans-serif;
            color: #70d5c3;
        }
        .logo {
            font-size: 2em;
            color: black;
        }    
        .viewbtn {
            background-color: #70d5c3;
            border: none;
            color: white;
        }
        .backbtn {
            background-color: black;
            color: white;
            font-size: 1.2em;
            border: none;
            border-radius: 20px;
            width: 100%;
            margin-bottom: 5%;
            margin-top: 5%;
        }
        .table-container {
            margin-top: 2rem;
            overflow-x: auto;
        }
        .clickable-row {
            cursor: pointer;
        }
        .table {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
        }
        .table thead {
            display: none;
        }
        .table tbody tr {
            display: flex;
            flex-direction: column;
            border-bottom: 1px solid #dee2e6;
            border: 2px solid black;
            border-radius: 5px;
            margin-bottom: 1rem;
            padding: 0.5rem;
            background-color: #f8f9fa;
        }
        .table tbody td {
            display: flex;
            align-items: center; /* Align items vertically center */
            padding: 0.75rem;
            border-bottom: 1px solid #dee2e6;
        }
        .table tbody td::before {
            content: attr(data-label);
            font-weight: bold;
            flex-basis: 40%;
            text-align: left;
        }
        .icon {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mt-5 logo">CARPO</h1>

        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs mt-5" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="ride-history-tab" data-toggle="tab" href="#ride-history" role="tab" aria-controls="ride-history" aria-selected="true">Navigator History</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="commuter-history-tab" data-toggle="tab" href="#commuter-history" role="tab" aria-controls="commuter-history" aria-selected="false">Commuter History</a>
            </li>
        </ul>

        <!-- Tabs Content -->
        <div class="tab-content mt-3" id="myTabContent">
            <!-- Ride History Tab -->
            <div class="tab-pane fade show active" id="ride-history" role="tabpanel" aria-labelledby="ride-history-tab">
                <!-- Search Bar -->
                <input type="text" id="search" class="form-control mt-3" placeholder="Search by ID, Navigator/Commuter Name, or Location">

                <!-- Rides Table -->
                <div class="table-container">
                    <table class="table table-striped" id="ridesTable">
                        <tbody>
                            @foreach($rides as $ride)
                            <tr class="clickable-row" data-toggle="modal" data-target="#viewRideModal{{ $ride->id }}" data-id="{{ $ride->id }}" data-vehicle_number="{{ $ride->vehicle_number }}" data-vehicle_color="{{ $ride->vehicle_color }}" data-vehicle_model="{{ $ride->vehicle_model }}" data-user_name="{{ $ride->user_name }}" data-start_location="{{ $ride->start_location }}" data-end_location="{{ $ride->end_location }}" data-description="{{ $ride->description }}" data-status="{{ $ride->status }}" data-start_time="{{ $ride->start_time }}" data-end_time="{{ $ride->end_time }}" data-duration="{{ $ride->duration }}" data-deleted_at="{{ $ride->deleted_at }}" data-planned_departure_time="{{ $ride->planned_departure_time }}" data-apiit_route="{{ $ride->apiit_route }}">
                                <td><i class="fas fa-users icon"></i> <!-- Two people icon for commuter rides --></td>
                                <td data-label="ID">
                                    {{ $ride->id }}
                                </td>
                                <td data-label="Navigator/Commuter Name">{{ $ride->user_name }}</td>
                                <td data-label="Start Location">{{ $ride->start_location }}</td>
                                <td data-label="End Location">{{ $ride->end_location }}</td>
                            </tr>

                            <!-- View Ride Details Modal -->
                            <div class="modal fade" id="viewRideModal{{ $ride->id }}" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Ride Details: {{ $ride->id }}</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>ID:</strong> <span id="modal-id-{{ $ride->id }}"></span></p>
                                            <p><strong>Vehicle Number:</strong> <span id="modal-vehicle_number-{{ $ride->id }}"></span></p>
                                            <p><strong>Vehicle Color:</strong> <span id="modal-vehicle_color-{{ $ride->id }}"></span></p>
                                            <p><strong>Vehicle Model:</strong> <span id="modal-vehicle_model-{{ $ride->id }}"></span></p>
                                            <p><strong>Navigator/Commuter Name:</strong> <span id="modal-user_name-{{ $ride->id }}"></span></p>
                                            <p><strong>Start Location:</strong> <span id="modal-start_location-{{ $ride->id }}"></span></p>
                                            <p><strong>End Location:</strong> <span id="modal-end_location-{{ $ride->id }}"></span></p>
                                            <p><strong>Description:</strong> <span id="modal-description-{{ $ride->id }}"></span></p>
                                            <p><strong>Status:</strong> <span id="modal-status-{{ $ride->id }}"></span></p>
                                            <p><strong>Start Time:</strong> <span id="modal-start_time-{{ $ride->id }}"></span></p>
                                            <p><strong>End Time:</strong> <span id="modal-end_time-{{ $ride->id }}"></span></p>
                                            <p><strong>Duration:</strong> <span id="modal-duration-{{ $ride->id }}"></span></p>
                                            <p><strong>Deleted At:</strong> <span id="modal-deleted_at-{{ $ride->id }}"></span></p>
                                            <p><strong>Planned Departure Time:</strong> <span id="modal-planned_departure_time-{{ $ride->id }}"></span></p>
                                            <p><strong>APIIT Route:</strong> <span id="modal-apiit_route-{{ $ride->id }}"></span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Commuter History Tab -->
            <div class="tab-pane fade" id="commuter-history" role="tabpanel" aria-labelledby="commuter-history-tab">
                <!-- Search Bar -->
                <input type="text" id="commuter-search" class="form-control mt-3" placeholder="Search by ID, Pickup Location, or Status">

                <!-- Commuter Table -->
                <div class="table-container">
                    <table class="table table-striped" id="commuterTable">
                        <tbody>
                            @foreach($pickupLocations as $pickupLocation)
                            <tr class="clickable-row" data-toggle="modal" data-target="#viewPickupModal{{ $pickupLocation->id }}" data-id="{{ $pickupLocation->id }}" data-ride_id="{{ $pickupLocation->ride_id }}" data-pickup_location="{{ $pickupLocation->pickup_location }}" data-status="{{ $pickupLocation->status }}" data-deleted_at="{{ $pickupLocation->deleted_at }}">
                                <td><i class="fas fa-map-marker-alt icon"></i> <!-- Map marker icon for pickup locations --></td>
                                <td data-label="ID">{{ $pickupLocation->id }}</td>
                                <td data-label="Ride ID">{{ $pickupLocation->ride_id }}</td>
                                <td data-label="Pickup Location">{{ $pickupLocation->pickup_location }}</td>
                                <td data-label="Status">{{ $pickupLocation->status }}</td>
                            </tr>

                            <!-- View Pickup Details Modal -->
                            <div class="modal fade" id="viewPickupModal{{ $pickupLocation->id }}" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Pickup Details: {{ $pickupLocation->id }}</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>ID:</strong> <span id="modal-pickup-id-{{ $pickupLocation->id }}"></span></p>
                                            <p><strong>Ride ID:</strong> <span id="modal-pickup-ride_id-{{ $pickupLocation->id }}"></span></p>
                                            <p><strong>Pickup Location:</strong> <span id="modal-pickup_location-{{ $pickupLocation->id }}"></span></p>
                                            <p><strong>Status:</strong> <span id="modal-pickup-status-{{ $pickupLocation->id }}"></span></p>
                                            <p><strong>Deleted At:</strong> <span id="modal-pickup-deleted_at-{{ $pickupLocation->id }}"></span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <button class="backbtn btn btn-secondary mt-3" onclick="window.location.href='{{ route('home') }}'">&larr; Back</button>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.getElementById('search').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#ridesTable tbody tr');
            
            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const match = Array.from(cells).some(cell => 
                    cell.textContent.toLowerCase().includes(searchTerm)
                );
                row.style.display = match ? '' : 'none';
            });
        });

        document.getElementById('commuter-search').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#commuterTable tbody tr');
            
            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const match = Array.from(cells).some(cell => 
                    cell.textContent.toLowerCase().includes(searchTerm)
                );
                row.style.display = match ? '' : 'none';
            });
        });

        // Update modal content on row click
        document.querySelectorAll('.clickable-row').forEach(row => {
            row.addEventListener('click', function() {
                if (this.closest('#ridesTable')) {
                    const modal = document.querySelector('#viewRideModal' + this.dataset.id);
                    modal.querySelector('#modal-id-' + this.dataset.id).textContent = this.dataset.id;
                    modal.querySelector('#modal-vehicle_number-' + this.dataset.id).textContent = this.dataset.vehicle_number;
                    modal.querySelector('#modal-vehicle_color-' + this.dataset.id).textContent = this.dataset.vehicle_color;
                    modal.querySelector('#modal-vehicle_model-' + this.dataset.id).textContent = this.dataset.vehicle_model;
                    modal.querySelector('#modal-user_name-' + this.dataset.id).textContent = this.dataset.user_name;
                    modal.querySelector('#modal-start_location-' + this.dataset.id).textContent = this.dataset.start_location;
                    modal.querySelector('#modal-end_location-' + this.dataset.id).textContent = this.dataset.end_location;
                    modal.querySelector('#modal-description-' + this.dataset.id).textContent = this.dataset.description;
                    modal.querySelector('#modal-status-' + this.dataset.id).textContent = this.dataset.status;
                    modal.querySelector('#modal-start_time-' + this.dataset.id).textContent = this.dataset.start_time;
                    modal.querySelector('#modal-end_time-' + this.dataset.id).textContent = this.dataset.end_time;
                    modal.querySelector('#modal-duration-' + this.dataset.id).textContent = this.dataset.duration;
                    modal.querySelector('#modal-deleted_at-' + this.dataset.id).textContent = this.dataset.deleted_at;
                    modal.querySelector('#modal-planned_departure_time-' + this.dataset.id).textContent = this.dataset.planned_departure_time;
                    modal.querySelector('#modal-apiit_route-' + this.dataset.id).textContent = this.dataset.apiit_route;
                } else if (this.closest('#commuterTable')) {
                    const modal = document.querySelector('#viewPickupModal' + this.dataset.id);
                    modal.querySelector('#modal-pickup-id-' + this.dataset.id).textContent = this.dataset.id;
                    modal.querySelector('#modal-pickup-ride_id-' + this.dataset.id).textContent = this.dataset.ride_id;
                    modal.querySelector('#modal-pickup_location-' + this.dataset.id).textContent = this.dataset.pickup_location;
                    modal.querySelector('#modal-pickup-status-' + this.dataset.id).textContent = this.dataset.status;
                    modal.querySelector('#modal-pickup-deleted_at-' + this.dataset.id).textContent = this.dataset.deleted_at;
                }
            });
        });
    </script>
</body>
</html>

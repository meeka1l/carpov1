<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ride History</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Krona+One&display=swap" rel="stylesheet">
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
            overflow-x: auto; /* Allows horizontal scrolling if needed */
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
            border: 2px solid black; /* Adds a black border around each row */
            border-radius: 5px; /* Optional: adds rounded corners to the rows */
            margin-bottom: 1rem; /* Adds space between rows */
            padding: 0.5rem; /* Adds padding to each row */
            background-color: #f8f9fa; /* Light background color for better readability */
        }
        .table tbody td {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem;
            border-bottom: 1px solid #dee2e6;
        }
        .table tbody td::before {
            content: attr(data-label);
            font-weight: bold;
            flex-basis: 40%;
            text-align: left;
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
                                <td data-label="ID">{{ $ride->id }}</td>
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
                                            <p><strong>ID:</strong> <span id="modal-id"></span></p>
                                            <p><strong>Vehicle Number:</strong> <span id="modal-vehicle_number"></span></p>
                                            <p><strong>Vehicle Color:</strong> <span id="modal-vehicle_color"></span></p>
                                            <p><strong>Vehicle Model:</strong> <span id="modal-vehicle_model"></span></p>
                                            <p><strong>Navigator/Commuter Name:</strong> <span id="modal-user_name"></span></p>
                                            <p><strong>Start Location:</strong> <span id="modal-start_location"></span></p>
                                            <p><strong>End Location:</strong> <span id="modal-end_location"></span></p>
                                            <p><strong>Description:</strong> <span id="modal-description"></span></p>
                                            <p><strong>Status:</strong> <span id="modal-status"></span></p>
                                            <p><strong>Start Time:</strong> <span id="modal-start_time"></span></p>
                                            <p><strong>End Time:</strong> <span id="modal-end_time"></span></p>
                                            <p><strong>Duration:</strong> <span id="modal-duration"></span></p>
                                            <p><strong>Deleted At:</strong> <span id="modal-deleted_at"></span></p>
                                            <p><strong>Planned Departure Time:</strong> <span id="modal-planned_departure_time"></span></p>
                                            <p><strong>APIIT Route:</strong> <span id="modal-apiit_route"></span></p>
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
                <!-- Content for Commuter History will be added here -->
                <p>This section is for commuter history. Content will be added here later.</p>
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

        // Update modal content on row click
        document.querySelectorAll('.clickable-row').forEach(row => {
            row.addEventListener('click', function() {
                const modal = document.querySelector(`#viewRideModal${this.dataset.id}`);
                modal.querySelector('#modal-id').textContent = this.dataset.id;
                modal.querySelector('#modal-vehicle_number').textContent = this.dataset.vehicle_number;
                modal.querySelector('#modal-vehicle_color').textContent = this.dataset.vehicle_color;
                modal.querySelector('#modal-vehicle_model').textContent = this.dataset.vehicle_model;
                modal.querySelector('#modal-user_name').textContent = this.dataset.user_name;
                modal.querySelector('#modal-start_location').textContent = this.dataset.start_location;
                modal.querySelector('#modal-end_location').textContent = this.dataset.end_location;
                modal.querySelector('#modal-description').textContent = this.dataset.description;
                modal.querySelector('#modal-status').textContent = this.dataset.status;
                modal.querySelector('#modal-start_time').textContent = this.dataset.start_time;
                modal.querySelector('#modal-end_time').textContent = this.dataset.end_time;
                modal.querySelector('#modal-duration').textContent = this.dataset.duration;
                modal.querySelector('#modal-deleted_at').textContent = this.dataset.deleted_at || 'N/A';
                modal.querySelector('#modal-planned_departure_time').textContent = this.dataset.planned_departure_time || 'N/A';
                modal.querySelector('#modal-apiit_route').textContent = this.dataset.apiit_route;
            });
        });
    </script>
</body>
</html>

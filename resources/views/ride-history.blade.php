<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ride History</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Krona+One&display=swap" rel="stylesheet">
    <style>
        h1{
            font-family: 'Krona One', sans-serif;
            color: #70d5c3;
        }
        .logo{
            font-size: 2em;
            color: black;
        }    
        .viewbtn{
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
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mt-5 logo">CARPO</h1>
        <h1 class="mt-5">Ride History</h1>
        
        <!-- Search Bar -->
        <input type="text" id="search" class="form-control mt-3" placeholder="Search by ID, Navigator/Commuter Name, or Location">

        <!-- Rides Table -->
        <div class="table-container">
            <table class="table table-striped" id="ridesTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Navigator/Commuter Name</th>
                        <th>Start Location</th>
                        <th>End Location</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rides as $ride)
                    <tr>
                        <td>{{ $ride->id }}</td>
                        <td>{{ $ride->user_name }}</td>
                        <td>{{ $ride->start_location }}</td>
                        <td>{{ $ride->end_location }}</td>
                        <td>
                            <!-- View Details Button -->
                            <button class="viewbtn btn btn-info btn-sm" data-toggle="modal" data-target="#viewRideModal{{ $ride->id }}">View Details</button>
                        </td>
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
                                    <p><strong>ID:</strong> {{ $ride->id }}</p>
                                    <p><strong>Vehicle Number:</strong> {{ $ride->vehicle_number }}</p>
                                    <p><strong>Vehicle Color:</strong> {{ $ride->vehicle_color }}</p>
                                    <p><strong>Vehicle Model:</strong> {{ $ride->vehicle_model }}</p>
                                    <p><strong>Navigator/Commuter Name:</strong> {{ $ride->user_name }}</p>
                                    <p><strong>Start Location:</strong> {{ $ride->start_location }}</p>
                                    <p><strong>End Location:</strong> {{ $ride->end_location }}</p>
                                    <p><strong>Description:</strong> {{ $ride->description }}</p>
                                    <p><strong>Status:</strong> {{ $ride->status }}</p>
                                    <p><strong>Start Time:</strong> {{ $ride->start_time }}</p>
                                    <p><strong>End Time:</strong> {{ $ride->end_time }}</p>
                                    <p><strong>Duration:</strong> {{ $ride->duration }}</p>
                                    <p><strong>Deleted At:</strong> {{ $ride->deleted_at ? $ride->deleted_at->format('Y-m-d H:i:s') : 'N/A' }}</p>
                                    <p><strong>Planned Departure Time:</strong> {{ $ride->planned_departure_time ? $ride->planned_departure_time->format('Y-m-d H:i:s') : 'N/A' }}</p>
                                    <p><strong>APIIT Route:</strong> {{ $ride->apiit_route }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Back Button -->
        <button class="backbtn btn btn-secondary mt-3" onclick="window.location.href='{{ route('home') }}'">&larr;Back</button>
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
    </script>
</body>
</html>

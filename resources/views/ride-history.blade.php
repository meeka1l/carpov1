<!DOCTYPE html>
<html>
<head>
    <title>Ride History</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Your Ride History</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Vehicle Number</th>
                    <th>Vehicle Color</th>
                    <th>Vehicle Model</th>
                    <th>Start Location</th>
                    <th>End Location</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Duration</th>
                    <th>Deleted At</th>
                    <th>Planned Departure Time</th>
                    <th>APIIT Route</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($rides as $ride)
                    <tr>
                        <td>{{ $ride->id }}</td>
                        <td>{{ $ride->vehicle_number }}</td>
                        <td>{{ $ride->vehicle_color }}</td>
                        <td>{{ $ride->vehicle_model }}</td>
                        <td>{{ $ride->start_location }}</td>
                        <td>{{ $ride->end_location }}</td>
                        <td>{{ $ride->description }}</td>
                        <td>{{ $ride->status }}</td>
                        <td>{{ $ride->start_time }}</td>
                        <td>{{ $ride->end_time }}</td>
                        <td>{{ $ride->duration }}</td>
                        <td>{{ $ride->deleted_at ? $ride->deleted_at->format('Y-m-d H:i:s') : 'N/A' }}</td>
                        <td>{{ $ride->planned_departure_time ? $ride->planned_departure_time->format('Y-m-d H:i:s') : 'N/A' }}</td>
                        <td>{{ $ride->apiit_route }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="15">No rides found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>

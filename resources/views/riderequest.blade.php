<h2>Ride Request</h2>

<strong>Vehicle:</strong> {{ $ride->vehicle_model }} ({{ $ride->vehicle_number }})<br><br>
<strong>Color:</strong> {{ $ride->vehicle_color }}<br>
<strong>Description:</strong> {{ $ride->description }}<br>

<!-- Display the ride request status -->
@if($ride->status == 'Pending')
    <p>Your request is pending.</p>
@elseif($ride->status == 'Accepted')
    <p>Your request has been accepted!</p>
@elseif($ride->status == 'Rejected')
    <p>Your request has been rejected.</p>
@endif

<!-- Form to allow the user to input their pickup location -->
@if($ride->status == 'Pending')
    <form action="{{ route('rides.join') }}" method="post">
        @csrf
        <input type="hidden" name="ride_id" value="{{ $ride->id }}">
        <strong>Pickup Location:</strong> 
        <input type="text" id="pickup_location" name="pickup_location" required>
        <br><br>
        <button type="submit">Confirm Join Ride</button>
    </form>
@endif

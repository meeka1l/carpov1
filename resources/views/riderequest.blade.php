<h2>Ride Request</h2>

<strong>Vehicle:</strong> {{ $ride->vehicle_model }} ({{ $ride->vehicle_number }})<br><br>
<strong>Color:</strong> {{ $ride->vehicle_color }}<br>
<strong>Description:</strong> {{ $ride->description }}<br>

<!-- Form to allow the user to input their pickup location -->
<form action="{{ route('rides.join') }}" method="post">
    @csrf
    <input type="hidden" name="ride_id" value="{{ $ride->id }}">
    <strong>Pickup Location:</strong> 
    <input type="text" id="pickup_location" name="pickup_location" required>
    <br><br>
    <button type="submit">Confirm Join Ride</button>
</form>

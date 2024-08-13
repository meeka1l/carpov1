


<h2>Ride Request</h2>

<strong>Vehicle:</strong> {{ $ride->vehicle_model }} ({{ $ride->vehicle_number }})<br><br>
<strong>Color:</strong> {{ $ride->vehicle_color }}<br>
<strong>Description:</strong> {{ $ride->description }}<br>
<strong>Pickup Location:</strong> {{ $ride->pickup_location }}<br>

<!-- Additional options or actions can be added here -->
<form action="{{ route('rides.join') }}" method="POST">
    @csrf
    <input type="hidden" name="ride_id" value="{{ $ride->id }}">
    <input type="hidden" name="pickup_location" value="{{ $ride->pickup_location }}">
    <button type="submit">Confirm Join Ride</button>
</form>


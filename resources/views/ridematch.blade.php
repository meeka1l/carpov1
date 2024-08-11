<section>
<div class="ride-details">
@foreach($rides as $ride)
            <li>
                <strong>Vehicle:</strong> {{ $ride->vehicle_model }} ({{ $ride->vehicle_number }})<br><br>
                <strong>Color:</strong> {{ $ride->vehicle_color }}<br>
                <span class="ride-description">{{ $ride->description }}</span><br>
                <form action="{{ route('rides.join') }}" method="POST">
                    @csrf
                    <input type="hidden" name="ride_id" value="{{ $ride->id }}">
                    <input type="hidden" id="pickup_location_{{ $ride->id }}" name="pickup_location" required>
                    <button type="submit" onclick="setPickupLocation({{ $ride->id }})">Join Ride</button>
                </form>
            </li>
            @endforeach

            <button type="button" onclick="goBack()">Back</button>
    
</div>

</section>
<script>
function goBack() {
    window.history.back();
}

function setPickupLocation(rideId) {
    // Your logic to set the pickup location
}
</script>
<?php





<!-- Rides where the logged-in user is the navigator -->
<h2>My Rides as Navigator</h2>
@foreach($sharedRides as $ride)
    <div class="ride-details">
        <strong>Vehicle:</strong> {{ $ride->vehicle_model }} ({{ $ride->vehicle_number }})<br>
        <strong>Color:</strong> {{ $ride->vehicle_color }}<br>
        <strong>Description:</strong> {{ $ride->description }}<br>

        <strong>Navigator ID:</strong> {{ $ride->navigator_id }}<br>
        <strong>Pickup Locations:</strong>
        @php
            $locationsForRide = $pickupLocations->where('ride_id', $ride->id);
        @endphp
        @if($locationsForRide->isEmpty())
            <p>No pickup locations available.</p>
        @else
            @foreach($locationsForRide as $location)
                @php
                    $commuter = $commuters->get($location->user_id);
                @endphp
                <p>
                    {{ $location->pickup_location }} 
                    (Commuter: {{ $commuter ? $commuter->name : 'Unknown' }}, 
                    User ID: {{ $location->user_id }})
                </p>
            @endforeach
        @endif
    </div>
    <hr>
@endforeach

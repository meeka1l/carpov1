<!-- Rides where the logged-in user is the navigator -->
<h2>My Rides as Navigator</h2>
@foreach($sharedRides as $ride)
    <div class="ride-details">
        <strong>Vehicle:</strong> {{ $ride->vehicle_model }} ({{ $ride->vehicle_number }})<br>
        <strong>Color:</strong> {{ $ride->vehicle_color }}<br>
        <strong>Description:</strong> {{ $ride->description }}<br>

        <strong>Navigator ID:</strong> {{ $ride->navigator_id }}<br>
        <strong>Status:</strong> {{ $ride->status }}<br>
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

        <!-- Accept/Reject Buttons -->
        @if($ride->status == 'Pending')
            <form action="{{ route('rides.accept', $ride->id) }}" method="POST">
                @csrf
                <button type="submit">Accept Ride</button>
            </form>
            <form action="{{ route('rides.reject', $ride->id) }}" method="POST">
                @csrf
                <button type="submit">Reject Ride</button>
            </form>
        @elseif($ride->status == 'Accepted')
            <p>Ride accepted.</p>
        @elseif($ride->status == 'Rejected')
            <p>Ride rejected.</p>
        @endif
         </div>
        
        <!-- Delete Button -->
        <form action="{{ route('rides.delete', $ride->id) }}" method="post" onsubmit="return confirm('Are you sure you want to delete this ride?');">
            @csrf
            @method('DELETE')
            <button type="submit">Delete Ride</button>
        </form>
    <hr>
@endforeach

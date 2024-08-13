<section>
    <div class="ride-details">
        @foreach($rides as $ride)
            <li>
                <strong>Vehicle:</strong> {{ $ride->vehicle_model }} ({{ $ride->vehicle_number }})<br><br>
                <strong>Color:</strong> {{ $ride->vehicle_color }}<br>
                <strong>Description:</strong>
                <span class="ride-description">{{ $ride->description }}</span><br>
                <form action="{{ route('rides.join') }}" method="get">
                    @csrf
                    <input type="hidden" name="ride_id" value="{{ $ride->id }}">
                    <input type="hidden" id="pickup_location_{{ $ride->id }}" name="pickup_location" required>
                    
                </form>
            </li>
        @endforeach
    </div>
   
</section>
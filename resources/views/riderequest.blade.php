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
@elseif($ride->status == 'Started')
    <p>The ride has started.</p>
    @php
    // Convert the start time to the desired timezone
    $startTime = \Carbon\Carbon::parse($ride->start_time)->setTimezone('Asia/Colombo');
    $currentTime = \Carbon\Carbon::now()->setTimezone('Asia/Colombo');

    // Calculate the duration
    $duration = $startTime->diff($currentTime);

    // Format the duration
    $formattedDuration = $duration->format('%H:%I:%S');
@endphp
<p>Ride started at {{ \Carbon\Carbon::parse($ride->start_time)->setTimezone('Asia/Colombo')->format('Y-m-d (h:i:s A)') }}</p>
<p>Ride duration: <span id="ride-timer">{{ $formattedDuration }}</span></p>

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
    @elseif($ride->status == 'Ended')
    <p>The ride has ended.</p>
@endif
<button onclick="history.back()" style="margin-bottom: 20px;">&larr; Back</button>


<script>
     document.addEventListener('DOMContentLoaded', (event) => {
        @if($ride->status == 'Started')
        let startTime = new Date("{{ \Carbon\Carbon::parse($ride->start_time)->timezone('Asia/Colombo')->format('Y-m-d H:i:s') }}").getTime();
        let timerElement = document.getElementById('ride-timer');

            function updateTimer() {
                let now = new Date().getTime();
                let elapsed = now - startTime;

                let hours = Math.floor((elapsed % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                let minutes = Math.floor((elapsed % (1000 * 60 * 60)) / (1000 * 60));
                let seconds = Math.floor((elapsed % (1000 * 60)) / 1000);

                hours = hours < 10 ? '0' + hours : hours;
                minutes = minutes < 10 ? '0' + minutes : minutes;
                seconds = seconds < 10 ? '0' + seconds : seconds;

                timerElement.innerHTML = hours + ':' + minutes + ':' + seconds;
            }

            setInterval(updateTimer, 1000);
        @endif
    });
</script>
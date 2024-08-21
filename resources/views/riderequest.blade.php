<head>
<link href="https://fonts.googleapis.com/css2?family=Krona+One&display=swap" rel="stylesheet">
</head>

<div style="padding: 10px; font-family: Arial, sans-serif; max-width: 600px; margin: auto;">
    <h2 style="font-size: 1.5em; color: #333; font-family: Krona One">RIDE REQUEST</h2>

    <p><strong>Vehicle:</strong> {{ $ride->vehicle_model }} ({{ $ride->vehicle_number }})</p>
    <p><strong>Color:</strong> {{ $ride->vehicle_color }}</p>
    <p><strong>Description:</strong> {{ $ride->description }}</p>

    <!-- Display the ride request status -->
    @if($ride->status == 'Pending')
        <p style="color: #FFA500;">Your request is pending.</p>
    @elseif($ride->status == 'Accepted')
        <p style="color: #008000;">Your request has been accepted!</p>
    @elseif($ride->status == 'Rejected')
        <p style="color: #FF0000;">Your request has been rejected.</p>
    @elseif($ride->status == 'Started')
        <p style="color: #0000FF;">The ride has started.</p>
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
        <p>Ride duration: <span id="ride-timer" style="font-weight: bold;">{{ $formattedDuration }}</span></p>
    @endif

    <!-- Form to allow the user to input their pickup location -->
    @if($ride->status == 'Pending')
        <form action="{{ route('rides.join') }}" method="post" style="margin-top: 20px;">
            @csrf
            <input type="hidden" name="ride_id" value="{{ $ride->id }}">
            <label for="pickup_location" style="font-weight: bold;">Pickup Location:</label><br>
            <input type="text" id="pickup_location" name="pickup_location" required style="width: 100%; padding: 8px; margin-top: 10px; box-sizing: border-box;">
            <button type="submit" style="width: 100%; padding: 10px; background-color: #008CBA; color: white; border: none; border-radius: 4px; margin-top: 20px;">Confirm Join Ride</button>
        </form>
    @elseif($ride->status == 'Ended')
        <p style="color: #FF0000; margin-top: 20px;">The ride has ended.</p>
    @endif
    <button onclick="history.back()" style="width: 100%; padding: 10px; background-color: #f1f1f1; color: #333; border: 1px solid #ccc; border-radius: 4px; margin-top: 20px;">&larr; Back</button>
</di>

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

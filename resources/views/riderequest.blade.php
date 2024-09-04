<head>
<link href="https://fonts.googleapis.com/css2?family=Krona+One&display=swap" rel="stylesheet">

<style>

    
       /* Loading screen styles */
       #loading-screen {
        top: 0;
        left: 0;
        position: fixed;
        width: 100%;
        height: 100%;
        background-color: #1e8573;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    /* Text animation */
    .loading-text {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .text-animate {
        font-family: 'Krona One', sans-serif;
        color: #ffffff;
        font-size: 2em;
        opacity: 0;
        animation: fadeInOut 4s ease-in-out infinite;
    }

    .text-animate:nth-child(2) {
        animation-delay: 1s;
    }

    .text-animate:nth-child(3) {
        animation-delay: 2s;
    }

    .text-animate:nth-child(4) {
        animation-delay: 3s;
    }

    @keyframes fadeInOut {
        0%, 100% {
            opacity: 0;
            transform: translateY(-10px);
        }
        25%, 75% {
            opacity: 1;
            transform: translateY(0);
        }
    }


    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .container {
        padding: 2em; /* Increased padding */
        max-width: 100%;
        margin: auto;
        font-size: 1.2rem; /* Increased font size */
        box-sizing: border-box;
    }

    h1  {
        font-size: 4em; /* Larger font size for headings */
        color: #333;
        font-family: 'Krona One', sans-serif;
        margin-bottom:10%;
        margin-top: 2%;
        margin-left: 2%;
        margin-left: 33.3%;
        margin-right: 33.3%;
        margin-top: 10%;
    }

    h2 {
        font-size: 1em; /* Larger font size for headings */
        color: white;
        font-family: 'Krona One', sans-serif;
        margin: 5%;
        margin-bottom: 5%;
    }

    p {
        font-size: 1.2em; /* Increased font size for paragraphs */
        margin: 1em 0; /* Adjusted margin for better spacing */
    }

    .status-message {
        font-weight: bold;
    }

    .status-pending {
        color: #FFA500;
    }

    .status-accepted {
        color: #008000;
    }

    .status-rejected {
        color: #FF0000;
    }

    .status-started {
        color: #0000FF;
    }

    .form-container {
        margin-top: 2em; /* Increased margin for form */
    }

    input[type="text"] {
        width: 100%;
        padding: 1em; /* Increased padding for better touchability */
        margin-top: 1em; /* Increased margin for spacing */
        font-size: 1.2em; /* Larger font size for input */
        box-sizing: border-box;
    }

    button {
        width: 100%;
        padding: 1em; /* Increased padding for better touchability */
        font-size: 1.2em; /* Larger font size for buttons */
        border: none;
        border-radius: 4px;
        margin-top: 2em; /* Increased margin for spacing */
        cursor: pointer;
        box-sizing: border-box;
    }

    .btn-confirm {
        background-color: #008CBA;
        color: white;
    }

    .btn-back {
        background-color:#ef0000;
        color: white;
        border: 1px solid #ccc;
    }
    #bg_design{
        background-color: #27af97;
        padding: 2%;
        margin-right: 30%;
        margin-bottom: 5%;
      font-size: smaller;
    }
    .ride-container {
        padding: 1.5em; /* Increased padding */
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        margin: 0 auto;
        max-width: 90%;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        font-size: 2em;
    }
    .headerkrona {
        font-size: 1.5em; /* Larger font size for headings */
        color: white;
        font-family: 'Krona One', sans-serif;
        margin-top: 0px;
        margin-bottom: 2em;
    }

    .light_box{
        max-width: 100%;
        background: linear-gradient(to bottom, 
            #00d5a9, /* Light at the top */
            #009475  /* Dark at the bottom */
            );
        color: white;
        padding: 5%;
        padding-top: 5%;
        padding-bottom: 10%;
        border-radius: 5%;
        margin-bottom: 10%;
        font-size: 30px;
    }
    .dark_box{
        max-width: 100%;
        background: linear-gradient(to bottom, 
            #405ead, /* Light at the top */
            #1b2e5f  /* Dark at the bottom */
    );
    max-height: 700px; /* Adjust this height as needed */
        overflow-y: auto; /* Enable vertical scrolling */
        overflow-x: hidden; /* Prevent horizontal scrolling */
        color: white;
        padding: 5%;
        padding-top: 5%;
        padding-bottom: 15%;
        border-radius: 5%;
        font-size: 20px;
    }

    .headerkrona2 {
        font-size: 1.75em; /* Larger font size for headings */
        color: white;
        font-family: 'Krona One', sans-serif;
        margin-top: 0px;
        margin-bottom: 2em;
    }

    .btn-chat { 
    width: 100%;
    padding: 1em; /* Increased padding for better touchability */
    font-size: 1.2em; /* Larger font size for buttons */
    background-color: #4CAF50; /* Green background */
    color: white;
    border: none;
    border-radius: 4px;
    margin-top: 2em; /* Increased margin for spacing */
    cursor: pointer;
    box-sizing: border-box;
}

.btn-chat:hover {
    background-color: #45a049; /* Slightly darker green on hover */
}

    

</style>
</head>
<div class="container">
    <h1>CARPO</h1>
    <div id="bg_design">
    <h2>RIDE REQUEST</h2>
    </div>
    <div class="ride-container">

    <div class="light_box">
    <strong class="headerkrona">Vehicle</strong><br><br>
    <p><strong>Vehicle:</strong> {{ $ride->vehicle_model }} ({{ $ride->vehicle_number }})</p>
    <p><strong>Color:</strong> {{ $ride->vehicle_color }}</p>
    </div>

    <div class="dark_box">
    <strong class="headerkrona2">Route</strong><br><br>
    <p>{!! nl2br(e(preg_replace('/(\d+)\./', "\n$1.", $ride->description))) !!}</p>
    </div>

    <!-- Display the ride request status -->
    @if($ride->status == 'Pending')
        <p class="status-message status-pending">Your request is pending...</p>
    @elseif($ride->status == 'Accepted')
        <p class="status-message status-accepted">Your request has been accepted! Waiting for ride to start...</p>
        <button class="btn-chat" onclick="window.location.href='{{ route('chat.index', ['ride' => $ride->id]) }}'">Chat with Navigator</button>

    @elseif($ride->status == 'Rejected')
        <p class="status-message status-rejected">Your request has been rejected.</p>
    @elseif($ride->status == 'Started')
        <p class="status-message status-started">The ride has started.</p>
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
        <button class="btn-chat" onclick="window.location.href='{{ route('chat.index', ['ride' => $ride->id]) }}'">Chat</button>
    @endif

    <!-- Form to allow the user to input their pickup location -->
    @if($ride->status == 'Pending')
        <div class="form-container">
            <form action="{{ route('rides.join') }}" method="post">
                @csrf
                <input type="hidden" name="ride_id" value="{{ $ride->id }}">
                <label for="pickup_location" style="font-weight: bold; font-size: 1.2em;">Enter your pickup location:</label><br>
                <input type="text" id="pickup_location" name="pickup_location" required placeholder="e.g., Kolonnawa Pizzahut">
                <button type="submit" class="btn-confirm">Confirm Request</button>
            </form>
        </div>
    @elseif($ride->status == 'Ended')
        <p class="status-message status-rejected" style="margin-top: 2em;">The ride has ended.</p>
    @endif
    <button onclick="history.back()" class="btn-back">&larr; Back</button>
</div>

<script>

document.addEventListener('DOMContentLoaded', function() {
            // Convert URLs to clickable links
            const routeDescription = document.querySelector('.dark_box p');
            if (routeDescription) {
                const html = routeDescription.innerHTML;
                const updatedHtml = html.replace(/(https?:\/\/[^\s]+)/g, '<a href="$1" target="_blank">$1</a>');
                routeDescription.innerHTML = updatedHtml;
            }
        });

window.addEventListener('load', function() {
        const loadingScreen = document.getElementById('loading-screen');
        if (loadingScreen) {
            // Show the loading screen initially
            loadingScreen.style.opacity = '1';
            
            // Hide the loading screen after 5 seconds
            setTimeout(() => {
                loadingScreen.style.opacity = '0';
                setTimeout(() => {
                    loadingScreen.style.display = 'none';
                }, 1000); // Match the transition duration
            }, 5000); // Display for 5 seconds
        }
    });

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

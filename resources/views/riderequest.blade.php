<head>
<link href="https://fonts.googleapis.com/css2?family=Krona+One&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
        background-color:#434343;
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
    background-color:#e9c31a; /* Green background */
    color: white;
    border: none;
    border-radius: 60px;
    margin-top: 2em; /* Increased margin for spacing */
    cursor: pointer;
    box-sizing: border-box;

}


.btn-emergency {
        background-color: #e74c3c; /* Red background */
        color: white;
        border: none;
        border-radius: 60px;
        padding: 1em;
        font-size: 1.2em;
        width: 100%;
        margin-top: 1.5em;
        cursor: pointer;
        box-sizing: border-box;
       text-align: center;
       text-decoration: none;
    }

    .btn-emergency:hover {
        background-color: #c0392b; /* Darker red on hover */
    }

    .buttons_{
        display: flex;
        flex-direction: column;
    }

    textarea{
        width: 100%;
        font-size: 1.0em;      /* Adjusts the font size to make the text larger */
        padding: 10px;        /* Adds padding for better readability */
        line-height: 1.1;     /* Increases the line height for better spacing */
        resize: vertical; 
        }

        .btn-report {
            display:block;
            align-items: center;
            text-align: center;
            padding: 10px 15px;
            background-color: #dc3545; /* Red color for alert */
            color: white;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            font-size: 1.5em;
            transition: background-color 0.3s ease;
        }

        .btn-report i {
            margin-right: 8px;
        }

        .btn-report:hover {
            background-color: #c82333;
        }
</style>
</head>
@php
    $emergencyContact = auth()->user()->emergency_contact;
@endphp
<div class="container">
    <h1>CARPO</h1>
    <div id="bg_design">
    <h2>RIDE REQUEST</h2>
    </div>
    <div class="ride-container">

    <div class="light_box">
    <strong class="headerkrona">Details</strong><br><br>
    <p><strong>Name:</strong> {{$ride->user_name}}</p> 
    <p><strong>Vehicle:</strong> {{ $ride->vehicle_model }} ({{ $ride->vehicle_number }})</p>
    <p><strong>Color:</strong> {{ $ride->vehicle_color }}</p>
    @if ($ride->apiit_route=='to')
    <p><strong>Ride: </strong>TO APIIT</p>
    @elseif ($ride->apiit_route=='from')
    <p><strong>Ride: </strong>FROM APIIT</p>
    @endif
    </div>

    <div class="dark_box">
    <strong class="headerkrona2">Route</strong><br><br>
    <p>{!! nl2br(e(preg_replace('/(\d+)\./', "\n$1.", $ride->description))) !!}</p>
    </div>

    <!-- Display the ride request status -->
@php
    // Get the specific commuter's pickup location
    $commuterPickupLocation = $pickupLocations->where('ride_id', $ride->id)->where('user_id', auth()->user()->id)->first();
@endphp

@if($ride->status == 'Pending')
            @if($commuterPickupLocation)
                @if($commuterPickupLocation->status == 'pending')
                    <p class="status-message status-pending">Your request is pending...</p>
                    <form action="{{ route('rides.endJourney', ['ride' => $ride->id]) }}" method="POST" onsubmit="return confirmEndRequest()">
                @csrf
                <button type="submit" class="btn-back">Cancel Request</button>
            </form>
            <script>
                // Function to refresh the page
                function refreshPage() {
                    location.reload();
                }

                // Set the page to refresh every 15 seconds
                setInterval(refreshPage, 15000);
            </script>
                @elseif($commuterPickupLocation->status == 'accepted')
                    <p class="status-message status-accepted">Your request has been accepted! Waiting for ride to start...</p>
                    <button class="btn-chat" onclick="window.location.href='{{ route('chat.index', ['ride' => $ride->id]) }}'">Chat with Navigator</button>
                    <form action="{{ route('rides.endJourney', ['ride' => $ride->id]) }}" method="POST" onsubmit="return confirmEndRequest()">
                    <script>
                // Function to refresh the page
                function refreshPage() {
                    location.reload();
                }

                // Set the page to refresh every 15 seconds
                setInterval(refreshPage, 15000);
            </script>
                @csrf
                <button type="submit" class="btn-back">Cancel Request</button>
                @elseif($commuterPickupLocation->status == 'rejected')
                    <p class="status-message status-rejected">Sorry! Your request has been rejected. Please try another Navigator... </p>
                @endif
            @else
                <div class="form-container">
                    <form action="{{ route('rides.join') }}" method="post">
                        @csrf
                        <input type="hidden" name="ride_id" value="{{ $ride->id }}">
                        <label for="pickup_location" style="font-weight: bold; font-size: 1.2em;">Enter the Route:</label><br>
                        <a href="#" target="_blank" id="google-maps-link" style="color:#00d5a9">[Use Google Maps to get route]</a> <!-- Added Google Maps link -->
                        <br>
                        <br>
                                      <!-- Popup Modal -->
<div id="maps-popup" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 70%; padding: 5%; background-color: #fff; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); z-index: 1000;">
    <h3 style="margin-top: 0; font-size: 2em; color: #333;">Get Route From Google</h3>
    <ol style="padding-left: 5%; color: #555; font-size: 1em; line-height: 1.6;">
        <li>Go to <a href="https://www.google.com/maps" target="_blank" style="color: #007bff; text-decoration: none;">Google Maps</a>.</li>
        <li>Enter your destination in the search bar.</li>
        <li>Click on the 'Directions' button.</li>
        <li>Enter your starting location.</li>
        <li>Click on share.</li>
        <li>Copy to clipboard.</li>
        <li>Paste in the route description field!</li>
    </ol>
    <button id="close-popup" style="display: block; margin: 15px auto 0; padding: 8px 16px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; transition: background-color 0.3s;">Close</button>
</div>
                        <textarea id="pickup_location" name="pickup_location" required placeholder="e.g., Shared route From (6.9205265,79.8618715) to Dehiwala Railway Station via Colombo......etc" rows="5" cols="50"></textarea>
                        <button type="submit" class="btn-confirm">Confirm Request</button>
                    </form>
                </div>
            @endif
        @elseif($ride->status == 'Ended')
            <p class="status-message status-rejected" style="margin-top: 2em;">The ride has ended.</p>
            <button onclick="window.location.href='{{ route('payment', ['ride_id' => $ride->id]) }}'"><b>Pay Your Payment</b></button>
        @endif

        @if($ride->status == 'Started')
        <script>
                // Function to refresh the page
                function refreshPage() {
                    location.reload();
                }

                // Set the page to refresh every 15 seconds
                setInterval(refreshPage, 15000);
            </script>
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
        <div class="buttons_">
        <p>Ride started at {{ \Carbon\Carbon::parse($ride->start_time)->setTimezone('Asia/Colombo')->format('Y-m-d (h:i:s A)') }}</p>
        <p>Ride duration: <span id="ride-timer" style="font-weight: bold;">{{ $formattedDuration }}</span></p>
        <button class="btn-chat" onclick="window.location.href='{{ route('chat.index', ['ride' => $ride->id]) }}'">Chat</button>
        @if($emergencyContact)
        <a href="tel:{{ $emergencyContact }}" class="btn-emergency">Emergency Call</a>
    @else
        <p class="btn-emergency">No emergency contact available.</p>
    @endif  
    <button id="report-button" class="btn-report">
        <i class="fas fa-exclamation-triangle"></i> Report
    </button>

    </div>
            <form action="{{ route('rides.endJourney', ['ride' => $ride->id]) }}" method="POST" onsubmit="return confirmEndJourney()">
                @csrf
                <button type="submit" class="btn-back">Cancel Pickup</button>
            </form>
        @endif

</div>

<script>

document.getElementById('report-button').addEventListener('click', function() {
            alert('User has been reported! This feature is under development...');
            // Implement the reporting functionality here
        });

    document.getElementById('google-maps-link').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent default anchor behavior
    document.getElementById('maps-popup').style.display = 'block'; // Show the popup
});

// Close popup when the close button is clicked
document.getElementById('close-popup').addEventListener('click', function() {
    document.getElementById('maps-popup').style.display = 'none'; // Hide the popup
});

function confirmEndJourney() {
        return confirm('Are you sure you want to cancel your pickup?'); // Shows a confirmation dialog
    }

    function confirmEndRequest() {
        return confirm('Are you sure you want to cancel your Request?'); // Shows a confirmation dialog
    }

function tohome() {
                window.location.href = '{{ route("home") }}';
}

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

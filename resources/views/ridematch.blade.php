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
        color: #333;
        margin: 0;
        padding: 20px;
        font-size: 1.2rem; /* Increased base font size */
    }

    h2 {
        font-size: 2em; /* Larger font size for headings */
        color: white;
        font-family: 'Krona One', sans-serif;
        margin: 5%;
        margin-bottom: 5%;
    }

    .headerkrona {
        font-size: 1.5em; /* Larger font size for headings */
        color: #2cc3a9;
        font-family: 'Krona One', sans-serif;
        margin-top: 0px;
        margin-bottom: 2em;
    }

    .headerkrona2 {
        font-size: 1.75em; /* Larger font size for headings */
        color: #848484;
        font-family: 'Krona One', sans-serif;
        margin-top: 0px;
        margin-bottom: 2em;
    }

    .headerkrona3 {
        font-size: 1.75em; /* Larger font size for headings */
        color: white;
        font-family: 'Krona One', sans-serif;
        margin-top: 0px;
        margin-bottom: 0.5em;
    }

    .headerkrona4 {
        font-size: 1.75em; /* Larger font size for headings */
        color: #848484;
        font-family: 'Krona One', sans-serif;
        margin-top: 0px;
        margin-bottom: 2em;

    }

    h1  {
        font-size: 4em; /* Larger font size for headings */
        color: #333;
        font-family: 'Krona One', sans-serif;
        margin-bottom:15%;
        margin-left: 2%;
        margin-left: 33.3%;
        margin-right: 33.3%;
        margin-top: 15%;
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

    .ride-description {
        margin: 1em 0;
        padding: 1em;
        background: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-weight: lighter;
        max-height: 400px; /* Adjust this height as needed */
        overflow-y: auto; /* Enable vertical scrolling */
        overflow-x: hidden; /* Prevent horizontal scrolling */
    }

    .shared-time,
    .shared-time-ago {
        display: block;
        margin: 0 0;
        font-size: 1.2em; /* Larger font size for timestamps */
    }

    .form-actions form {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-right: 1em; /* Increased margin for spacing */
    }

    button {
        background-color: #1e8573;
        border: none;
        color: white;
        padding: 1em 2em; /* Increased padding */
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 1.2em; /* Larger font size for buttons */
        margin: 0.5em 1em; /* Increased margin */
        border-radius: 4px;
        cursor: pointer;
    }

    button.btn-danger {
        background-color: #dc3545;
    }

    button:hover {
        opacity: 0.9;
    }

    .ride-status {
        font-weight: bold;
        font-size: 1.2em; /* Larger font size for status */
    }

    .no-pickup-locations {
        color: #666;
        font-style: italic;
        font-size: 1.2em; /* Larger font size for no pickup locations message */
    }

    hr {
        margin: 2em 0;
        border: 0;
        border-top: 1px solid #ddd;
    }

    .back-button {
    display: block;
    background-color: black; /* Changed to 'background-color' for consistency */
    color: white;
    border: none;
    padding: 20px 25px; /* Adjusted padding for a more balanced look */
    text-align: center;
    text-decoration: none;
    border-radius: 30px;
    cursor: pointer;
    max-width: 150px; /* Set a specific max width */
    font-size: 1.8em; /* Adjusted font size */
    position: fixed;
    top: 5%; /* Center vertically */
    left: 3%; /* Distance from the left side */
    transform: translateY(-50%); /* Center alignment adjustment */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Added shadow for better visibility */
    z-index: 1000; /* Ensures the button is above other elements */
    margin: 0;
}

.back-button:hover {
    background-color: #333; /* Slightly lighter on hover */
    opacity: 0.9;
}

    #cancel_button{
        background-color: #dc3545;
        min-width: 90%;
        font-size: 1em;
    }
    #bg_design{
        background-color: #27af97;
        padding: 2%;
        margin-right: 30%;
        margin-bottom: 5%;
    }
    .light_box{
        max-width: 35%;
        background-color: #1e8573;
        color: white;
        padding: 5%;
        padding-top: 5%;
        padding-bottom: 15%;
        border-radius: 5%;
    }
    .dark_box{
        max-width: 35%;
        background-color: black;
        color: white;
        padding: 5%;
        padding-top: 5%;
        padding-bottom: 15%;
        border-radius: 5%;
        font-size: smaller;
    }
    .black_box {
    max-width: 100%;
    background-color: black;
    color: white;
    padding: 5%;
    padding-top: 5%;
    padding-bottom: 15%;
    border-radius: 20px;
    font-size: smaller;
    margin-top: 10%;
    margin-bottom: 10%;
    display: flex; /* Enable flexbox */
    flex-direction:column; /* Stack items vertically */
    align-items: center; /* Center items horizontally */
    text-align: center; /* Center text horizontally */
}

    .in_a_row{
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }
    .wide_box{
        background: linear-gradient(to right, #1e8573, black);
        padding: 5%;
        margin-top: 10%;
        padding-top: 5%;
        font-size: smaller;
        display: flex; /* Enable flexbox */
        flex-direction:column; /* Stack items vertically */
        align-items: center; /* Center items horizontally */
        text-align: center; /* Center text horizontally */
        border-radius: 20px;
    }

    .container {
        min-width: 100%;
        margin: auto;
        font-size: 1.2rem; /* Increased font size */
        box-sizing: border-box;
    }

    .commuter-info {
    padding: 1em; /* Add padding for separation */
    margin-bottom: 1em; /* Adds space between commuters */
    border: 1px solid #ddd; /* Adds a light border */
    border-radius: 4px; /* Slight rounding of corners */
    background-color: #2e2e2e; /* Example background color */
}
.rows{
    display: flex;
    flex-direction: column;
}
</style>
</head>

@if(isset($sharedRides) && isset($pickupLocations) && isset($commuters))
<div class="container">
<h1>CARPO</h1>
<div id="bg_design">
    <h2>MY RIDE</h2>
    </div>
@foreach($sharedRides as $ride)
<div class="ride-container">
    <div class="in_a_row">
    <div class="light_box">
    <strong class="headerkrona">Vehicle</strong><br><br>
    <strong>Vehicle:</strong> {{ $ride->vehicle_model }} ({{ $ride->vehicle_number }})<br>
    <strong>Color:</strong> {{ $ride->vehicle_color }}<br>
    </div>

    <div class="dark_box">
    <strong class="headerkrona2">Details</strong><br><br>  
    <span class="shared-time"><strong>Shared on: </strong>{{ $ride->created_at->setTimezone('Asia/Colombo')->format('F j, Y, g:i a') }}</span>
    <span class="shared-time-ago">({{ $ride->created_at->setTimezone('Asia/Colombo')->diffForHumans() }})</span><br>
    <strong>Navigator ID:</strong> {{ $ride->navigator_id }}<br>
    <strong>Status:</strong> <span class="ride-status">{{ $ride->status }}</span><br>
    </div>
    </div>

    <div class="wide_box">
    <strong class="headerkrona3">Description</strong>
    <div class="ride-description" id="description-{{ $ride->id }}">{{ $ride->description }}</div>
    </div>
    
    <div class="black_box">
    <strong class="headerkrona4">Pickups</strong>
    <div class="rows">
    @php
        $locationsForRide = $pickupLocations->where('ride_id', $ride->id);
    @endphp
    @if($locationsForRide->isEmpty())
        <p class="no-pickup-locations">No pickup locations available.</p>
    @else
        @foreach($locationsForRide as $location)
            @php
                $commuter = $commuters->get($location->user_id);
            @endphp
            <div class="commuter-info">
            <p>
                {{ $location->pickup_location }} 
                (Commuter: {{ $commuter ? $commuter->name : 'Unknown' }}, 
                User ID: {{ $location->user_id }})
            </p>
            @if ($ride->status=='Accepted')
            <button class="btn-chat" onclick="window.location.href='{{ route('chat.index', ['ride' => $ride->id]) }}'">Chat</button>
            @endif
            </div>
            <hr>
        @endforeach
    </div>
        </div>

        <div class="form-actions">
            @if($ride->status == 'Pending')
                <form action="{{ route('rides.accept', $ride->id) }}" method="POST">
                    @csrf
                    <button type="submit">Accept Commuter</button>
                </form>
                <form action="{{ route('rides.reject', $ride->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-danger">Reject Commuter</button>
                </form>
            @elseif($ride->status == 'Accepted')
                <form action="{{ route('rides.start', $ride->id) }}" method="POST">
                    @csrf
                    <button type="submit">Start Ride</button>
                </form>
            @elseif($ride->status == 'Started')
                @php
                    $startTime = \Carbon\Carbon::parse($ride->start_time)->setTimezone('Asia/Colombo');
                    $currentTime = \Carbon\Carbon::now()->setTimezone('Asia/Colombo');
                    $duration = $startTime->diff($currentTime);
                    $formattedDuration = $duration->format('%H:%I:%S');
                @endphp
                <p>Ride started at {{ \Carbon\Carbon::parse($ride->start_time)->setTimezone('Asia/Colombo')->format('Y-m-d h:i:s A') }}.</p>
                <p>Ride duration: <span id="ride-timer">{{ $formattedDuration }}</span></p>
                <form action="{{ route('rides.end', $ride->id) }}" method="POST" id="end-ride-form">
                    @csrf
                    <button type="submit" class="btn btn-danger">End Ride</button>
                </form>
            @elseif($ride->status == 'Rejected')
                <p>Ride rejected.</p>
            @endif
        </div>
    @endif
</div>
@if($ride->status == 'Ended')
    <p>Your ride has ended.</p>
    <strong>Duration: </strong> {{ $ride->duration }}<br>
@endif   
<form action="{{ route('rides.delete', $ride->id) }}" method="post" onsubmit="return confirm('Are you sure you want to Cancel this Ride Sharing?');">
    @csrf
    @method('DELETE')
    <button id="cancel_button" type="submit">Cancel Ride Sharing</button>
</form>
<hr>
@endforeach
@endif
<button onclick="history.back()" class="back-button">&larr;</button>

<script>

    
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

    function convertToClickableLinks(text) {
        return text.replace(
            /https:\/\/maps\.app\.goo\.gl\/[^\s]+/g,
            (url) => `<a href="${url}" target="_blank">${url}</a>`
        );
    }

    function formatRouteDescription(text) {
        const patterns = {
            sharedRoute: /^Shared route\s*$/m,
            fromToVia: /From (.*?) to (.*?) via (.*?)\./,
            duration: /(\d+ min \(.*?\))/,
            traffic: /(\d+ min in current traffic)/,
            steps: /(?<=current traffic)([\s\S]*?)(?=For the best route)/g,
            mapLink: /https:\/\/maps\.app\.goo\.gl\/[^\s"']+/
        };

        const extract = (pattern) => (text.match(pattern) || [])[0] || '';

        const sharedRoute = extract(patterns.sharedRoute).trim();
        const fromToViaMatch = text.match(patterns.fromToVia) || [];
        const from = fromToViaMatch[1]?.trim() || '';
        const to = fromToViaMatch[2]?.trim() || '';
        const via = fromToViaMatch[3]?.trim() || '';
        const duration = extract(patterns.duration).trim();
        const traffic = extract(patterns.traffic).trim();
        const steps = text.match(patterns.steps) || [];
        const mapLink = extract(patterns.mapLink).trim();

        if (!sharedRoute && !from && !to && !via && !duration && !traffic && steps.length === 0 && !mapLink) {
            return { rawDescription: text };
        }

        return {
            sharedRoute,
            from,
            to,
            via,
            duration,
            traffic,
            steps,
            mapLink
        };
    }

    function displayRouteDescription(data, descriptionElement) {
    if (data.rawDescription) {
        descriptionElement.innerHTML = `<p>${convertToClickableLinks(data.rawDescription)}</p>`;
        return;
    }

    // Format each step in the route description to be on a new line
    const formattedSteps = data.steps.map(step => {
        // Split steps into individual lines based on numbers or bullet points
        return step.replace(/(\d+\.\s)/g, '<br>$1').split('<br>').map(line => `<p>${line.trim()}</p>`).join('');
    }).join('');

    descriptionElement.innerHTML = `
        <h2>${data.sharedRoute}</h2>
        ${data.from ? `<p><strong>From:</strong> ${data.from}</p>` : ''}
        ${data.to ? `<p><strong>To:</strong> ${data.to}</p>` : ''}
        ${data.via ? `<p><strong>Via:</strong> ${data.via}</p>` : ''}
        ${data.duration ? `<p><strong>Duration:</strong> ${data.duration}</p>` : ''}
        ${data.traffic ? `<p><strong>Current Traffic:</strong> ${data.traffic}</p>` : ''}
        ${formattedSteps}
        ${data.mapLink ? `<p><a href="${data.mapLink}" target="_blank">${data.mapLink}</a></p>` : ''}
    `;
}
    
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

            timerInterval = setInterval(updateTimer, 1000);

    document.getElementById('end-ride-form').addEventListener('submit', function(event) {
        clearInterval(timerInterval);
        alert('Ride ended. Duration: ' + timerElement.innerHTML);
    });
        @endif
    });
    function setStartTime() {
        const now = new Date();
        const formattedTime = now.toLocaleString('en-US', { 
            timeZone: 'Asia/Colombo', 
            hour: '2-digit', 
            minute: '2-digit', 
            hour12: true 
        });
        document.getElementById('start-time').value = formattedTime;
    }

    // Function to format the timestamp into "time ago"
    function formatTimeAgo(dateString) {
        const date = new Date(dateString);
        const now = new Date();
        const timeDifference = now - date;
        
        const seconds = Math.floor(timeDifference / 1000);
        const minutes = Math.floor(seconds / 60);
        const hours = Math.floor(minutes / 60);
        const days = Math.floor(hours / 24);

        if (days > 0) {
            return days + ' day' + (days > 1 ? 's' : '') + ' ago';
        } else if (hours > 0) {
            return hours + ' hour' + (hours > 1 ? 's' : '') + ' ago';
        } else if (minutes > 0) {
            return minutes + ' minute' + (minutes > 1 ? 's' : '') + ' ago';
        } else {
            return seconds + ' second' + (seconds > 1 ? 's' : '') + ' ago';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
       
        // Existing code to format descriptions
        document.querySelectorAll('.ride-description').forEach(descriptionElement => {
            const rawDescription = descriptionElement.innerText;
            const formattedData = formatRouteDescription(rawDescription);
            displayRouteDescription(formattedData, descriptionElement);
        });
    });
</script>

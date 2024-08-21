<head>
<link href="https://fonts.googleapis.com/css2?family=Krona+One&display=swap" rel="stylesheet">
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
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
    }

    .shared-time,
    .shared-time-ago {
        display: block;
        margin: 0.5em 0;
        font-size: 1.2em; /* Larger font size for timestamps */
    }

    .form-actions form {
        display: inline;
        margin-right: 1em; /* Increased margin for spacing */
    }

    button {
        background-color: #007bff;
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
        margin: 2em 0;
        background: #007bff;
        color: white;
        border: none;
        padding: 1em 2em; /* Increased padding */
        text-align: center;
        text-decoration: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 1.2em; /* Larger font size for back button */
    }

    .back-button:hover {
        opacity: 0.9;
    }
    #cancel_button{
        background-color: #dc3545;
    }
    #bg_design{
        background-color: #27af97;
        padding: 2%;
        margin-right: 30%;
        margin-bottom: 5%;
    }
</style>
</head>

@if(isset($sharedRides) && isset($pickupLocations) && isset($commuters))
<h1>CARPO</h1>
<div id="bg_design">
    <h2>MY RIDE</h2>
    </div>
@foreach($sharedRides as $ride)
<div class="ride-container">
    <strong>Vehicle:</strong> {{ $ride->vehicle_model }} ({{ $ride->vehicle_number }})<br>
    <strong>Color:</strong> {{ $ride->vehicle_color }}<br>
    <strong>Description:</strong>
    <div class="ride-description" id="description-{{ $ride->id }}">{{ $ride->description }}</div>
    
    <span class="shared-time"><strong>Shared on: </strong>{{ $ride->created_at->setTimezone('Asia/Colombo')->format('F j, Y, g:i a') }}</span>
    <span class="shared-time-ago">({{ $ride->created_at->setTimezone('Asia/Colombo')->diffForHumans() }})</span><br>
    <strong>Navigator ID:</strong> {{ $ride->navigator_id }}<br>
    <strong>Status:</strong> <span class="ride-status">{{ $ride->status }}</span><br>
    <strong>Pickup Locations:</strong>
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
            <p>
                {{ $location->pickup_location }} 
                (Commuter: {{ $commuter ? $commuter->name : 'Unknown' }}, 
                User ID: {{ $location->user_id }})
            </p>
        @endforeach

        <div class="form-actions">
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
<button onclick="history.back()" class="back-button">&larr; Back</button>

<script>
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

        descriptionElement.innerHTML = `
            <h2>${data.sharedRoute}</h2>
            ${data.from ? `<p><strong>From:</strong> ${data.from}</p>` : ''}
            ${data.to ? `<p><strong>To:</strong> ${data.to}</p>` : ''}
            ${data.via ? `<p><strong>Via:</strong> ${data.via}</p>` : ''}
            ${data.duration ? `<p><strong>Duration:</strong> ${data.duration}</p>` : ''}
            ${data.traffic ? `<p><strong>Current Traffic:</strong> ${data.traffic}</p>` : ''}
            ${data.steps.length ? `<p><strong>Steps:</strong>${data.steps.map(step => step.replace(/^\d+\.\s*/, '')).join('<br>')}</p>` : ''}
            ${data.mapLink ? `<p>For the best route in current traffic<br> <strong>Visit: </strong> <a href="${data.mapLink}">${data.mapLink}</a></p>` : ''}
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

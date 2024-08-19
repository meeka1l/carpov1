@if(isset($sharedRides) && isset($pickupLocations) && isset($commuters))
<!-- Rides where the logged-in user is the navigator -->

<h2>My Rides as Navigator</h2>
@foreach($sharedRides as $ride)
    <div class="ride-details">
        <strong>Vehicle:</strong> {{ $ride->vehicle_model }} ({{ $ride->vehicle_number }})<br>
        <strong>Color:</strong> {{ $ride->vehicle_color }}<br>
        <strong>Description:</strong>
        <div class="ride-description" id="description-{{ $ride->id }}">{{ $ride->description }}</div>
        
        <span class="shared-time"><strong>Shared on: </strong>{{ $ride->created_at->setTimezone('Asia/Colombo')->format('F j, Y, g:i a') }}</span>

        <span class="shared-time-ago">({{ $ride->created_at->setTimezone('Asia/Colombo')->diffForHumans() }})</span><br>
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

          @if($ride->status == 'Pending')
    <form action="{{ route('rides.accept', $ride->id) }}" method="POST" style="display: inline;">
        @csrf
        <button type="submit">Accept Ride</button>
    </form>
    <form action="{{ route('rides.reject', $ride->id) }}" method="POST" style="display: inline;">
        @csrf
        <button type="submit">Reject Ride</button>
    </form>
    @elseif($ride->status == 'Accepted')
    <form action="{{ route('rides.start', $ride->id) }}" method="POST" style="display: inline;">
        @csrf
        <button type="submit">Start Ride</button>
    </form>
            @elseif($ride->status == 'Started')
            @php
                // Convert the start time to the desired timezone
                $startTime = \Carbon\Carbon::parse($ride->start_time)->setTimezone('Asia/Colombo');
                $currentTime = \Carbon\Carbon::now()->setTimezone('Asia/Colombo');

                // Calculate the duration
                $duration = $startTime->diff($currentTime);

                // Format the duration
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
        @endif
    </div>
@if($ride->status == 'Ended')
    <p>Your ride has ended.</p>
    <strong>Duration: </strong> {{ $ride->duration }}<br>
@endif   
    <form action="{{ route('rides.delete', $ride->id) }}" method="post" onsubmit="return confirm('Are you sure you want to Cancel this Ride Sharing?');">
        @csrf
        @method('DELETE')
        <button type="submit">Cancel Ride Sharing</button>
    </form>
    <hr>
@endforeach
@endif
<button onclick="history.back()" style="margin-bottom: 20px;">&larr; Back</button>

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

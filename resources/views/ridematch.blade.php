@if(isset($sharedRides) && isset($pickupLocations) && isset($commuters))
<!-- Rides where the logged-in user is the navigator -->
<h2>My Rides as Navigator</h2>
@foreach($sharedRides as $ride)
    <div class="ride-details">
        <strong>Vehicle:</strong> {{ $ride->vehicle_model }} ({{ $ride->vehicle_number }})<br>
        <strong>Color:</strong> {{ $ride->vehicle_color }}<br>
        <strong>Description:</strong>
        <div class="ride-description" id="description-{{ $ride->id }}">{{ $ride->description }}</div>

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

            <!-- Accept/Reject Buttons -->
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
                <p>Ride accepted.</p>
            @elseif($ride->status == 'Rejected')
                <p>Ride rejected.</p>
            @endif
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
@endif

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

    document.querySelectorAll('.ride-description').forEach(descriptionElement => {
        const rawDescription = descriptionElement.innerText;
        const formattedData = formatRouteDescription(rawDescription);
        displayRouteDescription(formattedData, descriptionElement);
    });
</script>

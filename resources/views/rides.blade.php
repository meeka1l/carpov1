<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commuter Page</title>
    <style>
        /* General Styles */
        .commuter-page {
            font-family: Arial, sans-serif;
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .lightertext{
            text-align: center;
            color: gray;
            margin-bottom: 10px;
            font-size: 0.8em;
        }

        /* Search Input */
        #search {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        /* Ride List */
        #ride-list {
            list-style-type: none;
            padding: 0;
            max-height: 400px; /* Adjust this height as needed */
            overflow-y: auto; /* Enable vertical scrolling */
            overflow-x: hidden; /* Prevent horizontal scrolling */
        }

        #ride-list li {
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 15px;
            margin-bottom: 10px;
            transition: background 0.3s;
        }

        #ride-list li:hover {
            background: #f1f1f1;
        }

        /* Ride Details */
        #ride-list strong {
            color: #555;
        }

        .ride-description {
            color: #333; /* Text color for descriptions */
            word-wrap: break-word;
        }

        /* Description Links */
        .ride-description a {
            color: #007bff; /* Distinct color for links */
            text-decoration: none;
        }

        .ride-description a:hover {
            text-decoration: underline;
        }

        /* Form Styles */
        form {
            margin-top: 10px;
        }

        /* Map Container */
        #map {
            margin-top: 20px;
            height: 300px;
            background: #ddd;
            border-radius: 4px;
        }

        /* Disabled Class */
        .disabled {
            pointer-events: none;
            opacity: 0.6;
        }

        /* Shared Time */
        .shared-time {
            font-size: 0.9em;
            color: #888;
            margin-top: 5px;
        }
        .strong_header{
            font-family: "Krona one";
        }
    </style>
</head>
<body>
    <section class="commuter-page" id="commuter-page">
        <h2>Available Rides</h2>
        <h3 class="lightertext">Type a nearby location or road to find navigators with similar routes</h3>
        <input type="text" id="search" placeholder="e.g., Kolonnawa Rd">

        <ul id="ride-list">
            @foreach($rides as $ride)
            <li>
                <strong class="strong_header">Navigator Details</strong><br><br>
                <strong>{{ $ride->user_name }}</strong><br><br>
                <strong>{{ $ride->email }}</strong><br><br><br>
                <strong class="strong_header">Vehicle Details</strong><br><br>
                <strong>Vehicle:</strong> {{ $ride->vehicle_model }} ({{ $ride->vehicle_number }})<br><br>
                <strong>Color:</strong> {{ $ride->vehicle_color }}<br><br><br>
                <strong class="strong_header">Route Details</strong><br><br>
                <span class="ride-description">{{ $ride->description }}</span><br>
                <span class="shared-time">Shared on: {{ $ride->created_at->setTimezone('Asia/Colombo')->format('F j, Y, g:i a') }}</span>
                <br>
                <span class="shared-time">Shared {{ $ride->created_at->setTimezone('Asia/Colombo')->diffForHumans() }}</span>
                <!-- Display the shared time -->
                <form action="{{ route('rides.join') }}" method="POST">
                    @csrf
                    <input type="hidden" name="ride_id" value="{{ $ride->id }}">
                    <input type="hidden" id="pickup_location_{{ $ride->id }}" name="pickup_location" required>
                     @if($ride->status == 'Started')
                    <a href="{{ route('rides.request', ['ride_id' => $ride->id]) }}" class="btn btn-primary">View Ride</a>
                    @elseif($ride->status == 'Ended')
                    <a href="{{ route('rides.request', ['ride_id' => $ride->id]) }}" class="btn btn-primary">View Ride Details</a>
                    @else
                    <a href="{{ route('rides.request', ['ride_id' => $ride->id]) }}" class="btn btn-primary">Join Ride</a>
                   @endif
                </form>
            </li>
            @endforeach
            
        </ul>

        
    </section>

    <script>
        function convertToClickableLinks(text) {
            return text.replace(
                /https:\/\/maps\.app\.goo\.gl\/[^\s]+/g,
                (url) => `<a href="${url}" target="_blank">${url}</a>`
            );
        }

        function formatRouteDescription(text) {
            // Define patterns to match each part
            const patterns = {
                sharedRoute: /^Shared route\s*$/m,
                fromToVia: /From (.*?) to (.*?) via (.*?)\./,
                duration: /(\d+ min \(.*?\))/,
                traffic: /(\d+ min in current traffic)/,
                steps: /(?<=current traffic)([\s\S]*?)(?=For the best route)/g,
                mapLink: /https:\/\/maps\.app\.goo\.gl\/[^\s"']+/
            };

            // Extract the matched parts
            const extract = (pattern) => (text.match(pattern) || [])[0] || '';

            // Use the defined patterns to extract the data
            const sharedRoute = extract(patterns.sharedRoute).trim();
            const fromToViaMatch = text.match(patterns.fromToVia) || [];
            const from = fromToViaMatch[1]?.trim() || '';
            const to = fromToViaMatch[2]?.trim() || '';
            const via = fromToViaMatch[3]?.trim() || '';
            const duration = extract(patterns.duration).trim();
            const traffic = extract(patterns.traffic).trim();
            const steps = text.match(patterns.steps) || [];
            const mapLink = extract(patterns.mapLink).trim();

            // Fallback to raw description if no specific format is matched
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
                descriptionElement.innerHTML = `<p>${data.rawDescription}</p>`;
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

        document.addEventListener('DOMContentLoaded', function() {
            const rideDescriptions = document.querySelectorAll('.ride-description');

            rideDescriptions.forEach(description => {
                const formattedText = convertToClickableLinks(description.textContent);
                const routeData = formatRouteDescription(formattedText);
                displayRouteDescription(routeData, description);
            });

            document.getElementById('search').addEventListener('input', function() {
                const query = this.value;

                fetch(`/rides/search?query=${query}`)
                    .then(response => response.json())
                    .then(data => {
                        const rideList = document.getElementById('ride-list');
                        rideList.innerHTML = '';

                        data.forEach(ride => {
                            const descriptionWithLinks = convertToClickableLinks(ride.description);
                            const routeData = formatRouteDescription(descriptionWithLinks);
                            const li = document.createElement('li');
                            li.innerHTML = `
                                <strong>Vehicle:</strong> ${ride.vehicle_model} (${ride.vehicle_number})<br>
                                <strong>Color:</strong> ${ride.vehicle_color}<br>
                                <strong>Description:</strong> <span class="ride-description"></span><br>
                                <span class="shared-time">Shared on: ${new Date(ride.created_at).toLocaleString()}</span> <!-- Display the shared time -->
                                <form action="/rides/join" method="POST">
                                    <input type="hidden" name="ride_id" value="${ride.id}">
                                    <input type="hidden" id="pickup_location_${ride.id}" name="pickup_location" required>
                                    <button type="submit" onclick="setPickupLocation(${ride.id})">Join Ride</button>
                                </form>
                            `;
                            const descriptionElement = li.querySelector('.ride-description');
                            displayRouteDescription(routeData, descriptionElement);
                            rideList.appendChild(li);
                        });
                    });
            });

            function setPickupLocation(rideId) {
                // Assuming you have a way to determine the pickup location, set it here
                // For example, you might prompt the user or get it from a predefined value
                var pickupLocation = "Some predefined location"; // Replace with actual logic
                document.getElementById(`pickup_location_${rideId}`).value = pickupLocation;
            }
        });
    </script>
</body>
</html>

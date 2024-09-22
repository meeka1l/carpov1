<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Krona+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    
<style>
    #cancel_button {
        padding: 10px 20px;
        background: linear-gradient(to right, #ff8c00, #ffa500);
        color: white;
        font-weight: bold;
        border: none;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        cursor: pointer;
        transition: background 0.3s ease, transform 0.3s ease;
        margin-left: 30%;
        margin-top:5%;
    }

    #cancel_button:hover {
        background: linear-gradient(to right, #e55353, #ff6347);
        transform: scale(1.05);
    }

    #cancel_button:focus {
        outline: none;
        box-shadow: 0 0 0 4px rgba(255, 140, 0, 0.4);
    }
    .headfont{
        font-family: 'Krona One', sans-serif;
        font-size: 2.5em;
        margin-bottom: 20%;
        margin-left: 17%;
    }
    .commuter-container {
        display: flex;
    flex-direction: column;
    padding: 5%;
    border-radius: 30px;
    align-items: center;
    margin-bottom: 5% !important;
    margin-top: 5% !important;
    background: #c7c7c7;
    transition: max-height 0.3s ease;
    overflow: hidden;
}


.driver_route{
    background-color: #333333;
    color: white;
    padding: 5%;
    border-radius: 30px;
}
h2{
    font-family: 'Krona One';
}


.info_block {
    display: flex;
    flex-direction: column;
    padding: 5%;
    border-radius: 30px;
    align-items: center;
    margin-bottom: 5%;
    background: #c7c7c7;
    transition: max-height 0.3s ease;
    overflow: hidden;
}

.hidden {
    display: none;
}

.cursor-pointer {
    cursor: pointer;
}
.cost_block{
    display: flex;
    flex-direction: column;
    background-color: #f8db76;
    padding: 5%;
    border-radius: 30px;
    align-items: center;
}
.rotate {
    transform: rotate(180deg);
    transition: transform 0.3s ease;
}
</style>
</head>

<body class="text-gray-900">

    <div class="max-w-xl mx-auto p-6 bg-white shadow-lg rounded-lg mt-10">
        <h1 class="headfont">Payment Details</h1>

        <div class="space-y-2">
    <!-- Description -->
     <div class="driver_route">
     <h2>Navigator Route:</h2>
    <p class="text-lg"> 
        <span id="description" class="font-semibold">{{$description}}</span>
        <span id="extra-description" class="hidden"></span>
        <button class="text-blue-500 ml-2 hidden" id="toggle-description" onclick="toggleContent('description', this)">Show More</button>
    </p>
    </div>
    <div class="commuter-container">
   <!-- Commuter Routes Header with Toggle -->
   <h2 class="text-xl font-bold cursor-pointer" onclick="toggleCommuterDetails()">
       Commuter Routes <i id="arrow-icon" class="fas fa-chevron-down"></i>
   </h2>
   
   <!-- Commuter Details Section -->
   <div id="commuter-details" class="hidden">
       <!-- Commuter 1 Description -->
       <p class="text-lg">
           {{ $commuter_names[1] ?? 'Commuter 1' }}'s Route: 
           <span id="distance1d" class="font-semibold">{{ $user_descriptions[1] ?? 'N/A' }}</span>
           <span id="extra-distance1" class="hidden">Additional details here...</span>
           <button class="text-blue-500 ml-2" id="toggle-distance1" onclick="toggleContent('extra-distance1', this)">Show More</button>
       </p>

       <!-- Commuter 2 Description -->
       <p class="text-lg">
           {{ $commuter_names[2] ?? 'Commuter 2' }}'s Route: 
           <span id="distance2d" class="font-semibold">{{ $user_descriptions[2] ?? 'N/A' }}</span>
           <span id="extra-distance2" class="hidden">Additional details here...</span>
           <button class="text-blue-500 ml-2" id="toggle-distance2" onclick="toggleContent('extra-distance2', this)">Show More</button>
       </p>

       <!-- Commuter 3 Description -->
       <p class="text-lg">
           {{ $commuter_names[3] ?? 'Commuter 3' }}'s Route: 
           <span id="distance3d" class="font-semibold">{{ $user_descriptions[3] ?? 'N/A' }}</span>
           <span id="extra-distance3" class="hidden">Additional details here...</span>
           <button class="text-blue-500 ml-2" id="toggle-distance3" onclick="toggleContent('extra-distance3', this)">Show More</button>
       </p>
   </div>
</div>


</div>

        <!-- Distance Section -->
<div class="info_block">
    <h2 class="text-xl font-bold cursor-pointer" onclick="toggleDetails()">
    Distance Details <i id="arrow-icon2" class="fas fa-chevron-down"></i>
    </h2>
    
    <div id="details" class="hidden">
        <p>Navigator Distance: <span id="distance" class="font-semibold">20</span> km</p>
        <p>Commuter1 Distance: <span id="distance1" class="font-semibold">10</span> km</p>
        <p>Commuter2 Distance: <span id="distance2" class="font-semibold">15</span> km</p>
        <p>Commuter3 Distance: <span id="distance3" class="font-semibold">25</span> km</p>
    </div>
</div>

        <!-- Commuter Totals -->
        <div class="cost_block">
            <h2 class="text-xl font-bold">Commuter Costs</h2>
            <p>Commuter1 Total: <span id="commuter1t" class="font-semibold"></span> LKR</p>
            <p>Commuter2 Total: <span id="commuter2t" class="font-semibold"></span> LKR</p>
            <p>Commuter3 Total: <span id="commuter3t" class="font-semibold"></span> LKR</p>
        </div>

        <!-- Total Cost Section -->
        <div class="mt-6">
            <p class="text-lg font-bold">Total Cost for Commuters: <span id="totalCost" class="text-green-600"></span> LKR</p>
        </div>

        <!-- Button -->
        <!-- Button -->
<form action="{{ route('rides.delete', $ride->id) }}" method="post" onsubmit="return confirm('Are you sure you want to Cancel this Ride Sharing?');">
    @csrf
    @method('DELETE')
    <button id="cancel_button" type="submit">To Home Page</button>
</form>


    </div>


    <script>
    function toggleCommuterDetails() {
    var details = document.getElementById('commuter-details');
    var arrowIcon = document.getElementById('arrow-icon');

    // Toggle the visibility of the commuter details section
    if (details.classList.contains("hidden")) {
        details.classList.remove("hidden");
        arrowIcon.classList.add("rotate"); // Rotate arrow upwards
    } else {
        details.classList.add("hidden");
        arrowIcon.classList.remove("rotate"); // Rotate arrow downwards
    }
}

        function toggleDetails() {
    var details = document.getElementById("details");
    var arrowIcon = document.getElementById('arrow-icon2');
    if (details.classList.contains("hidden")) {
        details.classList.remove("hidden");
        arrowIcon.classList.add("rotate"); // Rotate arrow upwards
    } else {
        details.classList.add("hidden");
        arrowIcon.classList.remove("rotate"); // Rotate arrow downwards
    }
}
        // Get the description from the Blade template
        var description = document.getElementById('description').innerText;
        var distance1 = document.getElementById('distance1d').innerText;
        var distance2 = document.getElementById('distance2d').innerText;
        var distance3 = document.getElementById('distance3d').innerText;

        // Define the regex pattern to match a number followed by "km"
        var pattern = /(\d+(\.\d+)?)(?=\s*km)/;

        // Perform the regex match
        var matches = description.match(pattern);
        var distance1 = distance1.match(pattern);
        var distance2 = distance2.match(pattern);
        var distance3 = distance3.match(pattern);

        // Extract the distance if a match is found
        var distance = matches ? parseFloat(matches[1]) : 0;
        var distancec1 = distance1 ? parseFloat(distance1[1]) : 0;
        var distancec2 = distance2 ? parseFloat(distance2[1]) : 0;
        var distancec3 = distance3 ? parseFloat(distance3[1]) : 0;
        


        // Display the distance in the HTML
        document.getElementById('distance').innerText = distance;
        document.getElementById('distance1').innerText = distancec1;
        document.getElementById('distance2').innerText = distancec2;
        document.getElementById('distance3').innerText = distancec3;

        
        // Declare distances for commuters
        var Commuter1Distance = distancec1; // Example value, replace with actual
        var Commuter2Distance = distancec2; // Example value, replace with actual
        var Commuter3Distance = distancec3; // Example value, replace with actual

        // Calculate total distance of commuters
        var TotalCommutersDistance = Commuter1Distance + Commuter2Distance + Commuter3Distance;

        // Declare Average Mileage Fuel Value (AMFV) and cost variables
        var AMFV = 300 / 10; // Adjust as necessary
        var TotalCost = TotalCommutersDistance * AMFV;

        // Get the navigator's distance passed in from the server
        var NavigatorDistance = distance; // Use the passed distance_km value from the server

        // Default RDD (Ride Distance Divider) value
        var RDD = 1;

        // Adjust RDD based on the range of TotalCommutersDistance
        if (TotalCommutersDistance >= 0.5 * NavigatorDistance && TotalCommutersDistance <= NavigatorDistance) {
            RDD = 1.5;
        } else if (TotalCommutersDistance > NavigatorDistance && TotalCommutersDistance <= 2 * NavigatorDistance) {
            RDD = 2;
        } else if (TotalCommutersDistance > 2 * NavigatorDistance && TotalCommutersDistance <= 3 * NavigatorDistance) {
            RDD = 3;
        } else if (TotalCommutersDistance > 3 * NavigatorDistance && TotalCommutersDistance <= 4 * NavigatorDistance) {
            RDD = 4;
        }

        // Calculate the cost for each commuter based on their distance and RDD
        var commuter1tot = (TotalCost / NavigatorDistance) * (Commuter1Distance / RDD);
        var commuter2tot = (TotalCost / NavigatorDistance) * (Commuter2Distance / RDD);
        var commuter3tot = (TotalCost / NavigatorDistance) * (Commuter3Distance / RDD);

        // Sum up the total cost for all commuters
        var Total = commuter1tot + commuter2tot + commuter3tot;

        // Display the total in the span element
        document.getElementById("totalCost").textContent = Total.toFixed(2); // Rounded to 2 decimal places
        document.getElementById('distance1').innerText = Commuter1Distance;
        document.getElementById('distance2').innerText = Commuter2Distance;
        document.getElementById('distance3').innerText = Commuter3Distance;

        document.getElementById('commuter1t').innerText = commuter1tot;
        document.getElementById('commuter2t').innerText = commuter2tot;
        document.getElementById('commuter3t').innerText = commuter3tot;

        // Function to truncate content and show the 'Show More' button
    function truncateContent(id, buttonId) {
        var contentSpan = document.getElementById(id);
        var fullText = contentSpan.textContent.trim();

        // Store the full text in a custom data attribute
        contentSpan.setAttribute('data-full-text', fullText);

        // Only truncate if the text is longer than 100 characters
        if (fullText.length > 100) {
            var truncatedText = fullText.slice(0, 100) + "...";
            contentSpan.textContent = truncatedText;

            // Show the "Show More" button
            document.getElementById(buttonId).classList.remove('hidden');
        }
    }

    // Function to toggle between showing truncated and full content
    function toggleContent(id, btn) {
        var contentSpan = document.getElementById(id);
        var fullText = contentSpan.getAttribute('data-full-text');
        var isTruncated = contentSpan.getAttribute('data-truncated') === 'true';

        // Toggle between full and truncated text
        if (isTruncated) {
            contentSpan.textContent = fullText;  // Show full content
            btn.textContent = "Show Less";       // Change button text
            contentSpan.setAttribute('data-truncated', 'false');
        } else {
            contentSpan.textContent = fullText.slice(0, 100) + "...";  // Show truncated content
            btn.textContent = "Show More";                             // Change button text
            contentSpan.setAttribute('data-truncated', 'true');
        }
    }

    // Initialize truncation for each content
    truncateContent('description', 'toggle-description');
    truncateContent('distance1d', 'toggle-distance1');
    truncateContent('distance2d', 'toggle-distance2');
    truncateContent('distance3d', 'toggle-distance3');

 </script>
</body>
</html>

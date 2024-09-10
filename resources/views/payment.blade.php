<!DOCTYPE html>
<html>
<head>
    <title>Payment</title>
</head>
<body>
    <!-- Span to display the total -->
     <p>Description : <span id="description">{{$description}}</span></p>
     <p>Navigator Distance: <span id="distance"></span></p>
     <p>Commuter1 Distance: <span id="distance1"></span></p>
     <p>Commuter2 Distance: <span id="distance2"></span></p>
     <p>Commuter3 Distance: <span id="distance3"></span></p>

     <p>Commuter1 Total: <span id="commuter1t"></span></p>
     <p>Commuter2 Total: <span id="commuter2t"></span></p>
     <p>Commuter3 Total: <span id="commuter3t"></span></p>
    <p>Total Cost for Commuters: <span id="totalCost"></span></p>

    <script>
        // Get the description from the Blade template
        var description = document.getElementById('description').innerText;

        // Define the regex pattern to match a number followed by "km"
        var pattern = /(\d+(\.\d+)?)(?=\s*km)/;

        // Perform the regex match
        var matches = description.match(pattern);

        // Extract the distance if a match is found
        var distance = matches ? parseFloat(matches[1]) : 0;

        // Display the distance in the HTML
        document.getElementById('distance').innerText = distance;

        
        // Declare distances for commuters
        var Commuter1Distance = 2.5; // Example value, replace with actual
        var Commuter2Distance = 5; // Example value, replace with actual
        var Commuter3Distance = 7.5; // Example value, replace with actual

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
        document.getElementById('commuter3t').innerText = commuter3tot

 </script>
</body>
</html>
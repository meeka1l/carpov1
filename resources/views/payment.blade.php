<?php
var TotalCommutersDistance = 0;
var Commuter1Distance = 0;
var Commuter2Distance = 0;
var Commuter3Distance = 0;
TotalCommutersDistance = Commuter1Distance + Commuter2Distance + Commuter3Distance;
var AMFV = 300/10; // Average Mileage Fuel Value
var TotalCost = 0;
TotalCost = TotalCommutersDistance * AMFV;

var Total = 0;
var commuter1tot = 0;
var commuter2tot = 0;
var commuter3tot = 0;
var NavigatorDistance = 0;
var RDD = 1; // Default RDD value

// Check the range of TotalCommutersDistance and set RDD accordingly
if (TotalCommutersDistance >= 0.5 * NavigatorDistance && TotalCommutersDistance <= NavigatorDistance) {
    RDD = 1.5;
} else if (TotalCommutersDistance > NavigatorDistance && TotalCommutersDistance <= 2 * NavigatorDistance) {
    RDD = 2;
} else if (TotalCommutersDistance > 2 * NavigatorDistance && TotalCommutersDistance <= 3 * NavigatorDistance) {
    RDD = 3;
} else if (TotalCommutersDistance > 3 * NavigatorDistance && TotalCommutersDistance <= 4 * NavigatorDistance) {
    RDD = 4;
}

commuter1tot = (TotalCost / NavigatorDistance) * (Commuter1Distance / RDD);
commuter2tot = (TotalCost / NavigatorDistance) * (Commuter2Distance / RDD);
commuter3tot = (TotalCost / NavigatorDistance) * (Commuter3Distance / RDD);
Total = commuter1tot + commuter2tot + commuter3tot;
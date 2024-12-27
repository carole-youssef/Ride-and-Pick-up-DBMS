<?php

echo "<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #e0f7fa;
        margin: 0;
        padding: 20px;
        text-align: center;
    }
    h2 {
        color: #007bb8;
        margin-top: 20px; 
        font-size: 1.5em;
    }
    .first-heading {
        color: #007bb8;
        margin-top: 140px; 
        font-size: 1.5em;
    }
    table {
        width: 80%;
        margin: 20px auto;
        border-collapse: collapse;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: #007BFF; 
        color: #0d1950; 
    }
    th, td {
        padding: 12px 15px;
        text-align: center; 
        font-size: 1em;
    }
    .table-container {
        margin-top: 20px;
    }
</style>";

// Include the database connection file
include 'db.php';

// Query 1: Union of Drivers Who Are Active or Joined After 2022
$sql1 = "SELECT driver_ID, d_fullname, d_status, join_date 
         FROM Driver 
         WHERE d_status = 'Active' 
         UNION 
         SELECT driver_ID, d_fullname, d_status, join_date 
         FROM Driver 
         WHERE join_date > TO_DATE('2022-01-01', 'YYYY-MM-DD')";

echo "<div class='first-query-container'><h2 class='first-heading'>Union of Drivers Who Are Active or Joined After 2022:</h2>";
$stid = oci_parse($conn, $sql1);
oci_execute($stid);

echo "<table><tr><th>Driver ID</th><th>Name</th><th>Status</th><th>Join Date</th></tr>";
while ($row = oci_fetch_assoc($stid)) {
    echo "<tr><td>" . $row['DRIVER_ID'] . "</td><td>" . $row['D_FULLNAME'] . "</td><td>" . $row['D_STATUS'] . "</td><td>" . $row['JOIN_DATE'] . "</td></tr>";
}
echo "</table><br>";
oci_free_statement($stid);

// Query 2: Passenger with ID 1, ride with feedback and ratings
$sql2 = "SELECT P.p_fullname AS passenger_name, R.ride_ID, R.start_time, F.memo AS feedback, H.rating 
         FROM Passenger P, Ride R, Feedbck F, Has H 
         WHERE P.passenger_ID = R.passenger_ID 
         AND R.ride_ID = F.ride_ID 
         AND F.feedback_ID = H.feedback_ID 
         AND P.passenger_ID = 1";

echo "<h2>Passenger Ride Feedback and Ratings:</h2>";
$stid = oci_parse($conn, $sql2);
oci_execute($stid);

echo "<table><tr><th>Passenger Name</th><th>Ride ID</th><th>Start Time</th><th>Feedback</th><th>Rating</th></tr>";
while ($row = oci_fetch_assoc($stid)) {
    echo "<tr><td>" . $row['PASSENGER_NAME'] . "</td><td>" . $row['RIDE_ID'] . "</td><td>" . $row['START_TIME'] . "</td><td>" . $row['FEEDBACK'] . "</td><td>" . $row['RATING'] . "</td></tr>";
}
echo "</table><br>";
oci_free_statement($stid);

// Query 3: Feedback memo with ride, passenger, and driver details
$sql3 = "SELECT F.feedback_ID, F.memo AS feedback_comment, P.p_fullname AS passenger_name, 
                D.d_fullname AS driver_name, R.ride_ID 
         FROM Feedbck F, Ride R, Passenger P, Driver D 
         WHERE F.ride_ID = R.ride_ID 
         AND F.passenger_ID = P.passenger_ID 
         AND F.driver_ID = D.driver_ID 
         ORDER BY F.feedback_ID";

echo "<h2>Feedback Details:</h2>";
$stid = oci_parse($conn, $sql3);
oci_execute($stid);

echo "<table><tr><th>Feedback ID</th><th>Comment</th><th>Passenger Name</th><th>Driver Name</th><th>Ride ID</th></tr>";
while ($row = oci_fetch_assoc($stid)) {
    echo "<tr><td>" . $row['FEEDBACK_ID'] . "</td><td>" . $row['FEEDBACK_COMMENT'] . "</td><td>" . $row['PASSENGER_NAME'] . "</td><td>" . $row['DRIVER_NAME'] . "</td><td>" . $row['RIDE_ID'] . "</td></tr>";
}
echo "</table><br>";
oci_free_statement($stid);

// Query 4: Total rides by each driver
$sql4 = "SELECT Driver.d_fullname AS driver_name, COUNT(Ride.ride_id) AS total_rides 
         FROM Driver, Ride 
         WHERE Driver.driver_id = Ride.driver_id 
         GROUP BY Driver.d_fullname 
         ORDER BY total_rides DESC";

echo "<h2>Total Rides by Each Driver:</h2>";
$stid = oci_parse($conn, $sql4);
oci_execute($stid);

echo "<table><tr><th>Driver Name</th><th>Total Rides</th></tr>";
while ($row = oci_fetch_assoc($stid)) {
    echo "<tr><td>" . $row['DRIVER_NAME'] . "</td><td>" . $row['TOTAL_RIDES'] . "</td></tr>";
}
echo "</table><br>";
oci_free_statement($stid);

// Query 5: Drivers who have given rides to a specific passenger
$passengerName = "John Doe";
$sql5 = "SELECT DISTINCT Driver.d_fullname AS driver_name 
         FROM Driver, Ride, Passenger 
         WHERE Driver.driver_id = Ride.driver_id 
         AND Ride.passenger_ID = Passenger.passenger_ID 
         AND Passenger.p_fullname = :passengerName";

echo "<h2>Drivers Who Have Given Rides to " . htmlspecialchars($passengerName) . ":</h2>";
$stid = oci_parse($conn, $sql5);
oci_bind_by_name($stid, ":passengerName", $passengerName);
oci_execute($stid);

echo "<table><tr><th>Driver Name</th></tr>";
while ($row = oci_fetch_assoc($stid)) {
    echo "<tr><td>" . $row['DRIVER_NAME'] . "</td></tr>";
}
echo "</table><br>";
oci_free_statement($stid);

?>

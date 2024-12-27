<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Tables</title>
    <style>
        body {
            font-family: sans-serif; 
            background-color: #e0f7fa;
            color: #1a1a1a;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            justify-content: center;
            height: 100vh;
            padding-top: 20px;
        }
        h2 {
            font-size: 1.8rem;
            color: #007bb8;
            text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.5); 
            margin: 10px 0;
        }
    </style>
</head>
<body>

<?php
// Create Passenger table
$query = "CREATE TABLE Passenger (
    passenger_ID     INTEGER NOT NULL PRIMARY KEY, 
    p_fullname       VARCHAR(255) NOT NULL, 
    p_phone          VARCHAR(15) NOT NULL, 
    p_email          VARCHAR(255), 
    join_date        DATE, 
    loyalty_points   INTEGER)";

$stid = oci_parse($conn, $query);
oci_execute($stid);
echo "<h2>Passenger table created successfully.</h2>";
oci_free_statement($stid);

// Create Driver table
$query = "CREATE TABLE Driver (
    driver_ID        INTEGER PRIMARY KEY,
    d_fullname       VARCHAR(255) NOT NULL,
    d_phone          VARCHAR(15) NOT NULL,
    d_email          VARCHAR(255),
    license_plate    VARCHAR(15) NOT NULL,
    d_status         VARCHAR(50),
    join_date        DATE)";

$stid = oci_parse($conn, $query);
oci_execute($stid);
echo "<h2>Driver table created successfully.</h2>";
oci_free_statement($stid);

// Create Vehicle table
$query = "CREATE TABLE Vehicle (
    vehicle_ID       INTEGER PRIMARY KEY,
    v_model          VARCHAR(255),
    v_capacity       INTEGER,
    license_plate    VARCHAR(15) NOT NULL,
    driver_ID        INTEGER,
    CONSTRAINT FK_driver_ID_vehicle
    FOREIGN KEY (driver_ID) REFERENCES Driver(driver_ID))";

$stid = oci_parse($conn, $query);
oci_execute($stid);
echo "<h2>Vehicle table created successfully.</h2>";
oci_free_statement($stid);

// Create Ride table
$query = "CREATE TABLE Ride (
    ride_ID          INTEGER NOT NULL PRIMARY KEY,
    driver_ID        INTEGER,
    passenger_ID     INTEGER,
    start_time       TIMESTAMP,
    end_time         TIMESTAMP,
    distance         DECIMAL(5,2),
    fee              DECIMAL(10,2),
    r_status         VARCHAR(50),
    CONSTRAINT FK_driver_ID_ride
    FOREIGN KEY (driver_ID) REFERENCES Driver(driver_ID),
    CONSTRAINT FK_passenger_ID_ride
    FOREIGN KEY (passenger_ID) REFERENCES Passenger(passenger_ID))";

$stid = oci_parse($conn, $query);
oci_execute($stid);
echo "<h2>Ride table created successfully.</h2>";
oci_free_statement($stid);

// Create Takes table
$query = "CREATE TABLE takes (
    passenger_ID    INTEGER REFERENCES Passenger(passenger_ID),
    ride_ID         INTEGER REFERENCES Ride(ride_ID),
    t_date          DATE,
    t_time          TIMESTAMP,
    PRIMARY KEY (passenger_ID, ride_ID))";

$stid = oci_parse($conn, $query);
oci_execute($stid);
echo "<h2>Takes table created successfully.</h2>";
oci_free_statement($stid);

// Create PassengerAddress table
$query = "CREATE TABLE PassengerAddress (
    passenger_ID    INTEGER REFERENCES Passenger(passenger_ID),
    address         VARCHAR(255) NOT NULL,
    PRIMARY KEY (passenger_ID))";

$stid = oci_parse($conn, $query);
oci_execute($stid);
echo "<h2>PassengerAddress table created successfully.</h2>";
oci_free_statement($stid);

// Create Route table
$query = "CREATE TABLE Route (
    ride_ID          INTEGER,
    start_pos        VARCHAR(255) NOT NULL,
    end_pos          VARCHAR(255) NOT NULL,
    distance         DECIMAL(5,2),
    r_duration       INTEGER,
    CONSTRAINT FK_ride_ID_route
    FOREIGN KEY(ride_ID) REFERENCES Ride(ride_ID))";

$stid = oci_parse($conn, $query);
oci_execute($stid);
echo "<h2>Route table created successfully.</h2>";
oci_free_statement($stid);

// Create Promotion table
$query = "CREATE TABLE Promotion (
    promotion_ID     INTEGER PRIMARY KEY,
    code             VARCHAR(50) UNIQUE,
    promo_type       VARCHAR(50),
    discount_amount  DECIMAL(5,2),
    start_date       DATE,
    end_date         DATE,
    active_status    NUMBER(1) NOT NULL)";

$stid = oci_parse($conn, $query);
oci_execute($stid);
echo "<h2>Promotion table created successfully.</h2>";
oci_free_statement($stid);

// Create Payment table
$query = "CREATE TABLE Payment (
    payment_ID       INTEGER PRIMARY KEY,
    promotion_ID     INTEGER,
    ride_ID          INTEGER,
    passenger_ID     INTEGER,
    fee              DECIMAL(10,2),
    p_method         VARCHAR(50),
    p_date           DATE,
    p_status         VARCHAR(50),
    CONSTRAINT FK_prom_ID_payment
    FOREIGN KEY (promotion_ID) REFERENCES Promotion(promotion_ID),
    CONSTRAINT FK_rider_ID_payment
    FOREIGN KEY (ride_ID) REFERENCES Ride(ride_ID),
    CONSTRAINT FK_passenger_ID_payment
    FOREIGN KEY (passenger_ID) REFERENCES Passenger(passenger_ID))";

$stid = oci_parse($conn, $query);
oci_execute($stid);
echo "<h2>Payment table created successfully.</h2>";
oci_free_statement($stid);

// Create Feedback table
$query = "CREATE TABLE Feedbck (
    feedback_ID      INTEGER PRIMARY KEY,
    ride_ID          INTEGER,
    passenger_ID     INTEGER,
    driver_ID        INTEGER,
    memo             VARCHAR(50),
    f_date           DATE,
    f_time           TIMESTAMP,
    CONSTRAINT FK_ride_ID_feedback
    FOREIGN KEY (ride_ID) REFERENCES Ride(ride_ID),
    CONSTRAINT FK_passenger_ID_feedback
    FOREIGN KEY (passenger_ID) REFERENCES Passenger(passenger_ID),
    CONSTRAINT FK_driver_ID_feedback
    FOREIGN KEY (driver_ID) REFERENCES Driver(driver_ID))";

$stid = oci_parse($conn, $query);
oci_execute($stid);
echo "<h2>Feedback table created successfully.</h2>";
oci_free_statement($stid);

// Create Has table
$query = "CREATE TABLE Has (
    driver_ID       INTEGER REFERENCES Driver(driver_ID),
    feedback_ID     INTEGER REFERENCES Feedbck(feedback_ID),
    passenger_ID    INTEGER REFERENCES Passenger(passenger_ID),
    rating          INTEGER,
    PRIMARY KEY (driver_ID, feedback_ID, passenger_ID))";

$stid = oci_parse($conn, $query);
oci_execute($stid);
echo "<h2>Has table created successfully.</h2>";
oci_free_statement($stid);

?>
</body>
</html>

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
//Passenger Table
$query = "INSERT INTO Passenger (passenger_ID, p_fullname, p_phone, p_email, join_date, loyalty_points) 
VALUES (1, 'John Doe', '1234567890', 'john.doe@example.com', TO_DATE('2021-01-01', 'YYYY-MM-DD'), 100)";

$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);

$query = "INSERT INTO Passenger (passenger_ID, p_fullname, p_phone, p_email, join_date, loyalty_points) 
VALUES (2, 'Jane Smith', '0987654321', 'jane.smith@example.com', TO_DATE('2021-05-15', 'YYYY-MM-DD'), 200)";
$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);

$query = "INSERT INTO Passenger (passenger_ID, p_fullname, p_phone, p_email, join_date, loyalty_points) 
VALUES (3, 'Sam Lee', '1122334455', 'sam.lee@example.com', TO_DATE('2022-02-10', 'YYYY-MM-DD'), 150)";
$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);

$query = "INSERT INTO Passenger (passenger_ID, p_fullname, p_phone, p_email, join_date, loyalty_points) 
VALUES (4, 'Lucy Brown', '2233445566', 'lucy.brown@example.com', TO_DATE('2023-07-20', 'YYYY-MM-DD'), 250)";
$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);

$query = "INSERT INTO Passenger (passenger_ID, p_fullname, p_phone, p_email, join_date, loyalty_points) 
VALUES (5, 'Mike Johnson', '3344556677', 'mike.johnson@example.com', TO_DATE('2023-09-01', 'YYYY-MM-DD'), 300)";
$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);

$query = "INSERT INTO Passenger (passenger_ID, p_fullname, p_phone, p_email, join_date, loyalty_points) 
VALUES (6, 'Amr Diab', '1289039443', 'amr.diab@egypt.com', TO_DATE('2021-09-21', 'YYYY-MM-DD'), 0)";
$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);

// Display success message after all inserts
echo "<h2>Passenger table populated successfully.</h2>";

//Driver Table
$query = "INSERT INTO Driver (driver_ID, d_fullname, d_phone, d_email, license_plate, d_status, join_date) 
VALUES (1, 'Alex Green', '1122334455', 'alex.green@example.com', 'ABC123', 'active', TO_DATE('2021-01-10', 'YYYY-MM-DD'))";
$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);

$query = "INSERT INTO Driver (driver_ID, d_fullname, d_phone, d_email, license_plate, d_status, join_date) 
VALUES (2, 'Emma White', '2233445566', 'emma.white@example.com', 'XYZ789', 'active', TO_DATE('2021-06-20', 'YYYY-MM-DD'))";
$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);

$query = "INSERT INTO Driver (driver_ID, d_fullname, d_phone, d_email, license_plate, d_status, join_date) 
VALUES (3, 'Tom Black', '3344556677', 'tom.black@example.com', 'DEF456', 'inactive', TO_DATE('2022-03-30', 'YYYY-MM-DD'))";
$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);

$query = "INSERT INTO Driver (driver_ID, d_fullname, d_phone, d_email, license_plate, d_status, join_date) 
VALUES (4, 'Nina Gold', '4455667788', 'nina.gold@example.com', 'GHI012', 'active', TO_DATE('2022-11-05', 'YYYY-MM-DD'))";
$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);

$query = "INSERT INTO Driver (driver_ID, d_fullname, d_phone, d_email, license_plate, d_status, join_date) 
VALUES (5, 'Oliver Blue', '5566778899', 'oliver.blue@example.com', 'JKL345', 'inactive', TO_DATE('2023-04-18', 'YYYY-MM-DD'))";
$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);

// Display success message after all inserts
echo "<h2>Driver table populated successfully.</h2>";

//Vehicle Table
$query = "INSERT INTO Vehicle (vehicle_ID, v_model, v_capacity, license_plate, driver_ID) 
VALUES (1, 'Toyota Prius', 4, 'ABC123', 1)";
$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);

$query = "INSERT INTO Vehicle (vehicle_ID, v_model, v_capacity, license_plate, driver_ID) 
VALUES (2, 'Honda Civic', 4, 'XYZ789', 2)";
$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);

$query = "INSERT INTO Vehicle (vehicle_ID, v_model, v_capacity, license_plate, driver_ID) 
VALUES (3, 'Ford F-150', 5, 'DEF456', 3)";
$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);

$query = "INSERT INTO Vehicle (vehicle_ID, v_model, v_capacity, license_plate, driver_ID) 
VALUES (4, 'Tesla Model 3', 5, 'GHI012', 4)";
$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);

$query = "INSERT INTO Vehicle (vehicle_ID, v_model, v_capacity, license_plate, driver_ID) 
VALUES (5, 'Chevrolet Bolt', 4, 'JKL345', 5)";
$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);

// Display success message after all inserts
echo "<h2>Vehicle table populated successfully.</h2>";

//Ride Table
$query = "INSERT INTO Ride (ride_ID, driver_ID, passenger_ID, start_time, end_time, distance, fee, r_status) 
VALUES (1, 1, 1, TO_TIMESTAMP('2024-09-01 08:00:00', 'YYYY-MM-DD HH24:MI:SS'), TO_TIMESTAMP('2024-09-01 08:30:00', 'YYYY-MM-DD HH24:MI:SS'), 10.5, 25.00, 'completed')";
$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);

$query = "INSERT INTO Ride (ride_ID, driver_ID, passenger_ID, start_time, end_time, distance, fee, r_status) 
VALUES (2, 2, 2, TO_TIMESTAMP('2024-09-02 09:00:00', 'YYYY-MM-DD HH24:MI:SS'), TO_TIMESTAMP('2024-09-02 09:45:00', 'YYYY-MM-DD HH24:MI:SS'), 15.2, 35.00, 'completed')";
$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);

$query = "INSERT INTO Ride (ride_ID, driver_ID, passenger_ID, start_time, end_time, distance, fee, r_status) 
VALUES (3, 3, 3, TO_TIMESTAMP('2024-09-03 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), TO_TIMESTAMP('2024-09-03 10:30:00', 'YYYY-MM-DD HH24:MI:SS'), 7.8, 20.00, 'completed')";
$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);

$query = "INSERT INTO Ride (ride_ID, driver_ID, passenger_ID, start_time, end_time, distance, fee, r_status) 
VALUES (4, 4, 4, TO_TIMESTAMP('2024-09-04 11:00:00', 'YYYY-MM-DD HH24:MI:SS'), TO_TIMESTAMP('2024-09-04 11:40:00', 'YYYY-MM-DD HH24:MI:SS'), 12.0, 28.00, 'completed')";
$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);

$query = "INSERT INTO Ride (ride_ID, driver_ID, passenger_ID, start_time, end_time, distance, fee, r_status) 
VALUES (5, 5, 5, TO_TIMESTAMP('2024-09-05 12:00:00', 'YYYY-MM-DD HH24:MI:SS'), TO_TIMESTAMP('2024-09-05 12:30:00', 'YYYY-MM-DD HH24:MI:SS'), 8.9, 22.00, 'completed')";
$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);

// Display success message after all inserts
echo "<h2>Ride table populated successfully.</h2>";

//Takes Table
$query = "INSERT INTO takes (passenger_ID, ride_ID, t_date, t_time) 
VALUES (1, 1, TO_DATE('2024-09-01', 'YYYY-MM-DD'), TO_TIMESTAMP('2024-09-01 08:00:00', 'YYYY-MM-DD HH24:MI:SS'))";
$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);

$query = "INSERT INTO takes (passenger_ID, ride_ID, t_date, t_time) 
VALUES (2, 2, TO_DATE('2024-09-02', 'YYYY-MM-DD'), TO_TIMESTAMP('2024-09-02 09:00:00', 'YYYY-MM-DD HH24:MI:SS'))";
$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);

$query = "INSERT INTO takes (passenger_ID, ride_ID, t_date, t_time) 
VALUES (3, 3, TO_DATE('2024-09-03', 'YYYY-MM-DD'), TO_TIMESTAMP('2024-09-03 10:00:00', 'YYYY-MM-DD HH24:MI:SS'))";
$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);

$query = "INSERT INTO takes (passenger_ID, ride_ID, t_date, t_time) 
VALUES (4, 4, TO_DATE('2024-09-04', 'YYYY-MM-DD'), TO_TIMESTAMP('2024-09-04 11:00:00', 'YYYY-MM-DD HH24:MI:SS'))";
$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);

$query = "INSERT INTO takes (passenger_ID, ride_ID, t_date, t_time) 
VALUES (5, 5, TO_DATE('2024-09-05', 'YYYY-MM-DD'), TO_TIMESTAMP('2024-09-05 12:00:00', 'YYYY-MM-DD HH24:MI:SS'))";
$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);

// Display success message after all inserts
echo "<h2>Takes table populated successfully.</h2>";

//PassengerAddress Table
$query = "INSERT INTO PassengerAddress (passenger_ID, address) 
VALUES (1, '123 Main St')";
$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);

$query = "INSERT INTO PassengerAddress (passenger_ID, address) 
VALUES (2, '456 Oak St')";
$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);

$query = "INSERT INTO PassengerAddress (passenger_ID, address) 
VALUES (3, '789 Pine St')";
$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);

$query = "INSERT INTO PassengerAddress (passenger_ID, address) 
VALUES (4, '101 Maple Ave')";
$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);

$query = "INSERT INTO PassengerAddress (passenger_ID, address) 
VALUES (5, '202 Cedar Blvd')";
$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);

// Display success message after all inserts
echo "<h2>PassengerAddress table populated successfully.</h2>";

//Route table
$query = "INSERT INTO Route (ride_ID, start_pos, end_pos, distance, r_duration) 
VALUES (1, '123 Main St', 'Downtown', 10.5, 30)";
$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);

$query = "INSERT INTO Route (ride_ID, start_pos, end_pos, distance, r_duration) 
VALUES (2, '456 Oak St', 'City Center', 15.2, 45)";
$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);

$query = "INSERT INTO Route (ride_ID, start_pos, end_pos, distance, r_duration) 
VALUES (3, '789 Pine St', 'Uptown', 7.8, 25)";
$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);

$query = "INSERT INTO Route (ride_ID, start_pos, end_pos, distance, r_duration) 
VALUES (4, '101 Maple Ave', 'Suburbia', 12.0, 40)";
$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);

$query = "INSERT INTO Route (ride_ID, start_pos, end_pos, distance, r_duration) 
VALUES (5, '202 Cedar Blvd', 'Airport', 8.9, 35)";
$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);

// Display success message after all inserts
echo "<h2>Route table populated successfully.</h2>";

//Promotion table
$query = "INSERT INTO Promotion (promotion_ID, code, promo_type, discount_amount, start_date, end_date, active_status) 
VALUES (1, 'SAVE10', 'Discount', 10.00, TO_DATE('2024-09-01', 'YYYY-MM-DD'), TO_DATE('2024-09-30', 'YYYY-MM-DD'), 1)";
$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);

$query = "INSERT INTO Promotion (promotion_ID, code, promo_type, discount_amount, start_date, end_date, active_status) 
VALUES (2, 'SAVE20', 'Discount', 20.00, TO_DATE('2024-10-01', 'YYYY-MM-DD'), TO_DATE('2024-10-31', 'YYYY-MM-DD'), 1)";
$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);

$query = "INSERT INTO Promotion (promotion_ID, code, promo_type, discount_amount, start_date, end_date, active_status) 
VALUES (3, 'HALFOFF', 'Discount', 50.00, TO_DATE('2024-11-01', 'YYYY-MM-DD'), TO_DATE('2024-11-30', 'YYYY-MM-DD'), 1)";
$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);

$query = "INSERT INTO Promotion (promotion_ID, code, promo_type, discount_amount, start_date, end_date, active_status) 
VALUES (4, 'FREERIDE', 'Free Ride', 100.00, TO_DATE('2024-12-01', 'YYYY-MM-DD'), TO_DATE('2024-12-31', 'YYYY-MM-DD'), 1)";
$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);

$query = "INSERT INTO Promotion (promotion_ID, code, promo_type, discount_amount, start_date, end_date, active_status) 
VALUES (5, 'NEWYEAR', 'Discount', 15.00, TO_DATE('2025-01-01', 'YYYY-MM-DD'), TO_DATE('2025-01-31', 'YYYY-MM-DD'), 0)";
$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);

// Display success message after all inserts
echo "<h2>Promotion table populated successfully.</h2>";

//Payment table
$query = "INSERT INTO Payment (payment_ID, promotion_ID, ride_ID, passenger_ID, fee, p_method, p_date, p_status) 
VALUES (1, NULL, 1, 1, 25.00, 'Credit Card', TO_DATE('2024-09-01', 'YYYY-MM-DD'), 'completed')";
$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);

$query = "INSERT INTO Payment (payment_ID, promotion_ID, ride_ID, passenger_ID, fee, p_method, p_date, p_status) 
VALUES (2, 1, 2, 2, 35.00, 'PayPal', TO_DATE('2024-09-02', 'YYYY-MM-DD'), 'completed')";
$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);

$query = "INSERT INTO Payment (payment_ID, promotion_ID, ride_ID, passenger_ID, fee, p_method, p_date, p_status) 
VALUES (3, 1, 3, 3, 20.00, 'Debit Card', TO_DATE('2024-09-03', 'YYYY-MM-DD'), 'completed')";
$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);

$query = "INSERT INTO Payment (payment_ID, promotion_ID, ride_ID, passenger_ID, fee, p_method, p_date, p_status) 
VALUES (4, NULL, 4, 4, 28.00, 'Credit Card', TO_DATE('2024-09-04', 'YYYY-MM-DD'), 'completed')";
$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);

$query = "INSERT INTO Payment (payment_ID, promotion_ID, ride_ID, passenger_ID, fee, p_method, p_date, p_status) 
VALUES (5, 4, 5, 5, 22.00, 'Cash', TO_DATE('2024-09-05', 'YYYY-MM-DD'), 'completed')";
$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);

// Display success message after all inserts
echo "<h2>Payment table populated successfully.</h2>";

//Feedback table
$query = "INSERT INTO Feedbck (feedback_ID, ride_ID, passenger_ID, driver_ID, memo, f_date, f_time) 
VALUES (1, 1, 1, 1, 'Great service!', TO_DATE('2024-09-01', 'YYYY-MM-DD'), TO_TIMESTAMP('2024-09-01 09:00:00', 'YYYY-MM-DD HH24:MI:SS'))";
$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);

$query = "INSERT INTO Feedbck (feedback_ID, ride_ID, passenger_ID, driver_ID, memo, f_date, f_time) 
VALUES (2, 2, 2, 2, 'Very friendly driver.', TO_DATE('2024-09-02', 'YYYY-MM-DD'), TO_TIMESTAMP('2024-09-02 10:00:00', 'YYYY-MM-DD HH24:MI:SS'))";
$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);

$query = "INSERT INTO Feedbck (feedback_ID, ride_ID, passenger_ID, driver_ID, memo, f_date, f_time) 
VALUES (3, 3, 3, 3, 'Smooth ride!', TO_DATE('2024-09-03', 'YYYY-MM-DD'), TO_TIMESTAMP('2024-09-03 11:00:00', 'YYYY-MM-DD HH24:MI:SS'))";
$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);

$query = "INSERT INTO Feedbck (feedback_ID, ride_ID, passenger_ID, driver_ID, memo, f_date, f_time) 
VALUES (4, 4, 4, 4, 'Could be faster.', TO_DATE('2024-09-04', 'YYYY-MM-DD'), TO_TIMESTAMP('2024-09-04 12:00:00', 'YYYY-MM-DD HH24:MI:SS'))";
$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);

$query = "INSERT INTO Feedbck (feedback_ID, ride_ID, passenger_ID, driver_ID, memo, f_date, f_time) 
VALUES (5, 5, 5, 5, 'Excellent experience!', TO_DATE('2024-09-05', 'YYYY-MM-DD'), TO_TIMESTAMP('2024-09-05 13:00:00', 'YYYY-MM-DD HH24:MI:SS'))";
$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);

// Display success message after all inserts
echo "<h2>Feedbck table populated successfully.</h2>";

//Has table
$query = "INSERT INTO Has (driver_ID, feedback_ID, passenger_ID, rating) 
VALUES (1, 1, 1, 5)";
$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);

$query = "INSERT INTO Has (driver_ID, feedback_ID, passenger_ID, rating) 
VALUES (2, 2, 2, 4)";
$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);

$query = "INSERT INTO Has (driver_ID, feedback_ID, passenger_ID, rating) 
VALUES (3, 3, 3, 5)";
$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);

$query = "INSERT INTO Has (driver_ID, feedback_ID, passenger_ID, rating) 
VALUES (4, 4, 4, 3)";
$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);

$query = "INSERT INTO Has (driver_ID, feedback_ID, passenger_ID, rating) 
VALUES (5, 5, 5, 5)";
$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);

// Display success message after all inserts
echo "<h2>Has table populated successfully.</h2>";
?>
</body>
</html>


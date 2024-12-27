<?php
$query = "BEGIN
    EXECUTE IMMEDIATE 'DROP TABLE Route CASCADE CONSTRAINTS';
    EXECUTE IMMEDIATE 'DROP TABLE Takes CASCADE CONSTRAINTS';
    EXECUTE IMMEDIATE 'DROP TABLE Vehicle CASCADE CONSTRAINTS';
    EXECUTE IMMEDIATE 'DROP TABLE Has CASCADE CONSTRAINTS';
    EXECUTE IMMEDIATE 'DROP TABLE Feedbck CASCADE CONSTRAINTS';
    EXECUTE IMMEDIATE 'DROP TABLE PassengerAddress CASCADE CONSTRAINTS';
    EXECUTE IMMEDIATE 'DROP TABLE Payment CASCADE CONSTRAINTS';
    EXECUTE IMMEDIATE 'DROP TABLE Promotion CASCADE CONSTRAINTS';
    EXECUTE IMMEDIATE 'DROP TABLE Ride CASCADE CONSTRAINTS';
    EXECUTE IMMEDIATE 'DROP TABLE Driver CASCADE CONSTRAINTS';
    EXECUTE IMMEDIATE 'DROP TABLE Passenger CASCADE CONSTRAINTS';
END;";

$stid = oci_parse($conn, $query);
oci_execute($stid);
oci_free_statement($stid);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drop Tables</title>
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
            height: 100vh;
            justify-content: center;
        }
        h2 {
            font-size: 1.8rem;
            color: #007bb8;
            text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.5); 
        }
    </style>
</head>
<body>
    <h2>Tables dropped successfully.</h2>
</body>
</html>

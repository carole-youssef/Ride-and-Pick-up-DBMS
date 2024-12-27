<?php
// Database connection details
$oracle_user = 'cyoussef'; // your Oracle username
$oracle_password = '12146366'; // your Oracle password
$oracle_db = '//oracle12c.scs.ryerson.ca:1521/orcl12c'; // the Oracle connection string

// Create connection
$conn = oci_connect($oracle_user, $oracle_password, $oracle_db);
if (!$conn) {
    $e = oci_error();
    echo "Connection error: " . $e['message'];
    exit;
}
?>

<?php
include('db.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oracle Database Management</title>
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
    }
    h1 {
        font-size: 2.5rem;
        color: #007bb8; 
        margin-top: 20px;
        position: absolute;
        top: 10px;
        width: 100%;
        text-align: center;
        text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.5); 
    }
    table {
        width: 80%;
        margin: 20px auto;
        border-collapse: collapse;
        background-color: #ffffff; 
        border: 2px solid #b2ebf2; 
        border-radius: 8px;
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
    }
    th, td {
        border: 1px solid #b2ebf2; 
        padding: 12px;
    }
    th {
        background-color: #007bb8; 
        color: white;
        text-transform: uppercase;
        font-weight: bold;
    }
    td {
        background-color: #f1f8e9; 
    }
    form {
        position: absolute;
        top: 100px;
        display: flex; 
        justify-content: center; 
        gap: 10px; 
    }
    input, button {
        width: 220px;
        padding: 12px;
        border: 2px solid #007bb8; 
        border-radius: 5px;
        background-color: #b2ebf2; 
        color: #007bb8; 
        font-size: 16px;
        font-weight: bold;
        text-align: center;
        transition: all 0.3s ease-in-out;
    }
    button {
        background-color: #007bb8;
        color: white;
        font-size: 16px;
    }
    button:hover, input:hover {
        background-color: #005f8a; 
        color: white;
        cursor: pointer;
    }
</style>

</head>
<body>

<h1>Oracle All-Inclusive Tool - Ride and Pick-up DBMS</h1>

<form method="POST" action="index.php">
    <button type="submit" name="action" value="drop_tables">Drop Tables</button>
    <button type="submit" name="action" value="create_tables">Create Tables</button>
    <button type="submit" name="action" value="populate_tables">Populate Tables</button>
    <button type="submit" name="action" value="query_tables">Query Tables</button>
    <button type="submit" name="action" value="db_management">Database Management</button>
</form>

<?php
if (isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'drop_tables') {
        include('drop_tables.php');
    } elseif ($action === 'create_tables') {
        include('create_tables.php');
    } elseif ($action === 'populate_tables') {
        include('populate_tables.php');
    } elseif ($action === 'query_tables') {
        include('query_tables.php');
    } elseif ($action === 'db_management') {
        include('db_management.php');
    }
}

oci_close($conn);
?>

</body>
</html>

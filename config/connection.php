<?php
$host = "localhost"; // database host
$username = "root"; // database username
$password = ""; // database password
$dbname = "ems"; // database name

// create a new database connection
$conn = mysqli_connect($host, $username, $password, $dbname);

// check if the connection was successful
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>

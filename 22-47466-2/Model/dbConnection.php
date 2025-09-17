<?php
function getConnection() {
    $host = "localhost";
    $username = "root";
    $password = "";     
    $dbname = "job_portal"; 

    $con = mysqli_connect($host, $username, $password, $dbname);

    if (!$con) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    return $con;
}
?>

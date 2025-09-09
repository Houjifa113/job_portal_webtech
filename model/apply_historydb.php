<?php
// model/apply_historydb.php
$servername = "localhost";
$username   = "root";
$password   = "";
$database   = "applyhistory";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");
?>

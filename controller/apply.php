<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "applyhistory"; // Database name

$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Make sure form data exists
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['job']) && isset($_POST['redirect'])) {
    $job_name = $_POST['job'];
    $redirectPage = $_POST['redirect'];

    // Check if job is already applied
    $stmt = $conn->prepare("SELECT * FROM applyhistory WHERE jobname = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("s", $job_name);
    $stmt->execute();
    $stmt->store_result();
    $already_applied = $stmt->num_rows > 0;
    $stmt->close();

    if (!$already_applied) {
        // Insert applied job into database
        $stmt = $conn->prepare("INSERT INTO applyhistory (jobname) VALUES (?)");
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("s", $job_name);
        $stmt->execute();
        $stmt->close();
    }

    // Optional: save applied jobs in session for quick access
    if (!isset($_SESSION['applied_jobs'])) {
        $_SESSION['applied_jobs'] = [];
    }
    if (!in_array($job_name, $_SESSION['applied_jobs'])) {
        $_SESSION['applied_jobs'][] = $job_name;
    }

    // Redirect back to job page
    header("Location: $redirectPage");
    exit;
} else {
    die("Invalid request.");
}
?>

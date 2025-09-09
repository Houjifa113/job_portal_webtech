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

// Fetch all applied jobs
$result = mysqli_query($conn, "SELECT jobname, `date` FROM applyhistory ORDER BY `date` DESC");
$applied_jobs = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $applied_jobs[] = $row;
    }
} else {
    die("Query failed: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Applied Jobs History</title>
<style>
body { font-family: Arial, sans-serif; padding: 20px; }
h2 { color: #333; }
table { border-collapse: collapse; width: 100%; }
th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
th { background-color: #f2f2f2; }
a { text-decoration: none; color: blue; }
</style>
</head>
<body>

<h2>Applied Jobs History</h2>

<?php if (!empty($applied_jobs)): ?>
    <table>
        <tr>
            <th>Job Name</th>
            <th>Applied Date</th>
        </tr>
        <?php foreach ($applied_jobs as $job): ?>
            <tr>
                <td><?php echo ucfirst(str_replace('_', ' ', $job['jobname'])); ?></td>
                <td><?php echo $job['date']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>You have not applied to any jobs yet.</p>
<?php endif; ?>

<br>
<a href="job.php">Back to Job Search</a>

</body>
</html>

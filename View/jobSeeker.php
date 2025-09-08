<?php
require_once '../Model/config.php';

// Check if user is logged in and is a jobseeker
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Job Seeker') {
    header("Location: ../View/UserAuthetication.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
     <link rel="stylesheet" href="../Asset/Khorshida.css">
</head>
<body>
    <div class="container">
    <h1>Welcome to Dashboard! <?php echo $_SESSION['user_email']; ?></h1>
   

     <section>
        <h2>Quick Actions</h2>
        <a href="InterviewScheduling.php
        "><button class="btn">Schedule an Interview</button></a>
        <a href="ApplicationTracking.php"><button class="btn">Track My Applications</button></a>
        <a href="jobs.html"><button class="btn">Search for jobs</button></a>
    </section>

    <section>
        <h2>Your Summary</h2>
        <div style="display: flex; gap: 20px; justify-content: center;">
            <div class="application-card">
            <h3>Jobs Applied</h3>
            <p id="jobsAppliedCount">0</p>
        </div>
        <div class="application-card">
            <h3>Upcoming Interviews</h3>
            <p id="interviewsCount">0</p>
        </div>
        <div class="application-card">
            <h3>Applications Viewed</h3>
            <p id="viewsCount">0</p>
        </div>
</div>
    </section>

    <section>
        <h2>Recent Activity</h2>
        <div class="application-card">
        <ul id="activityList">
            <li>No recent activity</li>
        </ul>
</div>
    </section>

   
    <a href="../Controller/logout.php" style="display: block; margin-top: 20px; text-align:center;">
        <button class="btn btn-danger">Logout</button>
    </a>

   
    <script src="../Asset/Dashboard.js"></script>
</div>

</body>
</html>
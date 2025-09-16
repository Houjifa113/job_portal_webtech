<?php
<<<<<<< HEAD:View/dashboard.php
session_start();
if(!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1; 
    $_SESSION['user_email'] = 'test@email.com'; 
    $_SESSION['status'] = true;
}
require_once('../Model/connection.php');
require_once('../Model/interviewModel.php');

if(!isset($_SESSION['status']) || !isset($_COOKIE['status'])){
    header('location: UserAuthetication.php?error=badrequest');
=======
require_once '../Model/config.php';

// Check if user is logged in and is a jobseeker
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Job Seeker') {
    header("Location: ../View/UserAuthetication.php");
    exit();
>>>>>>> main:View/jobSeeker.php
}

$user_id = $_SESSION['user_id'];
$upcomingInterviews = countInterviewsByUserId($user_id);
$jobsApplied = 0; 
$appsViewed = 0;  
$recentActivities = [
    "You applied for Web Developer at TechSoft",
    "Interview scheduled for June 5th at 2:00 PM", 
    "Your application for Data Analyst was viewed"
];
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
        <a href="job.php"><button class="btn">Search for jobs</button></a>
         <a href="#"><button class="btn">Resume Upload</button></a>
          <a href="#"><button class="btn">View Companies</button></a>
    </section>
   
    <section>
        <h2>Your Summary</h2>
        <div style="display: flex; gap: 20px; justify-content: center;">
            <div class="application-card">
            <h3>Jobs Applied</h3>
            <p id="jobsAppliedCount"><?php echo $jobsApplied; ?></p> 
        </div>
        <div class="application-card">
            <h3>Upcoming Interviews</h3>
            <p id="interviewsCount"><?php echo $upcomingInterviews; ?></p> 
        </div>
        <div class="application-card">
            <h3>Applications Viewed</h3>
            <p id="viewsCount"><?php echo $appsViewed; ?></p> 
        </div>
    </div>
    </section>

    <section>
        <h2>Recent Activity</h2>
        <div class="application-card">
        <ul id="activityList">
            <?php foreach($recentActivities as $activity): ?>
                <li><?php echo $activity; ?></li> 
            <?php endforeach; ?>
        </ul>
        </div>
    </section>
<<<<<<< HEAD:View/dashboard.php
 <a href="../Controllers/logout.php" style="display: block; margin-top: 20px; text-align:center;">
=======

   
    <a href="../Controller/logout.php" style="display: block; margin-top: 20px; text-align:center;">
>>>>>>> main:View/jobSeeker.php
        <button class="btn btn-danger">Logout</button>
    </a>

    
</div>
</body>
</html>
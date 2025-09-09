<?php
session_start();

// Check if user is logged in
if(!isset($_SESSION['status']) || !isset($_COOKIE['status'])){
    header('location: UserAuthentication.html?error=badrequest');
    exit();
}
?>





<!DOCTYPE html>
<html>
<head>
    <title>Application Tracking</title>
    <link rel="stylesheet" href="../Asset/Khorshida.css">
</head>
<body>
 <div class="container"></div>
    <h1>Your Job Applications</h1>
    <div class="application-card" id="applications-list">
         <h3>Frontend Developer at TechCorp</h3>
         <p class="status-review">Status: Under Review</p>
    </div>
</div>
    </body>
    <script src="../Asset/ApplicationTracking.js"></script>
    </html>
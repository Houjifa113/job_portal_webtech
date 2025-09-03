<?php
session_start();

// Check if user is logged in 
if(!isset($_SESSION['status']) || !isset($_COOKIE['status'])){
    header('location: UserAuthetication.php?error=badrequest');
    exit();
}

// Get selected time slot
$selectedTime = $_REQUEST['timeSlot'];
$selectedDate = $_REQUEST['interviewDate']; 

// Check if a time was selected
if($selectedTime == "" || $selectedTime == "-- Select Time --"){
    header('location: InterviewScheduling.html?error=notimeselected');
    exit();
}




$_SESSION['scheduled_time'] = $selectedTime;
$_SESSION['scheduled_date'] = $selectedDate;

header('location: InterviewScheduling.html?success=scheduled');
exit();
?>
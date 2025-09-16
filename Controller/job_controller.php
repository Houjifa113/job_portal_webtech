<?php
session_start();
require_once '../Model/database.php';

// Check if user is logged in and is employer
if(!isset($_SESSION['status']) || $_SESSION['user_role'] != 'Employer'){
    header('location: ../View/auth.php?error=badrequest');
    exit();
}

$employer_id = $_SESSION['user_id'];

// Handle Edit Job
if(isset($_REQUEST['editJob'])){
    $job_id = $_REQUEST['job_id'];
    $title = trim($_REQUEST['jobTitle']);
    $location = trim($_REQUEST['jobLocation']);
    $salary = trim($_REQUEST['jobSalary']);
    
    if($title != "" && $location != "" && $salary != ""){
        // Check if job belongs to this employer
        $check_sql = "SELECT id FROM jobs WHERE id = '$job_id' AND employer_id = '$employer_id'";
        $check_result = mysqli_query($conn, $check_sql);
        
        if(mysqli_num_rows($check_result) > 0){
            // Update job
            $update_sql = "UPDATE jobs SET title = '$title', location = '$location', salary = 'BDT $salary' WHERE id = '$job_id' AND employer_id = '$employer_id'";
            
            if(mysqli_query($conn, $update_sql)){
                // Log activity
                $log_sql = "INSERT INTO activity_logs (user_id, user_name, action) VALUES ('$employer_id', '".$_SESSION['user_name']."', 'Updated job: $title')";
                mysqli_query($conn, $log_sql);
                
                header('location: ../View/employer.php?success=updated');
            }else{
                header('location: ../View/employer.php?error=update_failed');
            }
        }else{
            header('location: ../View/employer.php?error=unauthorized');
        }
    }else{
        header('location: ../View/employer.php?error=empty_fields');
    }
}

// Handle Delete Job
if(isset($_REQUEST['deleteJob'])){
    $job_id = $_REQUEST['job_id'];
    
    // Get job info before deletion
    $job_sql = "SELECT title FROM jobs WHERE id = '$job_id' AND employer_id = '$employer_id'";
    $job_result = mysqli_query($conn, $job_sql);
    $job = mysqli_fetch_assoc($job_result);
    
    if($job){
        // Delete job
        $delete_sql = "DELETE FROM jobs WHERE id = '$job_id' AND employer_id = '$employer_id'";
        
        if(mysqli_query($conn, $delete_sql)){
            // Log activity
            $log_sql = "INSERT INTO activity_logs (user_id, user_name, action) VALUES ('$employer_id', '".$_SESSION['user_name']."', 'Deleted job: ".$job['title']."')";
            mysqli_query($conn, $log_sql);
            
            header('location: ../View/employer.php?success=deleted');
        }else{
            header('location: ../View/employer.php?error=delete_failed');
        }
    }else{
        header('location: ../View/employer.php?error=job_not_found');
    }
}

// If no valid action, redirect back
header('location: ../View/employer.php');
?>

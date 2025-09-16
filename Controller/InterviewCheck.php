<?php
session_start();



// Handle AJAX requests
if(isset($_POST['ajax']) && $_POST['ajax'] == 'true') {
    $user_id = $_SESSION['user_id'];
    
    if($_POST['action'] == 'create') {
        $scheduled_time = $_POST['timeSlot'];
        $scheduled_date = $_POST['interviewDate'];
        
        if($scheduled_time == "" || $scheduled_time == "-- Select a time --"){
            $response = ['success' => false, 'error' => 'Please select a time slot.'];
        } else if($scheduled_date == "") {
            $response = ['success' => false, 'error' => 'Please select a date.'];
        } else {
            require_once('../Model/connection.php');
            require_once('../Model/interviewModel.php');
            
            if(addInterview($user_id, $scheduled_time, $scheduled_date)) {
                $response = ['success' => true, 'message' => 'Interview scheduled!'];
            } else {
                $response = ['success' => false, 'error' => 'Database error'];
            }
        }
    }
    
   
    echo json_encode($response);
    exit();
}

require_once('../Model/connection.php');
require_once('../Model/interviewModel.php');

// Check if user is logged in 
if(!isset($_SESSION['status']) || !isset($_COOKIE['status'])){
    header('location: ../Views/UserAuthetication.php?error=badrequest');
    exit();
}

// Handle different actions
if(isset($_POST['action']) && $_POST['action'] == 'create') {
    $user_id = $_SESSION['user_id'];
    $scheduled_time = $_POST['timeSlot'];
    $scheduled_date = $_POST['interviewDate'];

    // Server-side validation
    if($scheduled_time == "" || $scheduled_time == "-- Select a time --"){
        header('location: ../Views/InterviewScheduling.php?error=notimeselected');
        exit();
    }

    if($scheduled_date == "") {
        header('location: ../Views/InterviewScheduling.php?error=nodateselected');
        exit();
    }

    $interview = [
        'user_id' => $user_id,
        'scheduled_time' => $scheduled_time,
        'scheduled_date' => $scheduled_date
    ];

    if(addInterview($interview['user_id'], $interview['scheduled_time'], $interview['scheduled_date'])) {
        $_SESSION['scheduled_time'] = $scheduled_time;
        $_SESSION['scheduled_date'] = $scheduled_date;
        header('location: ../Views/InterviewScheduling.php?success=scheduled');
    } else {
        header('location: ../Views/InterviewScheduling.php?error=dberror');
    }
    exit();
}
elseif(isset($_POST['action']) && $_POST['action'] == 'update') {
    //update action
    $id = $_POST['id'];
    $scheduled_time = $_POST['scheduled_time'];
    $scheduled_date = $_POST['scheduled_date'];
    
    if(updateInterview($id, $scheduled_time, $scheduled_date)) {
        header('location: ../Views/InterviewScheduling.php?success=updated');
    } else {
        header('location: ../Views/InterviewScheduling.php?error=updateerror');
    }
    exit();
}
elseif(isset($_POST['action']) && $_POST['action'] == 'delete') {
    
    $id = $_POST['id'];
    
    if(deleteInterview($id)) {
        header('location: ../Views/InterviewScheduling.php?success=deleted');
    } else {
        header('location: ../Views/InterviewScheduling.php?error=deleteerror');
    }
    exit();
}


header('location: ../Views/InterviewScheduling.php');
exit();
?>
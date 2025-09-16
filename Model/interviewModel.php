<?php
require_once('connection.php'); 

//Schedule new interview
function addInterview($user_id, $scheduled_time, $scheduled_date){
    $con = getConnection();
    $sql = "INSERT INTO interviews (user_id, scheduled_time, scheduled_date) 
            VALUES ('$user_id', '$scheduled_time', '$scheduled_date')";
    
    return mysqli_query($con, $sql);
}

// Get all interviews for a user
function getInterviewsByUserId($user_id){
    $con = getConnection();
    $sql = "SELECT * FROM interviews WHERE user_id = '$user_id' ORDER BY scheduled_date DESC, scheduled_time DESC";
    $result = mysqli_query($con, $sql);
    
    $interviews = [];
    while($row = mysqli_fetch_assoc($result)){
        $interviews[] = $row;
    }
    return $interviews;
}

//Modify existing interview
function updateInterview($id, $scheduled_time, $scheduled_date){
    $con = getConnection();
    $sql = "UPDATE interviews SET 
            scheduled_time = '$scheduled_time', 
            scheduled_date = '$scheduled_date' 
            WHERE id = '$id'";
    
    return mysqli_query($con, $sql);
}

//Remove interview
function deleteInterview($id){
    $con = getConnection();
    $sql = "DELETE FROM interviews WHERE id = '$id'";
    return mysqli_query($con, $sql);
}

// COUNT
function countInterviewsByUserId($user_id){
    $con = getConnection();
    $sql = "SELECT COUNT(*) as count FROM interviews WHERE user_id = '$user_id'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['count'];
}
?>
<?php

require_once('database.php');

function getAllActivityLogs(){
    global $conn;
    $sql = "SELECT user_name, action, created_at FROM activity_logs ORDER BY created_at DESC";
    $result = mysqli_query($conn, $sql);
    $logs = [];

    while($row = mysqli_fetch_assoc($result)){
        array_push($logs, $row);
    }

    return $logs;
}

function getFilteredActivityLogs($date, $type){
    global $conn;
    $sql = "SELECT user_name, action, created_at FROM activity_logs WHERE 1=1";
    
    if($date != ""){
        $sql .= " AND DATE(created_at) = '$date'";
    }
    
    if($type != ""){
        if($type == "login"){
            $sql .= " AND action LIKE '%logged%'";
        }elseif($type == "user"){
            $sql .= " AND (action LIKE '%user%' OR action LIKE '%User%')";
        }elseif($type == "job"){
            $sql .= " AND (action LIKE '%job%' OR action LIKE '%Job%')";
        }elseif($type == "system"){
            $sql .= " AND (action LIKE '%system%' OR action LIKE '%System%' OR action LIKE '%backup%')";
        }
    }
    
    $sql .= " ORDER BY created_at DESC";
    
    $result = mysqli_query($conn, $sql);
    $logs = [];

    while($row = mysqli_fetch_assoc($result)){
        array_push($logs, $row);
    }

    return $logs;
}

function addActivityLog($user_id, $user_name, $action){
    global $conn;
    $sql = "INSERT INTO activity_logs (user_id, user_name, action) VALUES ('$user_id', '$user_name', '$action')";
    return mysqli_query($conn, $sql);
}

?>

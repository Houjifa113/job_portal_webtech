<?php
session_start();
require_once '../Model/activityModel.php';

// Check if user is logged in and is admin
if(!isset($_SESSION['status']) || $_SESSION['user_role'] != 'Admin'){
    echo json_encode(['success' => false, 'error' => 'Unauthorized access']);
    exit();
}

if(isset($_POST['action'])){
    $action = $_POST['action'];
    
    if($action == 'get_all_logs'){
        $logs = getAllActivityLogs();
        echo json_encode(['success' => true, 'logs' => $logs]);
        
    }elseif($action == 'filter_logs'){
        $date = $_POST['date'];
        $type = $_POST['type'];
        
        $logs = getFilteredActivityLogs($date, $type);
        echo json_encode(['success' => true, 'logs' => $logs]);
        
    }else{
        echo json_encode(['success' => false, 'error' => 'Invalid action']);
    }
}else{
    echo json_encode(['success' => false, 'error' => 'No action specified']);
}
?>

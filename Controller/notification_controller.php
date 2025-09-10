<?php
session_start();
require_once '../Model/notificationModel.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $notificationModel = new NotificationModel();
    
    if(isset($_POST['action'])) {
        $action = $_POST['action'];
        
        // Get admin notifications
        if($action == 'get_admin_notifications') {
            $notifications = $notificationModel->getAdminNotifications();
            echo json_encode(['success' => true, 'notifications' => $notifications]);
        }
        
        // Get employer notifications
        elseif($action == 'get_employer_notifications') {
            $employer_id = $_POST['employer_id'];
            $notifications = $notificationModel->getEmployerNotifications($employer_id);
            echo json_encode(['success' => true, 'notifications' => $notifications]);
        }
        
        // Delete job by admin
        elseif($action == 'delete_job_by_admin') {
            if($_SESSION['user_role'] != 'Admin') {
                echo json_encode(['success' => false, 'error' => 'Unauthorized']);
                exit;
            }
            
            $job_id = $_POST['job_id'];
            if($notificationModel->deleteJobByAdmin($job_id)) {
                echo json_encode(['success' => true, 'message' => 'Job deleted successfully']);
            } else {
                echo json_encode(['success' => false, 'error' => 'Failed to delete job']);
            }
        }
        
        else {
            echo json_encode(['success' => false, 'error' => 'Invalid action']);
        }
    }
}
?>

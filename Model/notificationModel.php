<?php
require_once 'database.php';

class NotificationModel {
    private $conn;
    
    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }
    
    // Create notification when job is posted
    public function createJobPostedNotification($job_id, $employer_name, $job_title) {
        $message = "$employer_name posted a new job: $job_title";
        $sql = "INSERT INTO notifications (user_id, user_type, job_id, message, type) 
                VALUES (1, 'Admin', '$job_id', '$message', 'job_posted')";
        return mysqli_query($this->conn, $sql);
    }
    
    // Create notification when admin deletes job
    public function createJobDeletedNotification($employer_id, $job_title) {
        $message = "Admin deleted your job: $job_title";
        $sql = "INSERT INTO notifications (user_id, user_type, job_id, message, type) 
                VALUES ('$employer_id', 'Employer', NULL, '$message', 'job_deleted')";
        return mysqli_query($this->conn, $sql);
    }
    
    // Get admin notifications (job posted notifications)
    public function getAdminNotifications() {
        $sql = "SELECT n.*, j.title as job_title, j.location, j.salary, u.name as employer_name 
                FROM notifications n 
                LEFT JOIN jobs j ON n.job_id = j.id 
                LEFT JOIN users u ON j.employer_id = u.id 
                WHERE n.user_type = 'Admin' AND n.type = 'job_posted' 
                ORDER BY n.created_at DESC";
        
        $result = mysqli_query($this->conn, $sql);
        $notifications = [];
        
        if($result) {
            while($row = mysqli_fetch_assoc($result)) {
                $notifications[] = $row;
            }
        }
        
        return $notifications;
    }
    
    // Get employer notifications (job deleted notifications)
    public function getEmployerNotifications($employer_id) {
        $sql = "SELECT * FROM notifications 
                WHERE user_id = '$employer_id' AND user_type = 'Employer' 
                ORDER BY created_at DESC";
        
        $result = mysqli_query($this->conn, $sql);
        $notifications = [];
        
        if($result) {
            while($row = mysqli_fetch_assoc($result)) {
                $notifications[] = $row;
            }
        }
        
        return $notifications;
    }
    
    // Delete job and create notification
    public function deleteJobByAdmin($job_id) {
        // First get job and employer info
        $job_sql = "SELECT j.title, j.employer_id, u.name as employer_name 
                   FROM jobs j 
                   JOIN users u ON j.employer_id = u.id 
                   WHERE j.id = '$job_id'";
        $job_result = mysqli_query($this->conn, $job_sql);
        
        if($job_data = mysqli_fetch_assoc($job_result)) {
            // Delete the job
            $delete_sql = "DELETE FROM jobs WHERE id = '$job_id'";
            if(mysqli_query($this->conn, $delete_sql)) {
                // Create notification for employer
                $this->createJobDeletedNotification($job_data['employer_id'], $job_data['title']);
                
                // Remove the job posted notification
                $remove_notification_sql = "DELETE FROM notifications WHERE job_id = '$job_id' AND type = 'job_posted'";
                mysqli_query($this->conn, $remove_notification_sql);
                
                return true;
            }
        }
        
        return false;
    }
}
?>

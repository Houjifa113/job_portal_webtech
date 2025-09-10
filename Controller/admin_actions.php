<?php
session_start();
require_once '../Config/database.php';

// Check if user is logged in and is admin
if(!isset($_SESSION['status']) || $_SESSION['user_role'] != 'Admin'){
    echo json_encode(['success' => false, 'error' => 'Unauthorized access']);
    exit();
}

// Handle AJAX requests
$action = $_REQUEST['action'];

if($action == 'add_user'){
    $name = trim($_REQUEST['name']);
    $email = trim($_REQUEST['email']);
    $role = $_REQUEST['role'];
    $password = $_REQUEST['password'];
    
    if($name == "" || $email == "" || $role == "" || $password == ""){
        echo json_encode(['success' => false, 'error' => 'All fields are required']);
        exit();
    }
    
    // Check if email already exists
    $check_sql = "SELECT id FROM users WHERE email = '$email'";
    $check_result = mysqli_query($conn, $check_sql);
    
    if(mysqli_num_rows($check_result) > 0){
        echo json_encode(['success' => false, 'error' => 'Email already exists']);
        exit();
    }
    
    // Insert new user
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $insert_sql = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$hashed_password', '$role')";
    
    if(mysqli_query($conn, $insert_sql)){
        // Log activity
        $log_sql = "INSERT INTO activity_logs (user_id, user_name, action) VALUES ('".$_SESSION['user_id']."', '".$_SESSION['user_name']."', 'Created new user: $name')";
        mysqli_query($conn, $log_sql);
        
        echo json_encode(['success' => true, 'message' => 'User added successfully']);
    }else{
        echo json_encode(['success' => false, 'error' => 'Failed to add user']);
    }
    
}elseif($action == 'update_user'){
    $user_id = $_REQUEST['user_id'];
    $name = trim($_REQUEST['name']);
    $email = trim($_REQUEST['email']);
    $role = $_REQUEST['role'];
    
    // Check if email exists for another user
    $check_sql = "SELECT id FROM users WHERE email = '$email' AND id != '$user_id'";
    $check_result = mysqli_query($conn, $check_sql);
    
    if(mysqli_num_rows($check_result) > 0){
        echo json_encode(['success' => false, 'error' => 'Email already exists']);
        exit();
    }
    
    // Update user
    $update_sql = "UPDATE users SET name = '$name', email = '$email', role = '$role' WHERE id = '$user_id'";
    
    if(mysqli_query($conn, $update_sql)){
        // Log activity
        $log_sql = "INSERT INTO activity_logs (user_id, user_name, action) VALUES ('".$_SESSION['user_id']."', '".$_SESSION['user_name']."', 'Updated user: $name')";
        mysqli_query($conn, $log_sql);
        
        echo json_encode(['success' => true, 'message' => 'User updated successfully']);
    }else{
        echo json_encode(['success' => false, 'error' => 'Failed to update user']);
    }
    
}elseif($action == 'delete_user'){
    $user_id = $_REQUEST['user_id'];
    
    // Get user info before deletion
    $user_sql = "SELECT name, role FROM users WHERE id = '$user_id'";
    $user_result = mysqli_query($conn, $user_sql);
    $user = mysqli_fetch_assoc($user_result);
    
    if(!$user){
        echo json_encode(['success' => false, 'error' => 'User not found']);
        exit();
    }
    
    // Don't allow admin deletion
    if($user['role'] == 'Admin'){
        echo json_encode(['success' => false, 'error' => 'Admin users cannot be deleted']);
        exit();
    }
    
    // Delete user
    $delete_sql = "DELETE FROM users WHERE id = '$user_id'";
    
    if(mysqli_query($conn, $delete_sql)){
        // Log activity
        $log_sql = "INSERT INTO activity_logs (user_id, user_name, action) VALUES ('".$_SESSION['user_id']."', '".$_SESSION['user_name']."', 'Deleted user: ".$user['name']."')";
        mysqli_query($conn, $log_sql);
        
        echo json_encode(['success' => true, 'message' => 'User deleted successfully']);
    }else{
        echo json_encode(['success' => false, 'error' => 'Failed to delete user']);
    }
}else{
    echo json_encode(['success' => false, 'error' => 'Invalid action']);
}
?>
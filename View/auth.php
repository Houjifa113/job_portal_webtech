<?php
session_start();
require_once '../Model/database.php';

// Handle Registration
if(isset($_REQUEST['register'])){
    $name = trim($_REQUEST['name']);
    $email = trim($_REQUEST['email']);
    $role = $_REQUEST['role'];
    $password = $_REQUEST['password'];
    $confirm_password = $_REQUEST['confirm_password'];
    
    if($name == "" || $email == "" || $role == "" || $password == "" || $confirm_password == ""){
        header('location: auth.php?error=null');
    }elseif($password != $confirm_password){
        header('location: auth.php?error=mismatch');
    }else{
        // Check if email already exists
        $check_sql = "SELECT id FROM users WHERE email = '$email'";
        $check_result = mysqli_query($conn, $check_sql);
        
        if(mysqli_num_rows($check_result) > 0){
            header('location: auth.php?error=exists');
        }else{
            // Insert new user
            $hashed_password = $password;
            $insert_sql = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$hashed_password', '$role')";
            
            if(mysqli_query($conn, $insert_sql)){
                // Log activity
                $log_sql = "INSERT INTO activity_logs (user_name, action) VALUES ('$name', 'User registered with role: $role')";
                mysqli_query($conn, $log_sql);
                
                header('location: auth.php?success=registered');
            }else{
                header('location: auth.php?error=failed');
            }
        }
    }
}

// Handle Login
if(isset($_REQUEST['login'])){
    $email = trim($_REQUEST['login_email']);
    $password = $_REQUEST['login_password'];
    
    if($email == "" || $password == ""){
        header('location: auth.php?error=login_null');
    }else{
        $sql = "SELECT id, name, email, password, role FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        
        if(mysqli_num_rows($result) == 1){
            $user = mysqli_fetch_assoc($result);
            
            if($password == $user['password']){
                $_SESSION['status'] = true;
                if(!isset($user['id'])){
                    echo 2;
                }
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role'];
                
                // Log activity
                $log_sql = "INSERT INTO activity_logs (user_id, user_name, action) VALUES ('".$user['id']."', '".$user['name']."', 'User logged in')";
                mysqli_query($conn, $log_sql);
                
                // Redirect based on role
                if($user['role'] == 'Admin'){
                    header('location: admin.php');
                }elseif($user['role'] == 'Employer'){
                    header('location: employer.php');
                }elseif($user['role'] == 'Job Seeker'){
                    header('location: jobseeker.php');
                }else{
                    header('location: auth.php?error=invalid_role');
                }
            }else{
                header('location: auth.php?error=invalid');
            }
        }else{
            header('location: auth.php?error=invalid');
        }
    }
}

// Error handling
if(isset($_REQUEST['error'])){
    if($_REQUEST['error'] == "null"){
        $error = "All fields are required.";
    }elseif($_REQUEST['error'] == "mismatch"){
        $error = "Passwords do not match.";
    }elseif($_REQUEST['error'] == "exists"){
        $error = "Email already exists. Please use a different email.";
    }elseif($_REQUEST['error'] == "failed"){
        $error = "Registration failed. Please try again.";
    }elseif($_REQUEST['error'] == "login_null"){
        $login_error = "Email and password are required.";
    }elseif($_REQUEST['error'] == "invalid"){
        $login_error = "Invalid email or password.";
    }elseif($_REQUEST['error'] == "invalid_role"){
        $login_error = "Invalid user role.";
    }
}

// Success handling
if(isset($_REQUEST['success'])){
    if($_REQUEST['success'] == "registered"){
        $success = "Registration successful! Please login to continue.";
    }
}
?>

<!-- Auth View (With Database Integration) -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Registration</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        
        .form-toggle {
            display: flex;
            margin-bottom: 30px;
            border-radius: 5px;
            overflow: hidden;
            border: 2px solid #667eea;
        }
        
        .toggle-btn {
            flex: 1;
            padding: 12px;
            background: #f8f9fa;
            border: none;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        
        .toggle-btn.active {
            background: #667eea;
            color: white;
        }
        
        .form-section {
            display: none;
        }
        
        .form-section.active {
            display: block;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        
        input, select {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }
        
        input:focus, select:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .btn {
            width: 100%;
            padding: 12px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        
        .btn:hover {
            background: #5a6fd8;
        }
        
        .error {
            color: #e74c3c;
            background: #fdf2f2;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #e74c3c;
        }
        
        .success {
            color: #27ae60;
            background: #f1f9f4;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #27ae60;
        }
        
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-toggle">
            <button type="button" class="toggle-btn active" onclick="showLogin()">Login</button>
            <button type="button" class="toggle-btn" onclick="showRegister()">Register</button>
        </div>

        <!-- Login Form -->
        <div id="login-form" class="form-section active">
            <h2>Login</h2>
            
            <?php if (isset($login_error)): ?>
                <div class="error"><?=$login_error?></div>
            <?php endif; ?>
            
            <?php if (isset($login_success)): ?>
                <div class="success"><?=$login_success?></div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="login_email">Email:</label>
                    <input type="email" id="login_email" name="login_email" required>
                </div>
                
                <div class="form-group">
                    <label for="login_password">Password:</label>
                    <input type="password" id="login_password" name="login_password" required>
                </div>
                
                <button type="submit" name="login" class="btn">Login</button>
            </form>
        </div>

        <!-- Registration Form -->
        <div id="register-form" class="form-section">
            <h2>Register</h2>
            
            <?php if (isset($error)): ?>
                <div class="error"><?=$error?></div>
            <?php endif; ?>
            
            <?php if (isset($success)): ?>
                <div class="success"><?=$success?></div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="name">Full Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="role">Role:</label>
                    <select id="role" name="role" required>
                        <option value="">Select Role</option>
                        <option value="Admin">Admin</option>
                        <option value="Employer">Employer</option>
                        <option value="Job Seeker">Job Seeker</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">Confirm Password:</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                
                <button type="submit" name="register" class="btn">Register</button>
            </form>
        </div>
    </div>

    <script>
        function showLogin() {
            document.getElementById('login-form').classList.add('active');
            document.getElementById('register-form').classList.remove('active');
            document.querySelector('.toggle-btn:first-child').classList.add('active');
            document.querySelector('.toggle-btn:last-child').classList.remove('active');
        }

        function showRegister() {
            document.getElementById('register-form').classList.add('active');
            document.getElementById('login-form').classList.remove('active');
            document.querySelector('.toggle-btn:last-child').classList.add('active');
            document.querySelector('.toggle-btn:first-child').classList.remove('active');
        }
    </script>
</body>
</html>
<?php
require_once '../Model/config.php';  // config.php already has session_start()

// Only redirect if user is logged in and trying to access login page
if (isLoggedIn() && basename($_SERVER['PHP_SELF']) === 'UserAuthetication.php') {
    redirectDashboard($_SESSION['role']);
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Authentication</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
            text-align: center;
        }
        h1 { margin-bottom: 30px; }
        .container {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .btn {
            padding: 10px 20px;
            margin: 5px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            background-color: #007bff;
            color: white;
        }
        .btn-success { background-color: #28a745; }
        input, select {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .error {
            color: red;
            font-size: 14px;
            margin: 5px 0;
        }
        #signupForm { display: none; }
    </style>
</head>
<body> 
    <h1>User Authentication</h1>

    <!--Toggle Buttons-->
    <button class="btn" id="showLogin" onclick="showlogin()">Login</button>
    <button class="btn" id="showSignup" onclick="showsignup()">Sign Up</button>

    <!--Login Form-->
    <div class="container" id="login">
      <form action="../Controller/loginCheck.php" method="post" onsubmit="return login()">  
        <?php csrf_field(); ?>
        
        <input type="email" id="loginEmail" placeholder="Email" name="email" required><br>
        <p id="emailerror" class="error"></p>

        <input type="password" id="loginPassword" placeholder="Password" name="password" required><br>
        <p id="passerror" class="error"></p>

        <button class="btn btn-success" type="submit">Login</button>
      </form>
    </div>
 
    <!-- Signup Form -->
    <div class="container" id="signupForm" >
      <h2>Sign Up</h2>
      <form id="signup" action="../Controller/SignUpCheck.php" method="post" onsubmit="return signup()">
        <?php csrf_field(); ?>
        <input type="text" id="signupName" placeholder="Full Name" name="signupname" required><br>
        <p id="sname" class="error"></p>

        <input type="email" id="signupEmail" placeholder="Email" name="signupemail" required><br>
        <p id="semail" class="error"></p>

        <select name="role" id="role" required>
            <option value="">Select Role</option>
            <option value="Admin">Admin</option>
            <option value="Employer">Employer</option>
            <option value="Job Seeker">Job Seeker</option>
        </select><br>
        <p id="roleError" class="error"></p>

        <input type="password" id="signupPassword" placeholder="Password" name="signuppassword" required><br>
        <p id="spass" class="error"></p>

        <input type="password" id="confirmpassword" placeholder="Confirm Password" name="confirmpassword" required><br>
        <p id="cpass" class="error"></p>

        <button type="submit">Sign Up</button>
      </form>
    </div>
    
    <script src="../Asset/userauth.js"></script>
</body>
</html>
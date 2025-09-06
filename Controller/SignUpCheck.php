<?php
session_start();

$username = $_REQUEST['signupname'];
$email = $_REQUEST['signupemail'];
$password = $_REQUEST['signuppassword'];
$confirmpassword = $_REQUEST['confirmpassword'];

// Check if null
if($username == "" || $email == "" || $password == "" || $confirmpassword == ""){
    header('location: ../Views/UserAuthetication.php?signuperror=null');
    exit();
}

// Email validation (same as login)
if(strpos($email, '@') === false || strpos($email, '.') === false){
    header('location: ../Views/UserAuthetication.php?signuperror=invalidemail');
    exit();
}

// Password length validation
if(strlen($password) < 8){
    header('location: ../Views/UserAuthetication.php?signuperror=shortpassword');
    exit();
}

// Confirm password match
if($password != $confirmpassword){
    header('location: ../Views/UserAuthetication.php?signuperror=passwordmismatch');
    exit();
}

$_SESSION['signup_success'] = true;
header('location: ../Views/UserAuthetication.php?signup=success');
exit();
?>

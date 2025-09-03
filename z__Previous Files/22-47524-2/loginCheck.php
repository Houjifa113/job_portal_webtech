<?php
session_start();


$email = $_REQUEST['email'];
$password = $_REQUEST['password'];


$testUser = array('test', 'test@aiub.edu', 'Maimunaa');


if($email == "" || $password == ""){
    header('location: UserAuthetication.php?error=null');
    exit();
}
else{
    
    if(strpos($email, '@') === false || strpos($email, '.') === false){
    header('location: UserAuthetication.php?error=invalidemail');
    exit();
    
}
    

    else if(strlen($password)< 8){
        header('location: UserAuthetication.php?error=shortpassword');
        exit();
    }
   
    

    else if($email == $testUser[1] && $password == $testUser[2]){
        

        $_SESSION['status'] = true;
        $_SESSION['user_email'] = $email;
        setcookie('status', true, time()+3000, '/');
        header('location: dashboard.php');
    }
    else{
        header('location: UserAuthetication.php?error=invalid');
    }
}
?>
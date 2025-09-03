<?php
    session_start();
    $username = trim($_REQUEST['username']);
    $password = trim($_REQUEST['password']);

    if($username == "" || $password == ""){
        header('location: ../view/login.php?error=null');
    }else{
        if($username == $password){
            $_SESSION['username'] = $username;
            $_SESSION['status'] = 'valid';
            setcookie('status', 'valid', time()+3000, '/');
            header('location: ../view/home.php');
        }else{
            header('location: ../view/login.php?error=invalid');
        }
    }
?>
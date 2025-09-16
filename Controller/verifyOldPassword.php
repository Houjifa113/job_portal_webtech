<?php
    require_once('../model/userModel.php');
    session_start();
    if(isset($_SESSION['status'])){
        if($_SESSION['status'] != 'valid'){
            header('location: login.php?error=badrequest');
        }
    }else{
        header('location: login.php?error=badrequest');
    }

    if(isset($_COOKIE['status'])){
        if($_COOKIE['status'] != 'valid'){
            header('location: login.php?error=badrequest');
        }
    }else{
        header('location: login.php?error=badrequest');
    }

    $password = $_POST['password'] ?? '';
    $id = $_SESSION['id'] ?? '';
    $oldpassword = getPassword($id);
    if ($password === '') {
        echo 'invalid';
    } elseif ($password !== $oldpassword) {
        echo 'invalid';
    } else {
        echo 'valid';
    }
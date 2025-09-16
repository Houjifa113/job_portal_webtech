<?php
require_once('../model/userModel.php');
session_start();
$id=$_SESSION['id'];
    if(isset($_SESSION['status'])){
        if($_SESSION['status'] != 'valid'){
            header('location: login.php?error=badrequest');
            exit();
        }
    }else{
        header('location: login.php?error=badrequest');
        exit();
    }
    if(isset($_COOKIE['status'])){
        if($_COOKIE['status'] != 'valid'){
            header('location: login.php?error=badrequest');
            exit();
        }
    }else{
        header('location: login.php?error=badrequest');
        exit();
    }
    
    if (!isset($_SESSION['id'])) {
            header('location: login.php?error=badrequest');
            exit();
        }
    
    echo json_encode(getStrengthByID($id));
    exit();
<?php
require_once('../model/userModel.php');
    session_start();
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

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        if(deleteSavedSearches($_REQUEST['id'])){
            echo "success";
        }else{
            echo "failed";
        }
    }else{
        header('location: login.php?error=badrequest');
        exit();
    }
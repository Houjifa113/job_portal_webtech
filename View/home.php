<?php
    session_start();
    if(isset($_SESSION['status'])){
        if($_SESSION['status'] != 'valid'){
            header('location: login.php?error=badrequest');
        }
    }else{
        header('location: login.php?error=badrequest');
    }

    if(!isset($_COOKIE['status'])){
        header('location: login.php?error=badrequest');
    }
    header('location: ./dashboard.php');

?>
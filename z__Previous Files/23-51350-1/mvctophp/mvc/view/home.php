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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
        <h1>welcome Home! <?=$_SESSION['username']?></h1>
        <br>
        <button onclick="location.href='./careerTips.php'">Career Tips</button>
        <br>
        <button onclick="location.href='./profileManagement.php'">Profile Manager</button>
        <br>
        <button onclick="location.href='./resume.php'">Resume Manager</button>
        <br>
        <button onclick="location.href='./careerTips.php'">Career guides</button>
        <br>
        <button onclick="location.href='./error.php'">Error</button>
        <br>
        
        <a href="../controller/logout.php">logout </a>
</body>
</html>
<?php
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
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Saved Searches</title>
</head>
<link rel="stylesheet" href="../asset/style.css">
<body>
    <a href="#"><input type="button" value="Home" id="home" class="tips-button" style="position: absolute;left: 2%;top: 2%;width: 8%;"></a>
    <table class="standardTable">
    <tr>
    <td style="padding: 3%;"><a href="#"><input type="button" value="Template #1" id="template1" class="tips-button"></a></td>
    </tr>
    <tr >
    <td style="padding: 3%;"><a href="#"><input type="button" value="Template #2" id="template2" class="tips-button"></a></td>
    </tr>
    <tr >
    <td style="padding: 3%;"><a href="#"><input type="button" value="Checklist #1" id="checklist1" class="tips-button"></a></td>
    </tr>
    <tr >
    <td style="padding: 3%;"><a href="#"><input type="button" value="Checklist #2" id="checklist2" class="tips-button"></a></td>
    </tr>
    </table>
</body>

<script src="../asset/script.js"></script>
</html>
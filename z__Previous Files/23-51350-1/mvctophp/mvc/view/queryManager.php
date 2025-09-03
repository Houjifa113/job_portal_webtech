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
    <a href="./home.php"><input type="button" value="Home" id="home" class="search-button" style="position: absolute;left: 2%;top: 2%;width: 8%;"></a>
    
    <table class="standardTable2" id="queryManagerTable">
    <tr>
    <td style="padding: 3%; background-color: red; color: azure; text-align: left;border-radius: 5px;" colspan="6">
        <b>Saved Searches</b>
    </td></tr>
    <tr>
        <td style="padding: 1%;color: azure; text-align: center;" colspan="2">
            <p><b>Job Title</b></p>
        </td>
        <td style="padding: 1%;color: azure; ">
            <p><b>Status</b></p>
        </td>
        <td style="padding: 1%;color: azure; ">
            <p><b>Location</b></p>
        </td>
        <td style="padding: 1%;color: azure; ">
            <p><b>Go to</b></p>
        </td>
        <td style="padding: 1%;color: azure; ">
            <p><b>Delete</b></p>
        </td>
    </tr>

    </table>
</body>

<script src="../asset/script.js"></script>
</html>
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

    <table class="standardTable2" id="searchHistoryTable">
    <tr>
    <td style="padding: 3%; background-color: red; color: azure; text-align: left;" colspan="5">
        <b>Search History</b>
    </td></tr>
    <tr>
        <td colspan="2">
            <p>Job Title</p>
        </td>
        <td >
            <p>Status</p>
        </td>
        <td >
            <p>Location</p>
        </td>
        <td >
            <p>Go to</p>
        </td>
    </tr>
    </table>
</body>

<script src="../asset/script.js"></script>
</html>
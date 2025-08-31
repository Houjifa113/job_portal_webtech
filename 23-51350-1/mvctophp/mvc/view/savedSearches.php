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
    <div style="position: absolute; top: 2%; right: 2%;">
        <input type="checkbox" id="autoRefreshToggle" onchange="toggleRefresh()"> Auto-Refresh
    </div>
    <table class="standardTable">
    <tr>
    <td style="padding: 3%;"><a href="./searchHistory.php"><input type="button" value="Search History" id="searchHistory" class="search-button"></a></td>
    </tr>
    <tr >
    <td style="padding: 3%;"><a href="./queryManager.php"><input type="button" value="Query Manager" id="queryManager" class="search-button"></a></td>
    </tr>
    </table>
</body>

<script src="../asset/script.js"></script>
</html>
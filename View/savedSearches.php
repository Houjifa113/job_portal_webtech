<?php
session_start();
if (!isset($_SESSION['status']) || $_SESSION['status'] != 'valid') {
    header('location: login.php?error=badrequest');
    exit;
}
if (!isset($_COOKIE['status']) || $_COOKIE['status'] != 'valid') {
    header('location: login.php?error=badrequest');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Saved Searches</title>
    <style>
        body {
            background-color: #252525;
            font-family: Arial, sans-serif;
            color: white;
        }
        .standardTable {
            width: 80%;
            border: 1px solid #FF0000;
            border-radius: 20px;
            padding: 3%;
            background-color: #333333;
            margin: 10%;
            text-align: center;
        }
        .standardTable td {
            padding: 8px 10px;
            border: none;
        }
        .standardTable label {
            font-weight: normal;
            color: #fff;
        }
        .search-button {
            background-color: #FF0000;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            width: 70%;
        }
    </style>
</head>
<body>
    <a href="./home.php">
        <input type="button" value="Home" id="home" class="search-button" style="position: absolute;left: 2%;top: 2%;width: 8%;">
    </a>
    <div style="position: absolute; top: 2%; right: 2%;">
        <input type="checkbox" id="autoRefreshToggle" onchange="toggleRefresh()"> Auto-Refresh
    </div>
    <table class="standardTable">
        <tr>
            <td style="padding: 3%;">
                <a href="./searchHistory.php">
                    <input type="button" value="Search History" id="searchHistory" class="search-button">
                </a>
            </td>
        </tr>
        <tr>
            <td style="padding: 3%;">
                <a href="./queryManager.php">
                    <input type="button" value="Query Manager" id="queryManager" class="search-button">
                </a>
            </td>
        </tr>
    </table>
</body>
<script>
function toggleRefresh() {
    return true;
}

</script>
</html>
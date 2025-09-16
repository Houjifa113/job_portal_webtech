<?php
session_start();

if (!isset($_SESSION['status']) || $_SESSION['status'] != 'valid') {
    header('location: login.php?error=badrequest');
    exit();
}

if (!isset($_COOKIE['status']) || $_COOKIE['status'] != 'valid') {
    header('location: login.php?error=badrequest');
    exit();
}
if (!isset($_SESSION['id'])) {
    header('location: login.php?error=badrequest');
    exit();
}else{
    $id = $_SESSION['id'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Search History</title>
</head>
<style>
    body {
        background-color: #252525;
        font-family: Arial, sans-serif;
        color: white;
    }

    .standardTable2 {
        width: 80%;
        border: 1px solid #FF0000;
        border-radius: 20px;
        padding: 3%;
        background-color: #333333;
        margin: 10%;
        border-collapse: collapse;
    }

    .standardTable2 td {
        padding: 8px 10px;
        border: none;
        color: white;
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
<body>
    <a href="./home.php">
        <input type="button" value="Home" id="home" class="search-button" style="position: absolute;left: 2%;top: 2%;width: 8%;">
    </a>
    <table class="standardTable2" id="searchHistoryTable">
        <tr>
            <td style="padding: 3%; background-color: red; color: azure; text-align: left;" colspan="5">
                <b>Search History</b>
            </td>
        </tr>
        <tr>
            <td colspan="2"><p>Job Title</p></td>
            <td><p>Status</p></td>
            <td><p>Go to</p></td>
        </tr>
    </table>
    <script>
        let id = <?php echo $id; ?>;
        let XHTTP = new XMLHttpRequest();
        XHTTP.open("POST", "../controller/getSearchHistory.php", true);
        XHTTP.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        XHTTP.send(); 
        XHTTP.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                let searchHistory = JSON.parse(this.responseText);
                let table = document.getElementById("searchHistoryTable");
                if (table) {
                    searchHistory.forEach(item => {
                        const row = document.createElement("tr");
                        const jobTitleTd = document.createElement("td");
                        jobTitleTd.colSpan = 2;
                        jobTitleTd.textContent = item.job_title;
                        row.appendChild(jobTitleTd);
                        const statusTd = document.createElement("td");
                        statusTd.textContent = item.status;
                        row.appendChild(statusTd);
                        const goToTd = document.createElement("td");
                        const btn = document.createElement("button");
                        btn.textContent = "Click here";
                        btn.className = "search-button";
                        const url = `/searchBar.html?JobTitle=${encodeURIComponent(item.job_title)}&Status=${encodeURIComponent(item.status)}`;
                        const link = document.createElement("a");
                        link.href = url;
                        link.appendChild(btn);
                        goToTd.appendChild(link);
                        row.appendChild(goToTd);
                        table.appendChild(row);
                    });
                }
            }
        };
    </script>
</body>
</html>

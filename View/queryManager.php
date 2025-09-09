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

    .standardTable2 td.tableButton {
        border: 1px solid #FF0000;
        cursor: pointer;
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
    <table class="standardTable2" id="queryManagerTable">
        <tr>
            <td style="padding: 3%; background-color: red; color: azure; text-align: left;border-radius: 5px;" colspan="6">
                <b>Saved Searches</b>
            </td>
        </tr>
        <tr>
            <td style="padding: 1%;color: azure; text-align: center;" colspan="2">
                <p><b>Job Title</b></p>
            </td>
            <td style="padding: 1%;color: azure;">
                <p><b>Status</b></p>
            </td>
            <td style="padding: 1%;color: azure;">
                <p><b>Go to</b></p>
            </td>
            <td style="padding: 1%;color: azure;">
                <p><b>Delete</b></p>
            </td>
        </tr>
    </table>
    <script>
        let searchHistory = [
            { JobTitle: "Software Engineer", Status: "Remote" },
            { JobTitle: "Data Scientist", Status: "Hybrid" },
            { JobTitle: "Product Manager", Status: "On-site" },
        ];

        let table2 = document.getElementById("queryManagerTable");
        if (table2 && typeof searchHistory !== "undefined") {
            for (let i = 0; i < searchHistory.length; i++) {
                let row = document.createElement("tr");

                let jobTitleTd = document.createElement("td");
                jobTitleTd.style.padding = "1%";
                jobTitleTd.style.color = "azure";
                jobTitleTd.style.textAlign = "center";
                jobTitleTd.colSpan = 2;
                jobTitleTd.textContent = searchHistory[i]["JobTitle"];
                row.appendChild(jobTitleTd);

                let statusTd = document.createElement("td");
                statusTd.textContent = searchHistory[i]["Status"];
                row.appendChild(statusTd);


                let goToTd = document.createElement("td");
                let btn = document.createElement("button");
                btn.textContent = "Click here";
                btn.className = "search-button";

                let url = "/searchBar.html?";
                url += "JobTitle=" + encodeURIComponent(searchHistory[i]["JobTitle"]);
                url += "&Status=" + encodeURIComponent(searchHistory[i]["Status"]);

                let link = document.createElement("a");
                link.href = url;
                link.appendChild(btn);

                goToTd.appendChild(link);
                row.appendChild(goToTd);

                let deleteTd = document.createElement("td");
                let deleteBtn = document.createElement("button");
                deleteBtn.textContent = "Delete";
                deleteBtn.className = "search-button";
                deleteBtn.onclick = function () {
                    table2.removeChild(row);
                    searchHistory.splice(i, 1);
                };
                deleteTd.appendChild(deleteBtn);
                row.appendChild(deleteTd);

                table2.appendChild(row);
            }
        }
    </script>
</body>
</html>

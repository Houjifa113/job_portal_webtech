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
    <title>Resume manager</title>
</head>
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

    .resume-button {
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
    <a href="./home.php"><input type="button" value="Home" id="home" class="resume-button" style="position: absolute;left: 2%;top: 2%;width: 8%;"></a>
    <table class="standardTable">
    <tr>
    <td style="padding: 3%;"><a href="./uploadResume.php"><input type="button" value="Upload Resume" id="uploadButton" class="resume-button"></a></td>
    </tr>
    <tr >
    <td style="padding: 3%;"><a href="./template.php"><input type="button" value="Create Resume Using Template" id="createButton" class="resume-button"></a></td>
    </tr>
    <tr>
    <td style="padding: 3%;"><a href="./profileStrength.php"><input type="button" value="Check profile strength" id="profileStrength" class="resume-button"></a></td>
    </tr>
    </table>

</body>

<script src="../asset/script.js"></script>
</html>
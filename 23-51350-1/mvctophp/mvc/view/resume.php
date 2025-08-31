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
<link rel="stylesheet" href="../asset/style.css">
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
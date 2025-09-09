<!DOCTYPE html>
<html lang="en">
<head>
    <title>Profile Manager</title>
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

    .tips-button {
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
    <a href="./home.php"><input type="button" value="Home" id="home" class="profile-button" style="position: absolute;left: 2%;top: 2%;width: 8%;"></a>
    <table class="standardTable">
    <tr>
    <td style="padding: 3%;"><a href="./viewProfile.php"><input type="button" value="View Profile" id="viewProfile" class="profile-button"></a></td>
    </tr>
    <tr>
    <td style="padding: 3%;"><a href="./editProfile.php"><input type="button" value="Edit Profile" id="editProfile" class="profile-button"></a></td>
    </tr>
    <tr>
    <td style="padding: 3%;"><a href="./changePicture.php"><input type="button" value="Change Picture" id="changePicture" class="profile-button"></a></td>
    </tr>
    <tr>
    <td style="padding: 3%;"><a href="./updatePassword.php"><input type="button" value="Update Password" id="updatePassword" class="profile-button"></a></td>
    </tr>
    </table>
    <script src="../asset/script.js"></script>
</body>
</html>
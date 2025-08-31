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
	<title>Update Password</title>
	<link rel="stylesheet" href="../asset/style.css">
</head>
<body>
    <a href="./home.php"><input type="button" value="Home" id="home" class="profile-button" style="position: absolute;left: 2%;top: 2%;width: 8%;"></a>
<table class="standardTable">
    <form id="updatePasswordForm" onsubmit="return validatePasswords()" method="post" action="#">
        <tr>
            <td style="padding: 3%;" ><label for="password0">Old Password:</label></td>
            <td><input type="password" id="password0" name="password0" ></td>
        </tr>
        <tr>
            <td style="padding: 3%;" ><label for="password1">New Password:</label></td>
            <td><input type="password" id="password1" name="password1" ></td>
        </tr>
        <tr>
            <td style="padding: 3%;"><label for="password2">Confirm Password:</label></td>
            <td><input type="password" id="password2" name="password2" ></td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center; padding: 3%;">
                <input type="submit" value="Update Password" class="profile-button">
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <p id="errorMsg" class="error"></p>
            </td>
        </tr>
    </form>
</table>

    <script>
    function validatePasswords() {
        let p0 = document.getElementById('password0').value;
        let p1 = document.getElementById('password1').value;
        let p2 = document.getElementById('password2').value;
        let errorMsg = document.getElementById('errorMsg');
        if (p0 === '' || p1 === '' || p2 === '') {
            errorMsg.textContent = 'All fields are required.';
            errorMsg.style.color = 'red';
            return false;
        }
        if(p0!=='7892') {
            errorMsg.textContent = 'Passwords invalid, please try again.';
            errorMsg.style.color = 'red';
            return false;
        }
        if (p1 === p2) {
            if(p1===p0)
            {
            errorMsg.textContent = 'New password cannot be the same as old password.';
                errorMsg.style.color = 'red';
                return false;
            }
            errorMsg.textContent = 'Password updated successfully.';
            errorMsg.style.color = 'green';
            return false;
        } else {
            errorMsg.textContent = 'Passwords invalid, please try again.';
            errorMsg.style.color = 'red';
            return false;
        }
    }
    </script>
</body>
</html>

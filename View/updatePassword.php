<?php
    require_once('../model/userModel.php');
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
    $msg = $_GET['msg']??"";
    $id=$_SESSION['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Update Password</title>
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

    .standardTable label {
        font-weight: normal;
        color: #fff;
    }

    .standardTable input[type="password"] {
        width: 95%;
        padding: 6px 8px;
        border: 1px solid #888;
        border-radius: 4px;
        font-size: 15px;
        background: #222;
        color: #fff;
        box-sizing: border-box;
    }

    .profile-button {
        background-color: #FF0000;
        color: white;
        border: none;
        padding: 10px;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        width: 70%;
    }

    #errorMsg {
        color: #FF7070;
        font-size: 15px;
        padding-left: 5px;
    }
</style>
<body>
    <a href="./home.php"><input type="button" value="Home" id="home" class="profile-button" style="position: absolute;left: 2%;top: 2%;width: 8%;"></a>
<table class="standardTable">
    <form id="updatePasswordForm" onsubmit="return validatePasswords()" method="post" action="../controller/updatePasswordCheck.php">
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
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
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
    
    let msg = "<?php echo $msg ?>";
    if(msg==='okay'){
        document.getElementById('errorMsg').textContent = 'Password updated successfully.';
        document.getElementById('errorMsg').style.color = 'green';
       }
    else {
        document.getElementById('errorMsg').textContent = msg;
        document.getElementById('errorMsg').style.color = 'red';
       }

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
        let XHTTP = new XMLHttpRequest();
        XHTTP.open("POST", "../controller/verifyOldPassword.php", true);
        XHTTP.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        XHTTP.send("password=" + encodeURIComponent(p0));
        XHTTP.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                if (this.responseText.trim() !== "valid") {
                    errorMsg.textContent = 'Passwords are incorrect.';
                    errorMsg.style.color = 'red';
                    return false;
                }
            }
        };
        if(p0==='') {
            errorMsg.textContent = 'Passwords invalid, please try again.22';
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
            return true;
        } else {
            errorMsg.textContent = 'Passwords invalid, please try again.2';
            errorMsg.style.color = 'red';
            return false;
        }
    }
    </script>
</body>
</html>

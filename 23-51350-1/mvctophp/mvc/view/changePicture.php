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
    <title>Profile Manager</title>
    <link rel="stylesheet" href="../asset/style.css" />
  </head>
  <body>
    <img id="profilePictureImage" src=""  />
    <a href="./home.php"
      ><input
        type="button"
        value="Home"
        id="home"
        class="profile-button"
        style="position: absolute; left: 2%; top: 2%; width: 8%"
    /></a>
    <table class="standardTable">
        <form enctype="multipart/form-data" method="post" onsubmit="return validateProfilePic()">
      <tr>
        <td style="padding: 3%">
          <input type="file" name="profilePicture" id="profilePicture" />
        </td>
      </tr>
      <tr>
        <td id="profilePicError" style="padding: 3%"></td>
      </tr>
      <tr>
        <td style="padding: 3%"><input type="submit" value="Submit" class="profile-button"/></td>
      </tr>
    </form>
    </table>
    <script src="../asset/script.js"></script>
  </body>
</html>

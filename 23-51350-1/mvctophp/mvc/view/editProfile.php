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
    <title>View Profile</title>
    <link rel="stylesheet" href="../asset/style.css" />
  </head>
  <body>
    <a href="./changePicture.php">
      <div class="profile-picture-container">
        <img id="viewProfilePictureImage" src="" />
        <div id="profile-picture-overlay">Change Picture</div>
      </div>
    </a>
    <a href="./home.php"
      ><input
        type="button"
        value="Home"
        id="home"
        class="profile-button"
        style="position: absolute; left: 2%; top: 2%; width: 8%"
    /></a>
    <table class="standardTable">
      <form
        enctype="multipart/form-data"
        method="post"
        onsubmit="return validateEditProfile()"
      >
        <tr>
          <td style="padding: 3%">
            <label for="fullName">Full Name: </label>
          </td>
          <td>
            <input type="text" name="fullName" id="fullName" />
          </td>
        </tr>
        <tr>
          <td style="padding: 3%">
            <label for="email">Email: </label>
          </td>
          <td>
            <input type="email" name="email" id="email" />
          </td>
        </tr>
        <tr>
          <td style="padding: 3%">
            <label for="phone">Phone Number: </label>
          </td>
          <td>
            <input type="text" name="phone" id="phone" />
          </td>
        </tr>
        <tr>
          <td style="padding: 3%">
            <label for="linkedIn">LinkedIn: </label>
          </td>
          <td>
            <input type="text" name="linkedIn" id="linkedIn" />
          </td>
        </tr>
        <tr>
          <td style="padding: 3%">
            <label for="bio">Bio: </label>
          </td>
          <td>
            <textarea name="bio" id="bio"></textarea>
          </td>
        </tr>
        <tr>
          <td style="padding: 3%">
            <label for="education">Education: </label>
          </td>
          <td>
            <input type="text" name="education" id="education" />
          </td>
        </tr>
        <tr>
          <td style="padding: 3%">
            <label for="skills">Skills: </label>
          </td>
          <td>
            <input type="text" name="skills" id="skills" />
          </td>
        </tr>
        <tr>
          <td style="padding: 3%">
            <label for="experience">Work Experience: </label>
          </td>
          <td>
            <textarea name="experience" id="experience"></textarea>
          </td>
        </tr>
        <tr>
            <td>
                <p id="profileError" ></p>
            </td>
        </tr>
        <tr>
          <td></td>
          <td style="padding: 3%">
            <input type="submit" value="Submit" class="profile-button" />
          </td>
        </tr>
      </form>
    </table>
    <script src="../asset/script.js">
    </script>
  </body>
</html>

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
      <tr>
        <td style="padding: 3%">
          <label for="FullName">Full Name: </label>
        </td>
        <td>
          <p id="fullNameDisplay"></p>
        </td>
      </tr>
      <tr>
        <td style="padding: 3%">
          <label for="Email">Email: </label>
        </td>
        <td>
          <p id="emailDisplay"></p>
        </td>
      </tr>
      <tr>
        <td style="padding: 3%">
          <label for="Phone">Phone Number: </label>
        </td>
        <td>
          <p id="phoneDisplay"></p>
        </td>
      </tr>
      <tr>
        <td style="padding: 3%">
          <label for="LinkedIn">LinkedIn: </label>
        </td>
        <td>
          <p id="linkedInDisplay"></p>
        </td>
      </tr>
      <tr>
        <td style="padding: 3%">
          <label for="Bio">Bio: </label>
        </td>
        <td>
          <p id="bioDisplay"></p>
        </td>
      </tr>
      <tr>
        <td style="padding: 3%">
          <label for="Education">Education: </label>
        </td>
        <td>
          <p id="educationDisplay"></p>
        </td>
      </tr>
      <tr>
        <td style="padding: 3%">
          <label for="Skills">Skills: </label>
        </td>
        <td>
          <p id="skillsDisplay"></p>
        </td>
      </tr>
      <tr>
        <td style="padding: 3%">
          <label for="Experience">Work Experience: </label>
        </td>
        <td>
          <p id="experienceDisplay"></p>
        </td>
      </tr>
      <tr>
        <td style="padding: 3%">
          <a href="./editProfile.php"
            ><input type="button" value="Edit Profile" class="profile-button"
          /></a>
        </td>
      </tr>
    </table>
    <script src="../asset/script.js"></script>
  </body>
</html>

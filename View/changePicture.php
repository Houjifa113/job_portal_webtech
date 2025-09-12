<?php
  require_once('../controller/getProfilePicLocation.php');
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
    if(isset($_GET['msg'])){
        $msg = $_GET['msg'];
    }
    else{
        $msg = "";
    }
    $id=$_SESSION['id'];
    $location = getProfilePicLocation($id);

?>


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

    .standardTable label {
      font-weight: normal;
      color: #fff;
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

    #profilePicError {
      color: #FF7070;
      font-size: 15px;
      padding-left: 5px;
    }

    #profilePictureImage {
      position: absolute;
      left: 45%;
      top: 2%;
      width: 90px;
      height: 90px;
      border-radius: 75px;
    }
  </style>
  <body>
    <img id="profilePictureImage" src="<?php echo $location; ?>"  />
    <a href="./home.php"
      ><input
        type="button"
        value="Home"
        id="home"
        class="profile-button"
        style="position: absolute; left: 2%; top: 2%; width: 8%"
    /></a>
    <table class="standardTable">
        <form enctype="multipart/form-data" method="post" onsubmit="return validateProfilePic()" action="../controller/profilePictureCheck.php">
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
    <script >
      
          let fileInput = document.getElementById('profilePicture');
          let fileError = document.getElementById('profilePicError');
          let msg = "<?php echo ($msg); ?>";
      if(msg==='success'){
        fileError.innerHTML = 'Profile picture updated successfully.';
        fileError.style.color = 'green';
       }
      else if(msg==='invalid_type'){
          fileError.innerHTML = "Please select a JPG, JPEG, or PNG image!";
          fileError.style.color = "red";
      }
      else if(msg==='size_exceeded'){
          fileError.innerHTML = "File size should not exceed 5MB!";
          fileError.style.color = "red";
      }
      else if(msg==='error'){
          fileError.innerHTML = "There was an error uploading your file. Please try again.";
          fileError.style.color = "red";
      }
      else if(msg==='no_file'){
          fileError.innerHTML = "Please select a profile picture to upload!";
          fileError.style.color = "red";
      }
      function validateProfilePic() {
          if (fileInput.files.length === 0) {
              fileError.innerHTML = "Please select a profile picture to upload!";
              fileError.style.color = "red";
              return false;
          }
          let fileName = fileInput.value;
          let fileExtension = fileName.split('.');
          fileExtension = fileExtension[fileExtension.length - 1].toLowerCase();
          if (fileExtension !== 'jpg' && fileExtension !== 'jpeg' && fileExtension !== 'png') {
              fileError.innerHTML = "Please select a JPG, JPEG, or PNG image!";
              fileError.style.color = "red";
              return false;
          }
          return true;
      }
    </script>
  </body>
</html>

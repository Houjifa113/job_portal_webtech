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
    <title>Resume Uploader</title>
  </head>
  <link rel="stylesheet" href="../asset/style.css" />
  <script src="../asset/script.js"></script>
  <body>
    <a href="./home.php"><input type="button" value="Home" id="home" class="tips-button" style="position: absolute;left: 2%;top: 2%;width: 8%;"></a>
    <form
      action="#"
      method="post"
      enctype="multipart/form-data"
      onsubmit="return resumeUpload()"
    >
      <table class="standardTable">
        <tr>
          <td style="padding: 3%">
            <input
              type="file"
              name="resumeFile"
              value="resumeFile"
              id="resumeFile"
            />
          </td>
          <td>
            <p id="resumeFileError"></p>
          </td>
        </tr>
        <tr>
          <td colspan="2" style="padding: 3%">
            <input type="submit" value="Submit" class="resume-button" />
          </td>
        </tr>
      </table>
    </form>
  </body>
</html>

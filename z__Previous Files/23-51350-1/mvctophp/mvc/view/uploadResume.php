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
    $msg="";
    if(isset($_GET['msg'])){
        if($_GET['msg'] == 'success'){
            $msg = "File uploaded successfully!";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Resume Uploader</title>
  </head>
  <link rel="stylesheet" href="../asset/style.css" />
  
  <body>
    <a href="./home.php"><input type="button" value="Home" id="home" class="tips-button" style="position: absolute;left: 2%;top: 2%;width: 8%;"></a>
    <form
      action="../controller/uploadResumeCheck.php"
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
  <script >

    let msg="<?php echo $msg; ?>";
    
    let fileInput = document.getElementById('resumeFile');
    let fileError= document.getElementById('resumeFileError');
    if(msg==='File uploaded successfully!'){
        fileError.innerHTML = msg;
        fileError.style.color = "green";
    }
    function resumeUpload(){

    if (fileInput.files.length === 0) {
        fileError.innerHTML = "Please select a file to upload!";
        fileError.style.color = "red";
        return false;
    }
    let fileName = document.getElementById('resumeFile').value;
    let fileExtension = fileName.split('.');
    fileExtension = fileExtension[fileExtension.length - 1].toLowerCase();
    if (fileExtension !== 'pdf' && fileExtension !== 'docx') {
        fileError.innerHTML = "Please select PDF or DOC!";
        fileError.style.color = "red";
        return false;
    }
    return true;
}

  </script>
</html>

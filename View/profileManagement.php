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
      vertical-align: top;
    }
    .standardTable label {
      font-weight: normal;
      color: #fff;
    }
    .standardTable input[type="text"],
    .standardTable input[type="email"],
    .standardTable textarea {
      width: 95%;
      padding: 6px 8px;
      border: 1px solid #888;
      border-radius: 4px;
      font-size: 15px;
      background: #222;
      color: #fff;
      box-sizing: border-box;
      margin-bottom: 8px;
    }
    .standardTable textarea {
      min-height: 40px;
      resize: vertical;
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
    #profileError {
      color: #FF7070;
      font-size: 15px;
      padding-left: 5px;
    }
    #viewProfilePictureImage,
    #profilePictureImage {
      position: absolute;
      left: 45%;
      top: 2%;
      width: 90px;
      height: 90px;
      border-radius: 75px;
    }
    #viewProfilePictureImage {
      position: relative;
    }
    #viewProfilePictureImage:hover {
      filter: blur(2px);
    }
    #profile-picture-overlay {
      position: absolute;
      left: 45%;
      top: 2%;
      width: 90px;
      height: 90px;
      border-radius: 75px;
      text-align: center;
      color: azure;
      opacity: 0;
    }
    #profile-picture-overlay:hover {
      opacity: 1;
    }

    #skillsContainer input.skill-input {
      display: block;
      margin-bottom: 10px;
      margin-top: 2px;
    }
    #skillsContainer br {
      display: none;
    }
    #experienceContainer {
      display: flex;
      flex-direction: column;
      gap: 16px;
    }
    .experience-block {
      background: #222;
      border: 1px solid #444;
      border-radius: 8px;
      padding: 12px;
      margin-bottom: 0;
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      align-items: flex-start;
    }
    .experience-block input[type="text"],
    .experience-block input[type="date"],
    .experience-block textarea {
      width: 180px;
      min-width: 120px;
      margin-bottom: 6px;
      margin-right: 8px;
    }
    .experience-block textarea {
      width: 220px;
      min-width: 120px;
      min-height: 30px;
    }
    #educationContainer {
      display: flex;
      flex-direction: column;
      gap: 16px;
    }
    .education-block {
      background: #222;
      border: 1px solid #444;
      border-radius: 8px;
      padding: 12px;
      margin-bottom: 0;
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      align-items: flex-start;
    }
    .education-block input[type="text"],
    .education-block input[type="date"],
    .education-block textarea {
      width: 180px;
      min-width: 120px;
      margin-bottom: 6px;
      margin-right: 8px;
    }
    .education-block textarea {
      width: 220px;
      min-width: 120px;
      min-height: 30px;
    }
    @media (max-width: 700px) {
      .standardTable {
        width: 98%;
        margin: 2%;
      }
      .experience-block {
        flex-direction: column;
        gap: 4px;
      }
      .experience-block input,
      .experience-block textarea {
        width: 98%;
        margin-right: 0;
      }
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
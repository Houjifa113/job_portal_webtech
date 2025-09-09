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
    <title>Profile Strength Check</title>
    <style>
    body {
        background-color: #252525;
        font-family: Arial, sans-serif;
        color: white;
    }
    .strength-box {
        max-width: 400px;
        margin: 40px auto;
        padding: 24px 20px;
        background: #333333;
        border-radius: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        text-align: center;
        color: white;
        border: 1px solid #FF0000;
    }
    .missing-list {
        color: #FF0000;
        margin-top: 16px;
        text-align: left;
    }
    .missing-list ul {
        margin: 8px 0 0 18px;
        padding: 0;
    }
    .complete-msg {
        color: #388e3c;
        margin-top: 16px;
    }
    .tips-button,
    .resume-button,
    .profile-button,
    .search-button,
    #backButton {
        background-color: #FF0000;
        color: white;
        border: none;
        padding: 10px;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        width: 70%;
    }
    #error-box {
        border: 1px solid #FF0000;
        margin: 10%;
        border-radius: 20px;
        padding: 3%;
    }
    #error-code {
        text-align: center;
        font-size: 24px;
        color: red;
    }
    #error-message {
        text-align: center;
        font-size: 20px;
        color: white;
    }
    #error-description {
        text-align: center;
        font-size: 16px;
        color: #ccc;
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
    </style>
</head>
<body>
    <a href="./home.php"><input type="button" value="Home" id="home" class="resume-button" style="position: absolute;left: 2%;top: 2%;width: 8%;"></a>
    <div class="strength-box" id="strengthBox"></div>
    <script>
    let fields = [
        "Full Name", "Email", "Phone", "LinkedIn", "Bio",
        "Education", "Skills", "Experience", "Resume"
    ];

    const completed = [];
    const missing = [];
    fields.forEach(label => {
        if (Math.random() > 0.5) completed.push(label);
        else missing.push(label);
    });

    let percent = Math.round((completed.length / fields.length) * 100);
    const box = document.getElementById('strengthBox');
    box.innerHTML = `<h2>Profile strength: ${percent}%</h2>`;
    if (missing.length) {
        box.innerHTML += "<div class='missing-list'><b>Missing:</b><ul>";
        missing.forEach(m => {
            box.innerHTML += `<li>${m}</li>`;
        });
        box.innerHTML += "</ul></div>";
    } else {
        box.innerHTML += "<div class='complete-msg'>All sections complete!</div>";
    }
</script>

</body>
</html>

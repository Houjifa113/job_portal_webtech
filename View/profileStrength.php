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
    $id=$_SESSION['id'];
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
    window.onload = function() {
        let id = <?php echo $id; ?>;
        let xhttp = new XMLHttpRequest();
        xhttp.open('POST', '../controller/getStrength.php', true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("id=" + id);

        xhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                try {
                    let response = JSON.parse(this.responseText);
                    let strengthBox = document.getElementById('strengthBox');

                    let strength = response.percentage ?? 0;
                    let missing = response.missing ?? [];

                    let html = `<h2>Profile Strength: ${strength}%</h2>`;

                    if (strength < 100) {
                        html += `<div class="missing-list"><p>Missing Sections:</p><ul>`;
                        missing.forEach(item => {
                            html += `<li>${item}</li>`;
                        });
                        html += `</ul></div>`;
                        html += `<button class="profile-button" onclick="window.location.href='profileManagement.php'">Complete Profile</button>`;
                    } else {
                        html += `<div class="complete-msg"><p>Your profile is complete!</p></div>`;
                    }

                    strengthBox.innerHTML = html;
                } catch (e) {
                    console.error("Invalid JSON response", this.responseText);
                }
            }
        };
    }
</script>


</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Create CV</title>
    <style>
    body {
        background-color: #252525;
        font-family: Arial, sans-serif;
        color: white;
    }
    .container {
        display: flex;
        justify-content: center;
        gap: 2%;
        margin-top: 5%;
    }
    .textarea-box {
        width: 95%;
        height: 400px;
        resize: vertical;
        padding: 6px 8px;
        border: 1px solid #888;
        border-radius: 4px;
        font-size: 15px;
        background: #222;
        color: #fff;
        box-sizing: border-box;
    }
    .standardTable,
    .standardTable2 {
        width: 80%;
        border: 1px solid #FF0000;
        border-radius: 20px;
        padding: 3%;
        background-color: #333333;
        margin: 10%;
    }
    .standardTable {
        text-align: center;
        margin: 0 auto;
    }
    .standardTable2 {
        border-collapse: collapse;
    }
    .standardTable2 td.tableButton {
        border: 1px solid #FF0000;
        cursor: pointer;
    }
    .standardTable td {
        padding: 8px 10px;
        border: none;
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
    }
    .standardTable textarea {
        min-height: 40px;
        resize: vertical;
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
    <div class="container">
        <textarea class="textarea-box" placeholder="Resume Template"></textarea>
        <textarea class="textarea-box" placeholder="Markdown or LaTeX Output"></textarea>
    </div>
    <br>
    <br>
    <table class="standardTable">
        <tr>
            <td></td>
            <td style="padding-left: 20px;">
                <input type="button" value="Download CV" id="downloadCV" class="resume-button">
            </td>
        </tr>
    </table>
</body>
</html>
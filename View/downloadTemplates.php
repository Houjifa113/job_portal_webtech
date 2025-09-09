<?php
    session_start();
    if(isset($_SESSION['status']) && $_SESSION['status'] === 'valid'){
        $id='home';
        $href='./home.php';
        $value='Home';
    }else{
        $id='login';
        $href='./login.php';
        $value='Login';
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Download Templates and Checklists</title>
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

    .tips-button {
        background-color: #FF0000;
        color: white;
        border: none;
        padding: 10px;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        width: 70%;
    }
</style>
<body>
    <a href="<?php echo $href; ?>"><input type="button" value="<?php echo $value; ?>" id="<?php echo $id; ?>" class="tips-button" style="position: absolute;left: 2%;top: 2%;width: 8%;"></a>
    <h1 style="text-align: center; position: relative; top: 60px;">Download Templates and Checklists</h1>
    <table class="standardTable">
    <tr>
    <td style="padding: 3%;"><input type="button" value="CV Template #1" id="template1" class="tips-button"></td>
    </tr>
    <tr >
    <td style="padding: 3%;"><input type="button" value="CV Template #2" id="template2" class="tips-button"></td>
    </tr>
    <tr >
    <td style="padding: 3%;"><input type="button" value="Career Checklist #1" id="checklist1" class="tips-button"></td>
    </tr>
    <tr >
    <td style="padding: 3%;"><input type="button" value="Career Checklist #2" id="checklist2" class="tips-button"></td>
    </tr>
    </table>
</body>

<script>

    function downloadFile(filePath) {
        window.location.href = filePath;
    }
    document.getElementById("template1").onclick = function() {
        downloadFile("../asset/files/template1.docx");
    };
    document.getElementById("template2").onclick = function() {
        downloadFile("../asset/files/template2.docx");
    };
    document.getElementById("checklist1").onclick = function() {
        downloadFile("../asset/files/checklist1.pdf");
    };
    document.getElementById("checklist2").onclick = function() {
        downloadFile("../asset/files/checklist2.pdf");
    };
</script>
</html>
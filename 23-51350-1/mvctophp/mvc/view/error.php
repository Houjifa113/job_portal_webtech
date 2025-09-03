<?php
    if(!isset($_GET['error_code'])){
        header('location: ./home.php');
        exit();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Error Page</title>
    <link rel="stylesheet" href="../asset/style.css">
</head>
<body>
    <div id="error-box" >
        <p id="error-code"></p>
        <p id="error-message"></p>
        <p id="error-description"></p>
        <a href="./home.php"><input type="button" id="home" class="profile-button" style="width: 20%; position: relative; left: 40%;" value="Home"></a>
    </div>
    <script>
        let errorCode = "<?php echo $_GET['error_code']; ?>";


        let errorMessage = "";
        let errorDescription = "";
    if (errorCode === "404") {
        errorMessage = "Not Found";
        errorDescription = "The requested resource could not be found on the server.";
    } else if (errorCode === "400") {
        errorMessage = "Bad Request";
        errorDescription = "The server could not understand the request due to invalid syntax.";
    } else if (errorCode === "301") {
        errorMessage = "Moved Permanently";
        errorDescription = "The requested resource has been permanently moved to a new URL.";
    } else if (errorCode === "501") {
        errorMessage = "Not Implemented";
        errorDescription = "The server does not support the functionality required to fulfill the request.";
    }
    if (document.getElementById("error-code")) {
        document.getElementById("error-code").innerHTML = errorCode;
        document.getElementById("error-message").innerHTML = errorMessage;
        document.getElementById("error-description").innerHTML = errorDescription;
    }
    </script>
</body>
</html>
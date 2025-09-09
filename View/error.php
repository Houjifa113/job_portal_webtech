<?php
    $code= $_SERVER['REDIRECT_STATUS'];
    if($code=="" || $code==null){
        header("Location: ./home.php");
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Error Page</title>
</head>
<style>
    body {
        background-color: #252525;
        font-family: Arial, sans-serif;
        color: white;
    }

    #error-box {
        border: 1px solid #FF0000;
        margin: 10%;
        border-radius: 20px;
        padding: 3%;
        background-color: #333333;
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
</style>
<body>
    <div id="error-box" >
        <p id="error-code"></p>
        <p id="error-message"></p>
        <p id="error-description"></p>
        <a href="./home.php"><input type="button" id="home" class="profile-button" style="width: 20%; position: relative; left: 40%;" value="Home"></a>
    </div>
    <script>
        let errorCode = "<?php echo $code; ?>";


        let errorMessage = "";
        switch (errorCode) {
            case "400":
                errorMessage = "Bad Request";
                errorDescription = "The server could not understand the request due to invalid syntax.";
                break;
            case "401":
                errorMessage = "Unauthorized";
                errorDescription = "You are not authorized to access this resource.";
                break;
            case "403":
                errorMessage = "Forbidden";
                errorDescription = "You do not have permission to access this resource.";
                break;
            case "404":
                errorMessage = "Not Found";
                errorDescription = "The requested resource could not be found on the server.";
                break;
            case "405":
                errorMessage = "Method Not Allowed";
                errorDescription = "The request method is not supported for the requested resource.";
                break;
            case "408":
                errorMessage = "Request Timeout";
                errorDescription = "The server timed out waiting for the request.";
                break;
            case "410":
                errorMessage = "Gone";
                errorDescription = "The requested resource is no longer available and has been permanently removed.";
                break;
            case "429":
                errorMessage = "Too Many Requests";
                errorDescription = "You have sent too many requests in a given amount of time.";
                break;
            case "500":
                errorMessage = "Internal Server Error";
                errorDescription = "The server encountered an internal error and was unable to complete your request.";
                break;
            case "501":
                errorMessage = "Not Implemented";
                errorDescription = "The server does not support the functionality required to fulfill the request.";
                break;
            case "502":
                errorMessage = "Bad Gateway";
                errorDescription = "The server received an invalid response from the upstream server.";
                break;
            case "503":
                errorMessage = "Service Unavailable";
                errorDescription = "The server is currently unable to handle the request due to temporary overload or maintenance.";
                break;
            case "504":
                errorMessage = "Gateway Timeout";
                errorDescription = "The server did not receive a timely response from the upstream server.";
                break;
            case "505":
                errorMessage = "HTTP Version Not Supported";
                errorDescription = "The server does not support the HTTP protocol version used in the request.";
                break;
            default:
                errorMessage = "Unknown Error";
                errorDescription = "An unexpected error has occurred.";
        }
        if (document.getElementById("error-code")) {
            document.getElementById("error-code").innerHTML = errorCode;
            document.getElementById("error-message").innerHTML = errorMessage;
            document.getElementById("error-description").innerHTML = errorDescription;
        }
    </script>
</body>
</html>
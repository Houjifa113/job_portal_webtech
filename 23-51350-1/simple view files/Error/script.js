let errorCode = "404";


let errorMessage = "";
let errorDescription = "";

if (errorCode === "404") {
    errorMessage = "Not Found";
    errorDescription = "The requested resource could not be found on the server.";
}
else if (errorCode === "400") {
    errorMessage = "Bad Request";
    errorDescription = "The server could not understand the request due to invalid syntax.";
} else if (errorCode === "301") {
    errorMessage = "Moved Permanently";
    errorDescription = "The requested resource has been permanently moved to a new URL.";
} else if (errorCode === "501") {
    errorMessage = "Not Implemented";
    errorDescription = "The server does not support the functionality required to fulfill the request.";
}


document.getElementById("error-code").innerHTML = errorCode;
document.getElementById("error-message").innerHTML = errorMessage;
document.getElementById("error-description").innerHTML = errorDescription;
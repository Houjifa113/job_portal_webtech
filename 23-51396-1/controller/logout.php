<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Logout</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }
        .message {
            background-color: white;
            padding: 30px 50px;
            border-radius: 8px;
            box-shadow: 0 0 10px #ccc;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="message">
    <h2>You have been logged out</h2>
    <p>Redirecting to login page...</p>
</div>

<script>
    setTimeout(function() {
        window.location.href = "login.html";
    }, 2000); // 2 secnd 
</script>

</body>
</html>

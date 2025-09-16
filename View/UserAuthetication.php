<?php
session_start();
if(isset($_SESSION['status']) && $_SESSION['status'] == true) {
    header('location: dashboard.php');
    exit();
}

?>





<!DOCTYPE html>
<html>
  <head>
    <title>User Authentication</title>
    <link rel="stylesheet" href="../Asset/Khorshida.css">
  </head>
  <body> 
    <h1>User Authentication</h1>

   
   
    <button class="btn" id="showSignup" onclick="showsignup()">Sign Up</button>

    <!--Login Form-->
    <div class="container" id="login">
      <form action="../Controllers/loginCheck.php" method="post" onsubmit="return login()">
      <input type="email" id="loginEmail" placeholder="Email" name="email"><br>
      <p id="emailerror" class="error"></p>

      <input type="password" id="loginPassword" placeholder="Password" name="password"><br>
      <p id="passerror" class="error"></p>
       <button class="btn btn-success" type="submit">Login</button>
    </form>
     
  </div>
 
  <!-- Signup Form -->
  <div class="container" id="signupForm" >
    <h2>Sign Up</h2>
    <form id="signup" action="../Controllers/SignUpCheck.php" method="post" onsubmit="return signup()">
      <input type="text" id="signupName" placeholder="Full Name" name="signupname" ><br>
      <p id="sname" class="error"></p>
      <input type="email" id="signupEmail" placeholder="Email" name="signupemail" ><br>
      <p id="semail" class="error"></p>
      <input type="password" id="signupPassword" placeholder="Password" name="signuppassword"><br>
       <p id="spass" class="error"></p>
 <input type="password" id="confirmpassword" placeholder="confirmpassword" name="confirmpassword"><br>
       <p id="cpass" class="error"></p>


      <button type="submit">Sign Up</button>
    </form>
   
  </div>
    
<script src="../Asset/userauth.js"></script>
  </body>
  
</html>
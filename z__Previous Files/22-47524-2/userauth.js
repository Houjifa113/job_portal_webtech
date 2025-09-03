

document.getElementById("login").style.display='block';
document.getElementById("signupForm").style.display='none';

//for showing up the login screen

function showlogin(){
document.getElementById("login").style.display='block';
document.getElementById("signupForm").style.display='none';




}

//for showing up the signup screen

function showsignup(){
  document.getElementById("login").style.display='none';
document.getElementById("signupForm").style.display='block';




}

//for login validation

function login(){
  let email=document.getElementById("loginEmail").value.trim();
  let password=document.getElementById("loginPassword").value.trim();
  let emailerr=document.getElementById("emailerror" );
  let passerr=document.getElementById("passerror" );

  //email validation

  if(email===""){

    emailerr.innerHTML="Email is Required!";
    emailerr.style.color="red";

    return false;

  }
  else if(!email.includes('@') || !email.includes('.')){
    emailerr.innerHTML="Please enter a valid email"
    emailerr.style.color="red";
     return false;
  }
  
  else{
    emailerr.innerHTML="";
    
  }
 
  // Password validation
  if(password === ""){
    passerr.innerHTML = "Password is Required!";
    passerr.style.color = "red";
    return false;
  }
  else if(password.length < 8){
    passerr.innerHTML = "Password must be at least 8 characters";
    passerr.style.color = "red";
    return false;
  }
  else{
    passerr.innerHTML = "";
  }

  

  
  

}

function signup(){
   let username = document.getElementById("signupName").value.trim();
   let email = document.getElementById("signupEmail").value.trim();
   let password = document.getElementById("signupPassword").value.trim();
   let confirmpassword = document.getElementById("confirmpassword").value.trim();

   let namerr = document.getElementById("sname");
   let emailerr = document.getElementById("semail");
   let passerr = document.getElementById("spass"); 
   let confirmerr = document.getElementById("cpass"); 

  

   // Validate username
   if(username === ""){
      namerr.innerHTML = "Username is required!";
      namerr.style.color = "red";
      return false;
   } 
   
   else {
      namerr.innerHTML = "";
   }

   // Validate email 
   if(email === ""){
      emailerr.innerHTML = "Email is required!";
      emailerr.style.color = "red";
     return false;

   }
   
   else if(!email.includes('@') || !email.includes('.')) {
      emailerr.innerHTML = "Please enter a valid email!";
      emailerr.style.color = "red";
    return false;

   } 
   
   else {
      emailerr.innerHTML = "";
   }

   // Validate password 
   if(password === ""){
      passerr.innerHTML = "Password is required!";
      passerr.style.color = "red";
     return false;

   } 
   
   else if(password.length < 8) {
      passerr.innerHTML = "Password must be at least 8 characters!";
      passerr.style.color = "red";
      return false;
   } 

   
   else {
      passerr.innerHTML = "";
   }

   //validate confirm password

   if(confirmpassword===""){
    confirmerr.innerHTML="This field is required!";
    confirmerr.style.color="red";

    return false;

   }

   else if(password!==confirmpassword){
    confirmerr.innerHTML="Please re-enter the password again!";
    confirmerr.style.color="red";
    return false;

   }

   else{
    confirmerr.innerHTML="";
   }
   alert("Signup Successful! Please login with your new account.");
    showlogin(); 

   return false;
}


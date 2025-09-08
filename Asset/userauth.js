document.getElementById("login").style.display='block';
document.getElementById("signupForm").style.display='none';

//for showing up the login screen

function showlogin() {
    document.getElementById('login').style.display = 'block';
    document.getElementById('signupForm').style.display = 'none';
    document.getElementById('showLogin').classList.add('active');
    document.getElementById('showSignup').classList.remove('active');
}

//for showing up the signup screen

function showsignup() {
    document.getElementById('login').style.display = 'none';
    document.getElementById('signupForm').style.display = 'block';
    document.getElementById('showLogin').classList.remove('active');
    document.getElementById('showSignup').classList.add('active');
}

//for login validation

function login() {
    let isValid = true;
    const email = document.getElementById('loginEmail');
    const password = document.getElementById('loginPassword');
    
    // Email validation
    if (!email.value.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
        document.getElementById('emailerror').innerHTML = "Please enter a valid email";
        isValid = false;
    } else {
        document.getElementById('emailerror').innerHTML = "";
    }

    // Password validation
    if (password.value.length < 6) {
        document.getElementById('passerror').innerHTML = "Password must be at least 6 characters";
        isValid = false;
    } else {
        document.getElementById('passerror').innerHTML = "";
    }

    return isValid;
}

function signup() {
    let isValid = true;
    const name = document.getElementById('signupName');
    const email = document.getElementById('signupEmail');
    const password = document.getElementById('signupPassword');
    const confirmPassword = document.getElementById('confirmpassword');
    const role = document.getElementById('role');

    // Name validation
    if (name.value.length < 3) {
        document.getElementById('sname').innerHTML = "Name must be at least 3 characters";
        isValid = false;
    } else {
        document.getElementById('sname').innerHTML = "";
    }

    // Email validation
    if (!email.value.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
        document.getElementById('semail').innerHTML = "Please enter a valid email";
        isValid = false;
    } else {
        document.getElementById('semail').innerHTML = "";
    }

    // Role validation
    if (role.value === "") {
        document.getElementById('roleError').innerHTML = "Please select a role";
        isValid = false;
    } else {
        document.getElementById('roleError').innerHTML = "";
    }

    // Password validation
    if (password.value.length < 6) {
        document.getElementById('spass').innerHTML = "Password must be at least 6 characters";
        isValid = false;
    } else {
        document.getElementById('spass').innerHTML = "";
    }

    // Confirm password validation
    if (password.value !== confirmPassword.value) {
        document.getElementById('cpass').innerHTML = "Passwords do not match";
        isValid = false;
    } else {
        document.getElementById('cpass').innerHTML = "";
    }

    return isValid;
}

// Show login form by default when page loads
window.onload = function() {
    showlogin();
};
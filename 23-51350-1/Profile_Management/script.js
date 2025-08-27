function validateProfilePic() {
  return false;
}
let fullName = "John Doe";
let email = "john.doe@example.com";
let phone = "123-456-7890";
let linkedIn = "https://www.linkedin.com/in/johndoe";
let bio = "Software Developer with 5 years of experience.";
let education = "B.Sc. in Computer Science";
let skills = "JavaScript, HTML, CSS";
let experience = "Worked at XYZ Corp for 3 years.";
window.onload = function () {
    if(document.getElementById("fullName")){
    document.getElementById("fullName").value = fullName;
    document.getElementById("email").value = email;
    document.getElementById("phone").value = phone;
    document.getElementById("linkedIn").value = linkedIn;
    document.getElementById("bio").value = bio;
    document.getElementById("education").value = education;
    document.getElementById("skills").value = skills;
    document.getElementById("experience").value = experience;
    }

    if(document.getElementById("fullNameDisplay")){
    document.getElementById("fullNameDisplay").textContent = fullName;
    document.getElementById("emailDisplay").textContent = email;
    document.getElementById("phoneDisplay").textContent = phone;
    document.getElementById("linkedInDisplay").textContent = linkedIn;
    document.getElementById("bioDisplay").textContent = bio;
    document.getElementById("educationDisplay").textContent = education;
    document.getElementById("skillsDisplay").textContent = skills;
    document.getElementById("experienceDisplay").textContent = experience;
    }
}

function validateEditProfile() {
    let isValid = true;
    let profileError = document.getElementById("profileError");
    profileError.textContent = "";
    profileError.style.fontWeight = "normal";
    profileError.style.color = "red";

    let fullNameValue = document.getElementById("fullName").value.trim();
    let emailValue = document.getElementById("email").value.trim();
    let linkedInValue = document.getElementById("linkedIn").value.trim();
    let educationValue = document.getElementById("education").value.trim();

    if (fullNameValue === "") {
        profileError.textContent = "Full Name is required.";
        profileError.style.color = "red";
        isValid = false;
    } else if (fullNameValue.split(" ").length < 2) {
        profileError.textContent = "Full Name must include at least first and last name.";
        profileError.style.color = "red";
        isValid = false;
    } else if (emailValue === "") {
        profileError.textContent = "Email is required.";
        profileError.style.color = "red";
        isValid = false;
    } else if (!emailValue.includes("@") || !emailValue.includes(".")) {
        profileError.textContent = "Email must include '@' and '.'.";
        profileError.style.color = "red";
        isValid = false;
    } else if (linkedInValue === "") {
        profileError.textContent = "LinkedIn is required.";
        profileError.style.color = "red";
        isValid = false;
    } else if (!linkedInValue.startsWith("https://www.linkedin.com/")) {
        profileError.textContent = "LinkedIn must be a valid LinkedIn URL.";
        profileError.style.color = "red";
        isValid = false;
    } else if (educationValue === "") {
        profileError.textContent = "Education is required.";
        profileError.style.color = "red";
        isValid = false;
    }

    return isValid;
}

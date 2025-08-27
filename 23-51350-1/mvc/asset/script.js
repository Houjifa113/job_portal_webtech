let table = document.getElementById("infoVideosTable");

function addVideoRow(videoUrl, title) {
    let rowVideo = document.createElement("tr");
    let cellVideo = document.createElement("td");
    let iframe = document.createElement("iframe");
    iframe.width = "560"; 
    iframe.height = "315"; 
    iframe.src = videoUrl.replace("watch?v=", "embed/");
    iframe.allowFullscreen = true;
    cellVideo.appendChild(iframe);
    rowVideo.appendChild(cellVideo);
    table.appendChild(rowVideo);

    let rowTitle = document.createElement("tr");
    let cellTitle = document.createElement("td");
    let p = document.createElement("p");
    p.innerHTML = "<b>" + title + "</b>";
    cellTitle.appendChild(p);
    rowTitle.appendChild(cellTitle);
    table.appendChild(rowTitle);
}
if(table){
addVideoRow("https://www.youtube.com/watch?v=Tt08KmFfIYQ", "Write an Incredible Resume: 5 Golden Rules!");
addVideoRow("https://www.youtube.com/watch?v=rvKNhhhzkP8", "How to Drastically Improve Your RESUME with 3 SMALL Changes");
addVideoRow("https://www.youtube.com/watch?v=8_ImWB1qMf8", "5 Things You Don't Need on Your Resume Anymore");
}

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

if(document.getElementById("error-code")){
document.getElementById("error-code").innerHTML = errorCode;
document.getElementById("error-message").innerHTML = errorMessage;
document.getElementById("error-description").innerHTML = errorDescription;
}

function validateProfilePic() {
    let fileInput = document.getElementById('profilePic');
    let fileError = document.getElementById('profilePicError');
    if (fileInput.files.length === 0) {
        fileError.innerHTML = "Please select a profile picture to upload!";
        fileError.style.color = "red";
        return false;
    }
    let fileName = fileInput.value;
    let fileExtension = fileName.split('.');
    fileExtension = fileExtension[fileExtension.length - 1].toLowerCase();
    if (fileExtension !== 'jpg' && fileExtension !== 'jpeg' && fileExtension !== 'png') {
        fileError.innerHTML = "Please select a JPG, JPEG, or PNG image!";
        fileError.style.color = "red";
        return false;
    }
    return true;
}

function validateProfilePic() {
  return false;
}

function resumeUpload()
{
    let fileInput = document.getElementById('resumeFile');
    let fileError= document.getElementById('resumeFileError');
    if (fileInput.files.length === 0) {
        fileError.innerHTML = "Please select a file to upload!";
        fileError.style.color = "red";
        return false;
    }
    let fileName = document.getElementById('resumeFile').value;
    let fileExtension = fileName.split('.');
    fileExtension = fileExtension[fileExtension.length - 1].toLowerCase();
    if (fileExtension !== 'pdf' && fileExtension !== 'docx') {
        fileError.innerHTML = "Please select PDF or DOC!";
        fileError.style.color = "red";
        return false;
    }
    return true;
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

function toggleRefresh() {
  return true;
}
let searchHistory = [
  { JobTitle: "Software Engineer", Status: "Remote", Location: "Dhaka" },
  { JobTitle: "Data Scientist", Status: "Hybrid", Location: "Chattogram" },
  { JobTitle: "Product Manager", Status: "On-site", Location: "Khulna" },
];

let table1 = document.getElementById("searchHistoryTable");
if (table1) {
  for (let i = 0; i < searchHistory.length; i++) {
    let row = document.createElement("tr");

    let jobTitleTd = document.createElement("td");
    jobTitleTd.colSpan = 2;
    jobTitleTd.textContent = searchHistory[i]["JobTitle"];
    row.appendChild(jobTitleTd);

    let statusTd = document.createElement("td");
    statusTd.textContent = searchHistory[i]["Status"];
    row.appendChild(statusTd);

    let locationTd = document.createElement("td");
    locationTd.textContent = searchHistory[i]["Location"];
    row.appendChild(locationTd);

    let goToTd = document.createElement("td");
    let btn = document.createElement("button");
    btn.textContent = "Click here";
    btn.className = "search-button";

    let url = "/searchBar.html?";
    url += "JobTitle=" + searchHistory[i]["JobTitle"];
    url += "&Status=" + searchHistory[i]["Status"];
    url += "&Location=" + searchHistory[i]["Location"];

    let link = document.createElement("a");
    link.href = url;
    link.appendChild(btn);

    goToTd.appendChild(link);
    row.appendChild(goToTd);

    table1.appendChild(row);
  }
}
let table2 = document.getElementById("queryManagerTable");

if (table2) {
  for (let i = 0; i < searchHistory.length; i++) {
    let row = document.createElement("tr");

    let jobTitleTd = document.createElement("td");
    jobTitleTd.style.padding = "1%";
    jobTitleTd.style.color = "azure";
    jobTitleTd.style.textAlign = "center";
    jobTitleTd.colSpan = 2;
    jobTitleTd.textContent = searchHistory[i]["JobTitle"];
    row.appendChild(jobTitleTd);

    let statusTd = document.createElement("td");
    statusTd.textContent = searchHistory[i]["Status"];
    row.appendChild(statusTd);

    let locationTd = document.createElement("td");
    locationTd.textContent = searchHistory[i]["Location"];
    row.appendChild(locationTd);

    let goToTd = document.createElement("td");
    let btn = document.createElement("button");
    btn.textContent = "Click here";
    btn.className = "search-button";

    let url = "/searchBar.html?";
    url += "JobTitle=" + searchHistory[i]["JobTitle"];
    url += "&Status=" + searchHistory[i]["Status"];
    url += "&Location=" + searchHistory[i]["Location"];

    let link = document.createElement("a");
    link.href = url;
    link.appendChild(btn);

    goToTd.appendChild(link);
    row.appendChild(goToTd);

    let deleteTd = document.createElement("td");
    let deleteBtn = document.createElement("button");
    deleteBtn.textContent = "Delete";
    deleteBtn.className = "search-button";
    deleteBtn.onclick = function () {
      table2.removeChild(row);
      searchHistory.splice(i, 1);
    };
    deleteTd.appendChild(deleteBtn);
    row.appendChild(deleteTd);

    table2.appendChild(row);
  }
}

<?php
  session_start();
  if(isset($_SESSION['status'])){
        if($_SESSION['status'] != 'valid'){
            header('location: login.php?error=badrequest');
        }
    }else{
        header('location: login.php?error=badrequest');
    }

    if(isset($_COOKIE['status'])){
        if($_COOKIE['status'] != 'valid'){
            header('location: login.php?error=badrequest');
        }
    }else{
        header('location: login.php?error=badrequest');
    }
    if(isset($_REQUEST['error'])){
        $error = $_REQUEST['error'] ;
    }
    else {
        $error = "";
    }

    $profileDemo = [
      "Alice" => [
        "fullName" => "Alice Smith",
        "email" => "alice.smith@example.com",
        "phone" => "555-123-4567",
        "linkedIn" => "https://www.linkedin.com/in/alicesmith",
        "bio" => "Frontend developer passionate about UI/UX.",
        "education" => [
          ["institute"=>"State University", "program"=>"B.Sc. in Computer Science", "start"=>"2017-09-01", "end"=>"2021-06-01"],
          ["institute"=>"Design Academy", "program"=>"UI/UX Bootcamp", "start"=>"2021-07-01", "end"=>"2021-12-01"]
        ],
        "skills" => ["JavaScript", "HTML", "CSS"],
        "experience" => [
          ["company"=>"WebWorks", "position"=>"Frontend Developer", "start"=>"2022-01-01", "end"=>"2023-01-01", "desc"=>"Built responsive websites."]
        ]
      ],
      "Bob" => [
        "fullName" => "Bob Johnson",
        "email" => "bob.johnson@example.com",
        "phone" => "555-234-5678",
        "linkedIn" => "https://www.linkedin.com/in/bobjohnson",
        "bio" => "Backend developer and API specialist.",
        "education" => [
          ["institute"=>"Tech Institute", "program"=>"M.Sc. in Data Science", "start"=>"2015-09-01", "end"=>"2017-06-01"]
        ],
        "skills" => ["Python", "Django", "Flask"],
        "experience" => [
          ["company"=>"DataCorp", "position"=>"Backend Developer", "start"=>"2021-05-01", "end"=>"2023-05-01", "desc"=>"Developed REST APIs."]
        ]
      ],
      "Charlie" => [
        "fullName" => "Charlie Lee",
        "email" => "charlie.lee@example.com",
        "phone" => "555-345-6789",
        "linkedIn" => "https://www.linkedin.com/in/charlielee",
        "bio" => "Java engineer with enterprise experience.",
        "education" => [
          ["institute"=>"Software College", "program"=>"B.Sc. in Software Engineering", "start"=>"2014-09-01", "end"=>"2018-06-01"]
        ],
        "skills" => ["Java", "Spring", "Hibernate"],
        "experience" => [
          ["company"=>"JavaHouse", "position"=>"Java Engineer", "start"=>"2020-03-01", "end"=>"2022-03-01", "desc"=>"Enterprise app development."]
        ]
      ],
      "Dana" => [
        "fullName" => "Dana White",
        "email" => "dana.white@example.com",
        "phone" => "555-456-7890",
        "linkedIn" => "https://www.linkedin.com/in/danawhite",
        "bio" => ".NET developer and database expert.",
        "education" => [
          ["institute"=>"IT University", "program"=>"B.Sc. in Information Technology", "start"=>"2012-09-01", "end"=>"2016-06-01"]
        ],
        "skills" => ["C#", "ASP.NET", "SQL Server"],
        "experience" => [
          ["company"=>"SoftSolutions", "position"=>".NET Developer", "start"=>"2019-07-01", "end"=>"2021-07-01", "desc"=>"Built business software."]
        ]
      ],
      "Eve" => [
        "fullName" => "Eve Black",
        "email" => "eve.black@example.com",
        "phone" => "555-567-8901",
        "linkedIn" => "https://www.linkedin.com/in/eveblack",
        "bio" => "PHP developer and web application creator.",
        "education" => [
          ["institute"=>"Web Dev College", "program"=>"B.Sc. in Web Development", "start"=>"2013-09-01", "end"=>"2017-06-01"]
        ],
        "skills" => ["PHP", "Laravel", "MySQL"],
        "experience" => [
          ["company"=>"PHPPros", "position"=>"PHP Developer", "start"=>"2018-09-01", "end"=>"2020-09-01", "desc"=>"Created web applications."]
        ]
      ]
    ];
    $global_username = $_SESSION['username'];;
    $profile = $profileDemo[$global_username];
    $skills = $profile['skills'];
    $experience = $profile['experience'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Edit Profile</title>
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
      vertical-align: top;
    }
    .standardTable label {
      font-weight: normal;
      color: #fff;
    }
    .standardTable input[type="text"],
    .standardTable input[type="email"],
    .standardTable textarea {
      width: 95%;
      padding: 6px 8px;
      border: 1px solid #888;
      border-radius: 4px;
      font-size: 15px;
      background: #222;
      color: #fff;
      box-sizing: border-box;
      margin-bottom: 8px;
    }
    .standardTable textarea {
      min-height: 40px;
      resize: vertical;
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
    #profileError {
      color: #FF7070;
      font-size: 15px;
      padding-left: 5px;
    }
    #viewProfilePictureImage,
    #profilePictureImage {
      position: absolute;
      left: 45%;
      top: 2%;
      width: 90px;
      height: 90px;
      border-radius: 75px;
    }
    #viewProfilePictureImage {
      position: relative;
    }
    #viewProfilePictureImage:hover {
      filter: blur(2px);
    }
    #profile-picture-overlay {
      position: absolute;
      left: 45%;
      top: 2%;
      width: 90px;
      height: 90px;
      border-radius: 75px;
      text-align: center;
      color: azure;
      opacity: 0;
    }
    #profile-picture-overlay:hover {
      opacity: 1;
    }

    #skillsContainer input.skill-input {
      display: block;
      margin-bottom: 10px;
      margin-top: 2px;
    }
    #skillsContainer br {
      display: none;
    }
    #experienceContainer {
      display: flex;
      flex-direction: column;
      gap: 16px;
    }
    .experience-block {
      background: #222;
      border: 1px solid #444;
      border-radius: 8px;
      padding: 12px;
      margin-bottom: 0;
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      align-items: flex-start;
    }
    .experience-block input[type="text"],
    .experience-block input[type="date"],
    .experience-block textarea {
      width: 180px;
      min-width: 120px;
      margin-bottom: 6px;
      margin-right: 8px;
    }
    .experience-block textarea {
      width: 220px;
      min-width: 120px;
      min-height: 30px;
    }
    #educationContainer {
      display: flex;
      flex-direction: column;
      gap: 16px;
    }
    .education-block {
      background: #222;
      border: 1px solid #444;
      border-radius: 8px;
      padding: 12px;
      margin-bottom: 0;
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      align-items: flex-start;
    }
    .education-block input[type="text"],
    .education-block input[type="date"],
    .education-block textarea {
      width: 180px;
      min-width: 120px;
      margin-bottom: 6px;
      margin-right: 8px;
    }
    .education-block textarea {
      width: 220px;
      min-width: 120px;
      min-height: 30px;
    }
    @media (max-width: 700px) {
      .standardTable {
        width: 98%;
        margin: 2%;
      }
      .experience-block {
        flex-direction: column;
        gap: 4px;
      }
      .experience-block input,
      .experience-block textarea {
        width: 98%;
        margin-right: 0;
      }
    }
  </style>
</head>
<body>
  <a href="./changePicture.php">
    <div class="profile-picture-container">
      <img id="viewProfilePictureImage" src="" />
      <div id="profile-picture-overlay">Change Picture</div>
    </div>
  </a>
  <a href="./home.php">
    <input
      type="button"
      value="Home"
      id="home"
      class="profile-button"
      style="position: absolute; left: 2%; top: 2%; width: 8%"
    />
  </a>
  <form
    enctype="multipart/form-data"
    method="post"
    onsubmit="return validateEditProfile()"
    action="../controller/editProfileCheck.php"
  >
    <table class="standardTable">
      <tr>
        <td style="padding: 3%">
          <label for="fullName">Full Name: </label>
        </td>
        <td>
            <input type="text" name="fullName" id="fullName" value="<?php echo htmlspecialchars($profile['fullName']); ?>" />
        </td>
      </tr>
      <tr>
        <td style="padding: 3%">
          <label for="email">Email: </label>
        </td>
        <td>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($profile['email']); ?>" />
        </td>
      </tr>
      <tr>
        <td style="padding: 3%">
          <label for="phone">Phone Number: </label>
        </td>
        <td>
            <input type="text" name="phone" id="phone" value="<?php echo htmlspecialchars($profile['phone']); ?>" />
        </td>
      </tr>
      <tr>
        <td style="padding: 3%">
          <label for="linkedIn">LinkedIn: </label>
        </td>
        <td>
            <input type="text" name="linkedIn" id="linkedIn" value="<?php echo htmlspecialchars($profile['linkedIn']); ?>" />
        </td>
      </tr>
      <tr>
        <td style="padding: 3%">
          <label for="bio">Bio: </label>
        </td>
        <td>
            <textarea name="bio" id="bio"><?php echo ($profile['bio']); ?></textarea>
        </td>
      </tr>
      <tr>
        <td style="padding: 3%">
          <label>Skills: </label>
        </td>
        <td id="skillsContainer">
          <?php foreach($skills as $skill): ?>
            <input type="text" name="skills[]" class="skill-input" value="<?php echo htmlspecialchars($skill); ?>" />
            <br />
          <?php endforeach; ?>
        </td>
      </tr>
      <tr>
        <td></td>
        <td><button type="button" onclick="addSkill()">Add Skill</button></td>
      </tr>
      <tr>
        <td style="padding: 3%">
          <label>Work Experience: </label>
        </td>
        <td id="experienceContainer">
          <?php foreach($experience as $i => $exp): ?>
            <div class="experience-block" style="display: flex; flex-direction: column; gap: 0;">
              <div style="display: flex; flex-wrap: wrap; gap: 10px; align-items: flex-start;">
                <label style="font-size:13px;color:#ccc;margin-bottom:4px;">Company/Institution</label>
                <input type="text" name="experience[<?php echo $i; ?>][company]" placeholder="Company/Institution" value="<?php echo htmlspecialchars($exp['company']); ?>" />
                <label style="font-size:13px;color:#ccc;margin-bottom:4px;">Position</label>
                <input type="text" name="experience[<?php echo $i; ?>][position]" placeholder="Position" value="<?php echo htmlspecialchars($exp['position']); ?>" />
                <label style="font-size:13px;color:#ccc;margin-bottom:4px;">Description</label>
                <textarea name="experience[<?php echo $i; ?>][desc]" placeholder="Description"><?php echo htmlspecialchars($exp['desc']); ?></textarea>
              </div>
              <div style="display: flex; flex-wrap: wrap; gap: 10px; align-items: flex-start; margin-top: 6px;">
                <label style="font-size:13px;color:#ccc;margin-bottom:4px;">Start Date</label>
                <input type="date" name="experience[<?php echo $i; ?>][start]" placeholder="Start Date" value="<?php echo $exp['start']; ?>" />
                <label style="font-size:13px;color:#ccc;margin-bottom:4px;">End Date</label>
                <input type="date" name="experience[<?php echo $i; ?>][end]" placeholder="End Date" value="<?php echo $exp['end']; ?>" />
              </div>
            </div>
            <br />
          <?php endforeach; ?>
        </td>
      </tr>
      <tr>
        <td></td>
        <td><button type="button" onclick="addExperience()">Add Experience</button></td>
      </tr>
      <tr>
        <td style="padding: 3%">
          <label>Education: </label>
        </td>
        <td id="educationContainer">
          <?php 
            if (isset($profile['education']) && is_array($profile['education'])) {
              foreach($profile['education'] as $i => $edu): ?>
                <div class="education-block" style="display: flex; flex-direction: column; gap: 0;">
                  <div style="display: flex; flex-wrap: wrap; gap: 10px; align-items: flex-start;">
                    <label style="font-size:13px;color:#ccc;margin-bottom:4px;">Institute</label>
                    <input type="text" name="education[<?php echo $i; ?>][institute]" placeholder="Institute" value="<?php echo htmlspecialchars($edu['institute'] ?? ''); ?>" />
                    <label style="font-size:13px;color:#ccc;margin-bottom:4px;">Program</label>
                    <input type="text" name="education[<?php echo $i; ?>][program]" placeholder="Program" value="<?php echo htmlspecialchars($edu['program'] ?? ''); ?>" />
                  </div>
                  <div style="display: flex; flex-wrap: wrap; gap: 10px; align-items: flex-start; margin-top: 6px;">
                    <label style="font-size:13px;color:#ccc;margin-bottom:4px;">Start Date</label>
                    <input type="date" name="education[<?php echo $i; ?>][start]" placeholder="Start Date" value="<?php echo $edu['start'] ?? ''; ?>" />
                    <label style="font-size:13px;color:#ccc;margin-bottom:4px;">End Date</label>
                    <input type="date" name="education[<?php echo $i; ?>][end]" placeholder="End Date" value="<?php echo $edu['end'] ?? ''; ?>" />
                  </div>
                </div>
                <br />
          <?php endforeach; } else { ?>
            <div class="education-block" style="display: flex; flex-direction: column; gap: 0;">
              <div style="display: flex; flex-wrap: wrap; gap: 10px; align-items: flex-start;">
                <label style="font-size:13px;color:#ccc;margin-bottom:4px;">Institute</label>
                <input type="text" name="education[0][institute]" placeholder="Institute" value="" />
                <label style="font-size:13px;color:#ccc;margin-bottom:4px;">Program</label>
                <input type="text" name="education[0][program]" placeholder="Program" value="" />
              </div>
              <div style="display: flex; flex-wrap: wrap; gap: 10px; align-items: flex-start; margin-top: 6px;">
                <label style="font-size:13px;color:#ccc;margin-bottom:4px;">Start Date</label>
                <input type="date" name="education[0][start]" placeholder="Start Date" value="" />
                <label style="font-size:13px;color:#ccc;margin-bottom:4px;">End Date</label>
                <input type="date" name="education[0][end]" placeholder="End Date" value="" />
              </div>
            </div>
          <?php } ?>
        </td>
      </tr>
      <tr>
        <td></td>
        <td><button type="button" onclick="addEducation()">Add Education</button></td>
      </tr>
      <tr>
        <td style="padding: 3%">
          <label>Languages Spoken:</label>
        </td>
        <td id="languagesContainer">
          <input type="text" name="languages[]" class="language-input" />
        </td>
      </tr>
      <tr>
        <td></td>
        <td><button type="button" onclick="addLanguage()">Add Language</button></td>
      </tr>
      <tr>
        <td style="padding: 3%">
          <label>Certifications:</label>
        </td>
        <td id="certificationsContainer">
          <input type="text" name="certifications[]" class="certification-input" />
        </td>
      </tr>
      <tr>
        <td></td>
        <td><button type="button" onclick="addCertification()">Add Certification</button></td>
      </tr>
      <tr>
        <td colspan="2">
          <p id="profileError"></p>
        </td>
      </tr>
      <tr>
        <td></td>
        <td style="padding: 3%">
          <input type="submit" value="Submit" class="profile-button" />
        </td>
      </tr>
    </table>
  </form>
  <script>
    let err='<?php echo $error; ?>';
    if(err){
      document.getElementById("profileError").innerText = err;
    }
    function addSkill() {
      let skillInputs = document.getElementsByClassName('skill-input');
      let skillValues = [];
      for (let i = 0; i < skillInputs.length; i++) {
        let val = skillInputs[i].value.trim();
        if (val === "") {
          alert("Please fill in all skill fields before adding another.");
          return;
        }
        if (skillValues.includes(val.toLowerCase())) {
          alert("Duplicate skill detected: " + val);
          return;
        }
        skillValues.push(val.toLowerCase());
      }
      let container = document.getElementById('skillsContainer');
      let input = document.createElement('input');
      input.type = 'text';
      input.name = 'skills[]';
      input.className = 'skill-input';
      input.value = ""; 
      container.appendChild(input);
    }

    function addExperience() {
      let container = document.getElementById('experienceContainer');
      let blocks = container.getElementsByClassName('experience-block');
      let expKeys = [];
      for (let i = 0; i < blocks.length; i++) {
        let company = blocks[i].querySelector('input[name^="experience['+i+'][company]"]');
        let position = blocks[i].querySelector('input[name^="experience['+i+'][position]"]');
        let start = blocks[i].querySelector('input[name^="experience['+i+'][start]"]');
        let end = blocks[i].querySelector('input[name^="experience['+i+'][end]"]');
        let desc = blocks[i].querySelector('textarea[name^="experience['+i+'][desc]"]');
        if (company && position && start && end && desc) {
          if (
            company.value.trim() === "" ||
            position.value.trim() === "" ||
            start.value === "" ||
            end.value === "" ||
            desc.value.trim() === ""
          ) {
            alert("Please fill in all experience fields before adding another.");
            return;
          }
          let key = company.value.trim().toLowerCase() + "|" + position.value.trim().toLowerCase() + "|" + start.value + "|" + end.value;
          if (expKeys.includes(key)) {
            alert("Duplicate experience detected for " + company.value + " - " + position.value);
            return;
          }
          expKeys.push(key);
        }
      }
      let idx = blocks.length;
      let div = document.createElement('div');
      div.className = 'experience-block';
      div.innerHTML =
        '<div style="display: flex; flex-direction: column; gap: 0;">' +
        '<div style="display: flex; flex-wrap: wrap; gap: 10px; align-items: flex-start;">' +
        '<label style="font-size:13px;color:#ccc;margin-bottom:4px;">Company/Institution</label>' +
        '<input type="text" name="experience['+idx+'][company]" placeholder="Company/Institution" value="" /> ' +
        '<label style="font-size:13px;color:#ccc;margin-bottom:4px;">Position</label>' +
        '<input type="text" name="experience['+idx+'][position]" placeholder="Position" value="" /> ' +
        '<label style="font-size:13px;color:#ccc;margin-bottom:4px;">Description</label>' +
        '<textarea name="experience['+idx+'][desc]" placeholder="Description"></textarea>' +
        '</div>' +
        '<div style="display: flex; flex-wrap: wrap; gap: 10px; align-items: flex-start; margin-top: 6px;">' +
        '<label style="font-size:13px;color:#ccc;margin-bottom:4px;">Start Date</label>' +
        '<input type="date" name="experience['+idx+'][start]" placeholder="Start Date" value="" /> ' +
        '<label style="font-size:13px;color:#ccc;margin-bottom:4px;">End Date</label>' +
        '<input type="date" name="experience['+idx+'][end]" placeholder="End Date" value="" /> ' +
        '</div>' +
        '</div>';
      container.appendChild(div);
    }

    function addEducation() {
      let container = document.getElementById('educationContainer');
      let blocks = container.getElementsByClassName('education-block');
      let eduKeys = [];
      for (let i = 0; i < blocks.length; i++) {
        let institute = blocks[i].querySelector('input[name^="education['+i+'][institute]"]');
        let program = blocks[i].querySelector('input[name^="education['+i+'][program]"]');
        let start = blocks[i].querySelector('input[name^="education['+i+'][start]"]');
        let end = blocks[i].querySelector('input[name^="education['+i+'][end]"]');
        if (institute && program && start && end) {
          if (
            institute.value.trim() === "" ||
            program.value.trim() === "" ||
            start.value === "" ||
            end.value === ""
          ) {
            alert("Please fill in all education fields before adding another.");
            return;
          }
          let key = institute.value.trim().toLowerCase() + "|" + program.value.trim().toLowerCase() + "|" + start.value + "|" + end.value;
          if (eduKeys.includes(key)) {
            alert("Duplicate education detected for " + institute.value + " - " + program.value);
            return;
          }
          eduKeys.push(key);
        }
      }
      let idx = blocks.length;
      let div = document.createElement('div');
      div.className = 'education-block';
      div.innerHTML =
        '<div style="display: flex; flex-direction: column; gap: 0;">' +
        '<div style="display: flex; flex-wrap: wrap; gap: 10px; align-items: flex-start;">' +
        '<label style="font-size:13px;color:#ccc;margin-bottom:4px;">Institute</label>' +
        '<input type="text" name="education['+idx+'][institute]" placeholder="Institute" value="" /> ' +
        '<label style="font-size:13px;color:#ccc;margin-bottom:4px;">Program</label>' +
        '<input type="text" name="education['+idx+'][program]" placeholder="Program" value="" /> ' +
        '</div>' +
        '<div style="display: flex; flex-wrap: wrap; gap: 10px; align-items: flex-start; margin-top: 6px;">' +
        '<label style="font-size:13px;color:#ccc;margin-bottom:4px;">Start Date</label>' +
        '<input type="date" name="education['+idx+'][start]" placeholder="Start Date" value="" /> ' +
        '<label style="font-size:13px;color:#ccc;margin-bottom:4px;">End Date</label>' +
        '<input type="date" name="education['+idx+'][end]" placeholder="End Date" value="" /> ' +
        '</div>' +
        '</div>';
      container.appendChild(div);
    }

    function addLanguage() {
      let container = document.getElementById('languagesContainer');
      let inputs = container.getElementsByClassName('language-input');
      let values = [];
      for (let i = 0; i < inputs.length; i++) {
        let val = inputs[i].value.trim();
        if (val === "") {
          alert("Please fill in all language fields before adding another.");
          return;
        }
        if (values.includes(val.toLowerCase())) {
          alert("Duplicate language detected: " + val);
          return;
        }
        values.push(val.toLowerCase());
      }
      let input = document.createElement('input');
      input.type = 'text';
      input.name = 'languages[]';
      input.className = 'language-input';
      input.value = "";
      container.appendChild(input);
    }

    function addCertification() {
      let container = document.getElementById('certificationsContainer');
      let inputs = container.getElementsByClassName('certification-input');
      let values = [];
      for (let i = 0; i < inputs.length; i++) {
        let val = inputs[i].value.trim();
        if (val === "") {
          alert("Please fill in all certification fields before adding another.");
          return;
        }
        if (values.includes(val.toLowerCase())) {
          alert("Duplicate certification detected: " + val);
          return;
        }
        values.push(val.toLowerCase());
      }
      let input = document.createElement('input');
      input.type = 'text';
      input.name = 'certifications[]';
      input.className = 'certification-input';
      input.value = "";
      container.appendChild(input);
    }

    function validateEditProfile() {
      let isValid = true;
      let errors = [];
      let profileError = document.getElementById("profileError");
      profileError.textContent = "";
      profileError.style.fontWeight = "normal";
      profileError.style.color = "red";

      let fullNameValue = document.getElementById("fullName").value.trim();
      let emailValue = document.getElementById("email").value.trim();
      let linkedInValue = document.getElementById("linkedIn").value.trim();

      if (fullNameValue === "") {
        errors.push("Full Name is required.");
        isValid = false;
      } else if (fullNameValue.split(" ").length < 2) {
        errors.push("Full Name must include at least first and last name.");
        isValid = false;
      }
      if (emailValue === "") {
        errors.push("Email is required.");
        isValid = false;
      } else if (!emailValue.includes("@") || !emailValue.includes(".")) {
        errors.push("Email must include '@' and '.'.");
        isValid = false;
      }
      if (linkedInValue === "") {
        errors.push("LinkedIn URL is required.");
        isValid = false;
      } else if (!linkedInValue.startsWith("http://") && !linkedInValue.startsWith("https://")) {
        errors.push("LinkedIn URL must start with 'http://' or 'https://'.");
        isValid = false;
      }

      // Validate Skills
      let skillInputs = document.getElementsByClassName('skill-input');
      let skillValues = [];
      for (let i = 0; i < skillInputs.length; i++) {
        let val = skillInputs[i].value.trim();
        if (val === "") {
          alert("Please fill in all skill fields before submitting.");
          return false;
        }
        if (skillValues.includes(val.toLowerCase())) {
          alert("Duplicate skill detected: " + val);
          return false;
        }
        skillValues.push(val.toLowerCase());
      }

      // Validate Work Experience
      let expBlocks = document.getElementsByClassName('experience-block');
      for (let i = 0; i < expBlocks.length; i++) {
        let company = expBlocks[i].querySelector('input[name^="experience['+i+'][company]"]');
        let position = expBlocks[i].querySelector('input[name^="experience['+i+'][position]"]');
        let start = expBlocks[i].querySelector('input[name^="experience['+i+'][start]"]');
        let end = expBlocks[i].querySelector('input[name^="experience['+i+'][end]"]');
        let desc = expBlocks[i].querySelector('textarea[name^="experience['+i+'][desc]"]');
        if (company && position && start && end && desc) {
          if (
            company.value.trim() === "" ||
            position.value.trim() === "" ||
            start.value === "" ||
            end.value === "" ||
            desc.value.trim() === ""
          ) {
            errors.push("Please fill in all fields for work experience " + (i+1) + ".");
            isValid = false;
          }
        }
      }

      // Validate Education
      let eduBlocks = document.getElementsByClassName('education-block');
      for (let i = 0; i < eduBlocks.length; i++) {
        let institute = eduBlocks[i].querySelector('input[name^="education['+i+'][institute]"]');
        let program = eduBlocks[i].querySelector('input[name^="education['+i+'][program]"]');
        let start = eduBlocks[i].querySelector('input[name^="education['+i+'][start]"]');
        let end = eduBlocks[i].querySelector('input[name^="education['+i+'][end]"]');
        if (institute && program && start && end) {
          if (
            institute.value.trim() === "" ||
            program.value.trim() === "" ||
            start.value === "" ||
            end.value === ""
          ) {
            errors.push("Please fill in all fields for education " + (i+1) + ".");
            isValid = false;
          }
        }
      }

      // Validate Languages Spoken
      let languageInputs = document.getElementsByClassName('language-input');
      let languageCount = 0;
      let languageValues = [];
      for (let i = 0; i < languageInputs.length; i++) {
        let val = languageInputs[i].value.trim();
        if (val !== "") {
          if (languageValues.includes(val.toLowerCase())) {
            errors.push("Duplicate language: " + val);
            isValid = false;
          }
          languageValues.push(val.toLowerCase());
          languageCount++;
        }
      }
      if (languageCount === 0) {
        errors.push("Please enter at least one language spoken.");
        isValid = false;
      }

      // Validate Certifications
      let certInputs = document.getElementsByClassName('certification-input');
      let certValues = [];
      for (let i = 0; i < certInputs.length; i++) {
        let val = certInputs[i].value.trim();
        if (val !== "") {
          if (certValues.includes(val.toLowerCase())) {
            errors.push("Duplicate certification: " + val);
            isValid = false;
          }
          certValues.push(val.toLowerCase());
        }
      }

      profileError.textContent = errors.join("\n");
      return isValid;
    }
  </script>
</body>
</html>

<?php
session_start();
require_once '../Model/database.php';

// Check if user is logged in and is employer
if(!isset($_SESSION['status']) || $_SESSION['user_role'] != 'Employer'){
    header('location: auth.php?error=badrequest');
}

$employer_id = $_SESSION['user_id'];

// Handle logout
if(isset($_REQUEST['logout'])){
    session_destroy();
    header('location: auth.php');
}

// Handle job posting
if(isset($_REQUEST['postJob'])){
    $title = trim($_REQUEST['jobTitle']);
    $location = trim($_REQUEST['jobLocation']);
    $salary = trim($_REQUEST['jobSalary']);
    $description = "Job description for " . $title; // Default description
    
    if($title != "" && $location != "" && $salary != ""){
        $insert_sql = "INSERT INTO jobs (title, description, location, salary, employer_id) VALUES ('$title', '$description', '$location', 'BDT $salary', '$employer_id')";
        if(mysqli_query($conn, $insert_sql)){
            // Log activity
            $log_sql = "INSERT INTO activity_logs (user_id, user_name, action) VALUES ('$employer_id', '".$_SESSION['user_name']."', 'Posted new job: $title')";
            mysqli_query($conn, $log_sql);
            
            header('location: employer.php?success=posted');
        }else{
            header('location: employer.php?error=failed');
        }
    }else{
        header('location: employer.php?error=null');
    }
}

// Get employer's statistics
$active_jobs_sql = "SELECT COUNT(*) as count FROM jobs WHERE employer_id = '$employer_id' AND status = 'Active'";
$active_jobs_result = mysqli_query($conn, $active_jobs_sql);
$active_jobs = mysqli_fetch_assoc($active_jobs_result)['count'];

$applications_sql = "SELECT COUNT(*) as count FROM job_applications ja JOIN jobs j ON ja.job_id = j.id WHERE j.employer_id = '$employer_id'";
$applications_result = mysqli_query($conn, $applications_sql);
$applications = mysqli_fetch_assoc($applications_result)['count'];

// Get employer's jobs
$jobs_sql = "SELECT id, title, location, salary FROM jobs WHERE employer_id = '$employer_id' ORDER BY created_at DESC";
$jobs_result = mysqli_query($conn, $jobs_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employer Dashboard</title>
    <link rel="stylesheet" href="../Asset/sabid.css">
</head>
<body>

<div class="header">
    <h2>Employer Dashboard - Welcome, <?=$_SESSION['user_name']?></h2>
    <a href="?logout=true"><button class="logout-btn">Logout</button></a>
</div>

<div class="sidebar">
    <ul>
        <li onclick="showSection('overview')">Overview</li>
        <li onclick="showSection('postJob')">Post Job</li>
        <li onclick="showSection('manageJobs')">Manage Jobs</li>
        <li onclick="showSection('notifications')">Notifications</li>
    </ul>
</div>

<div class="main">
    <div id="overview">
        <h3>Overview</h3>
        <div class="card">
            <h3><?=$active_jobs?></h3>
            <p>Active Jobs</p>
        </div>
        <div class="card">
            <h3><?=$applications?></h3>
            <p>Applications</p>
        </div>
        <div class="card">
            <h3>5</h3>
            <p>Interviews Scheduled</p>
        </div>
        <div class="card">
            <h3>8</h3>
            <p>Profile Views</p>
        </div>
    </div>

    <div id="postJob" style="display:none;">
        <h3>Post a New Job</h3>
        <div class="post-job-container">
            <form id="postJobForm" method="POST" onsubmit="return validateJobForm()" class="job-form">
                <div class="form-group">
                    <label for="jobTitle">Job Title:</label>
                    <input type="text" id="jobTitle" name="jobTitle" placeholder="e.g., Senior Web Developer">
                    <p id="jobTitleError" class="error"></p>
                </div>

                <div class="form-group">
                    <label for="jobLocation">Location:</label>
                    <input type="text" id="jobLocation" name="jobLocation" placeholder="e.g., Dhaka, Bangladesh">
                    <p id="jobLocationError" class="error"></p>
                </div>

                <div class="form-group">
                    <label for="jobSalary">Monthly Salary (BDT):</label>
                    <input type="number" id="jobSalary" name="jobSalary" placeholder="e.g., 50000">
                    <p id="jobSalaryError" class="error"></p>
                </div>

                <button type="submit" name="postJob" class="submit-btn">Post New Job</button>
            </form>
        </div>

        <div class="recent-posts">
            <h3>Recently Posted Jobs</h3>
            <div class="job-cards">
                <div class="job-card">
                    <h4>Senior Frontend Developer</h4>
                    <p class="job-location">🏢 Dhaka, Bangladesh</p>
                    <p class="job-salary">💰 BDT 80,000 - 100,000</p>
                    <p class="job-date">📅 Posted: Today</p>
                    <div class="job-tags">
                        <span>React</span>
                        <span>TypeScript</span>
                        <span>5 Years</span>
                    </div>
                </div>

                <div class="job-card">
                    <h4>Backend Developer</h4>
                    <p class="job-location">🏢 Chittagong, Bangladesh</p>
                    <p class="job-salary">💰 BDT 60,000 - 80,000</p>
                    <p class="job-date">📅 Posted: 1 day ago</p>
                    <div class="job-tags">
                        <span>PHP</span>
                        <span>Laravel</span>
                        <span>3 Years</span>
                    </div>
                </div>

                <div class="job-card">
                    <h4>UI/UX Designer</h4>
                    <p class="job-location">🏢 Dhaka, Bangladesh</p>
                    <p class="job-salary">💰 BDT 45,000 - 65,000</p>
                    <p class="job-date">📅 Posted: 2 days ago</p>
                    <div class="job-tags">
                        <span>Figma</span>
                        <span>Adobe XD</span>
                        <span>2 Years</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="manageJobs" style="display:none;">
        <h3>Manage Jobs</h3>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Location</th>
                    <th>Salary</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($job = mysqli_fetch_assoc($jobs_result)): ?>
                    <tr data-id="<?=$job['id']?>">
                        <td><?=$job['title']?></td>
                        <td><?=$job['location']?></td>
                        <td><?=$job['salary']?></td>
                        <td>
                            <button class="btn" onclick="editJob(this)">Edit</button>
                            <button class="btn" onclick="deleteJob(this)">Delete</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <div id="notifications" style="display:none;">
        <h3>Notifications</h3>
        <div class="notification-list">
            <div class="notification-item unread">
                <span class="notification-time">5 minutes ago</span>
                <h4>New Job Application<span class="notification-badge badge-info">New</span></h4>
                <p>E.A. Sabid applied for "Web Developer"</p>
                <button class="action-btn view">View Application</button>
            </div>

            <div class="notification-item unread">
                <span class="notification-time">2 hours ago</span>
                <h4>Application Status Update<span class="notification-badge badge-success">Accepted</span></h4>
                <p>Sabid accepted your job - "Senior UI Designer"</p>
                <button class="action-btn">Send Email</button>
            </div>

            <div class="notification-item">
                <span class="notification-time">2 days ago</span>
                <h4>Interview Schedule</h4>
                <p>Reminder: Virtual interview scheduled with Naim for "Python Developer" tomorrow at 2 PM</p>
                <button class="action-btn">Join Meeting</button>
                <button class="action-btn">Reschedule</button>
            </div>
        </div>
    </div>
</div>

<script>
function showSection(section) {
    document.getElementById('overview').style.display = 'none';
    document.getElementById('postJob').style.display = 'none';
    document.getElementById('manageJobs').style.display = 'none';
    document.getElementById('notifications').style.display = 'none';
    document.getElementById(section).style.display = 'block';
}

function validateJobForm() {
    const title = document.getElementById('jobTitle').value.trim();
    const location = document.getElementById('jobLocation').value.trim();
    const salary = document.getElementById('jobSalary').value.trim();

    let valid = true;
    document.getElementById('jobTitleError').textContent = "";
    document.getElementById('jobLocationError').textContent = "";
    document.getElementById('jobSalaryError').textContent = "";

    if (title === "") {
        document.getElementById('jobTitleError').textContent = "Job title is required.";
        valid = false;
    }
    if (location === "") {
        document.getElementById('jobLocationError').textContent = "Location is required.";
        valid = false;
    }
    if (salary === "") {
        document.getElementById('jobSalaryError').textContent = "Salary is required.";
        valid = false;
    }

    if (valid) {
        // Allow form submission to PHP
        return true;
    }

    return false; 
}

function deleteJob(button) {
    const row = button.closest('tr');
    const jobTitle = row.cells[0].textContent;
    
    if (confirm(`Are you sure you want to delete the job "${jobTitle}"?`)) {
        row.remove();
        
      
        const activeJobsCard = document.querySelector('#overview .card:first-child h3');
        const currentCount = parseInt(activeJobsCard.textContent);
        activeJobsCard.textContent = Math.max(0, currentCount - 1);
        
        alert('Job deleted successfully!');
    }
}

function editJob(button) {
    const row = button.closest('tr');
    const jobTitle = row.cells[0].textContent;
    const jobLocation = row.cells[1].textContent;
    const jobSalary = row.cells[2].textContent.replace('BDT ', '');
    
    // form with  data
    document.getElementById('jobTitle').value = jobTitle;
    document.getElementById('jobLocation').value = jobLocation;
    document.getElementById('jobSalary').value = jobSalary;
    
    // Switch to the Post Job section
    showSection('postJob');
    

    const submitBtn = document.querySelector('#postJobForm .submit-btn');
    submitBtn.textContent = 'Update Job';
    submitBtn.setAttribute('data-editing', 'true');
    submitBtn.setAttribute('data-row-index', Array.from(row.parentNode.children).indexOf(row));
    
    // Scroll 
    document.querySelector('.post-job-container').scrollIntoView({ behavior: 'smooth' });
}
</script>

</body>
</html>

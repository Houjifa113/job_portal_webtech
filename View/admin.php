<?php
session_start();
require_once '../Model/database.php';

// Check if user is logged in and is admin
if(!isset($_SESSION['status']) || $_SESSION['user_role'] != 'Admin'){
    header('location: auth.php?error=badrequest');
}

// Handle logout
if(isset($_REQUEST['logout'])){
    session_destroy();
    header('location: auth.php');
}

// Get statistics
$total_users_sql = "SELECT COUNT(*) as count FROM users";
$total_users_result = mysqli_query($conn, $total_users_sql);
$total_users = mysqli_fetch_assoc($total_users_result)['count'];

$active_employers_sql = "SELECT COUNT(*) as count FROM users WHERE role = 'Employer'";
$active_employers_result = mysqli_query($conn, $active_employers_sql);
$active_employers = mysqli_fetch_assoc($active_employers_result)['count'];

$job_listings_sql = "SELECT COUNT(*) as count FROM jobs WHERE status = 'Active'";
$job_listings_result = mysqli_query($conn, $job_listings_sql);
$job_listings = mysqli_fetch_assoc($job_listings_result)['count'];

$applications_sql = "SELECT COUNT(*) as count FROM job_applications";
$applications_result = mysqli_query($conn, $applications_sql);
$applications = mysqli_fetch_assoc($applications_result)['count'];

// Get users for management
$users_sql = "SELECT id, name, email, role, created_at FROM users ORDER BY created_at DESC";
$users_result = mysqli_query($conn, $users_sql);

// Get recent jobs for reports
$recent_jobs_sql = "SELECT j.title, u.name as company, j.location, j.created_at 
                   FROM jobs j 
                   JOIN users u ON j.employer_id = u.id 
                   ORDER BY j.created_at DESC LIMIT 10";
$recent_jobs_result = mysqli_query($conn, $recent_jobs_sql);

// Get activity logs
$activity_logs_sql = "SELECT user_name, action, created_at FROM activity_logs ORDER BY created_at DESC LIMIT 20";
$activity_logs_result = mysqli_query($conn, $activity_logs_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../Asset/sabid.css">
    <style>
        /* Fix table overflow in Current Users card */
        .simple-card {
            overflow: hidden; /* Prevent content from overflowing */
        }
        
        /* Fixed height for manage users grid */
        .manage-users-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            height: 600px; /* Fixed height */
        }
        
        /* Fixed size for Add New User card */
        .add-user-card {
            height: 100%;
            overflow-y: auto;
        }
        
        /* Fixed size for Current Users card with scroll */
        .current-users-card {
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        
        .table-container {
            flex: 1;
            overflow-y: auto;
            max-height: 500px; /* Fixed max height for scroll */
            border-radius: 6px;
            border: 1px solid #e5e7eb;
        }
        
        .simple-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
            background: white;
            font-size: 13px;
        }
        
        .simple-table th,
        .simple-table td {
            padding: 10px 12px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: middle;
        }
        
        .simple-table th {
            background-color: #f8fafc;
            font-weight: 600;
            color: #374151;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 2px solid #e5e7eb;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        
        .simple-table tbody tr:hover {
            background-color: #f8fafc;
        }
        
        .simple-table .user-email {
            max-width: 180px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        .simple-table .user-name {
            font-weight: 500;
            color: #1f2937;
        }
        
        /* Action buttons styling */
        .simple-table .action-btn {
            padding: 4px 8px;
            margin: 2px;
            font-size: 11px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
        }
        
        .simple-table .action-btn.edit {
            background-color: #3b82f6;
            color: white;
        }
        
        .simple-table .action-btn.edit:hover {
            background-color: #2563eb;
        }
        
        .simple-table .action-btn.delete {
            background-color: #ef4444;
            color: white;
        }
        
        .simple-table .action-btn.delete:hover {
            background-color: #dc2626;
        }
        
        /* Role and status badges */
        .simple-table .role-badge,
        .simple-table .status-badge {
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }
        
        .simple-table .role-badge.admin {
            background-color: #dc2626;
            color: white;
        }
        
        .simple-table .role-badge.employer {
            background-color: #059669;
            color: white;
        }
        
        .simple-table .role-badge.jobseeker {
            background-color: #0891b2;
            color: white;
        }
        
        .simple-table .status-badge.active {
            background-color: #22c55e;
            color: white;
        }
        
        /* Custom scrollbar styling */
        .table-container::-webkit-scrollbar {
            width: 8px;
        }
        
        .table-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }
        
        .table-container::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 4px;
        }
        
        .table-container::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
        
        /* Recently Posted Jobs table styling */
        .job-title {
            font-weight: 600;
            color: #1e40af;
        }
        
        .company-name {
            font-weight: 500;
            color: #059669;
        }
        
        .job-location {
            color: #6b7280;
        }
        
        .job-salary {
            font-weight: 600;
            color: #dc2626;
        }
        
        .posted-date {
            color: #4b5563;
            font-size: 12px;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .manage-users-grid {
                grid-template-columns: 1fr;
                height: auto;
            }
            
            .current-users-card,
            .add-user-card {
                height: 400px;
            }
            
            .table-container {
                max-height: 300px;
            }
            
            .simple-table {
                font-size: 12px;
            }
            
            .simple-table th,
            .simple-table td {
                padding: 8px 6px;
            }
            
            .simple-table .user-email {
                max-width: 120px;
            }
            
            .simple-table .action-btn {
                padding: 3px 6px;
                font-size: 10px;
                margin: 1px;
            }
        }
    </style>
</head>
<body>

<div class="header">
    <h2>Admin Dashboard - Welcome, <?=$_SESSION['user_name']?></h2>
    <button class="logout-btn" onclick="window.location.href='?logout=true'">Logout</button>
</div>

<div class="sidebar">
    <ul>
        <li onclick="showSection('overview')">Overview</li>
        <li onclick="showSection('manageUsers')">Manage Users</li>
        <li onclick="showSection('reports')">Reports</li>
        <li onclick="showSection('notifications')">Notifications</li>
        <li onclick="showSection('activityLogs')">Activity Logs</li>
        <li onclick="showSection('dataExport')">Data Export</li>
    </ul>
</div>

<div class="main">
    <div id="overview">
        <h3>Overview</h3>
        <div class="card">
            <h3><?=$total_users?></h3>
            <p>Total Users</p>
        </div>
        <div class="card">
            <h3><?=$active_employers?></h3>
            <p>Active Employers</p>
        </div>
        <div class="card">
            <h3><?=$job_listings?></h3>
            <p>Job Listings</p>
        </div>
        <div class="card">
            <h3><?=$applications?></h3>
            <p>Applications</p>
        </div>
    </div>

    <div id="manageUsers" style="display:none;">
        <h3>Manage Users</h3>
        <div id="messageArea"></div>

        <div class="manage-users-grid">
            <div class="simple-card add-user-card">
                <h4>Add New User</h4>
                <form id="addUserForm" onsubmit="return handleAddUser(event)">
                    <div class="input-group">
                        <label for="newUsername">Username:</label>
                        <input type="text" id="newUsername" name="newUsername" placeholder="Enter username" required>
                        <p id="usernameError" class="error"></p>
                    </div>

                    <div class="input-group">
                        <label for="newEmail">Email:</label>
                        <input type="email" id="newEmail" name="newEmail" placeholder="Enter email" required>
                        <p id="emailError" class="error"></p>
                    </div>

                    <div class="input-group">
                        <label for="newRole">Role:</label>
                        <select id="newRole" name="newRole" required>
                            <option value="">Select Role</option>
                            <option value="admin">Admin</option>
                            <option value="employer">Employer</option>
                            <option value="jobseeker">Job Seeker</option>
                        </select>
                        <p id="roleError" class="error"></p>
                    </div>

                    <div class="input-group">
                        <label for="newPassword">Password:</label>
                        <input type="password" id="newPassword" name="newPassword" placeholder="Enter password" required>
                        <p id="passwordError" class="error"></p>
                    </div>

                    <button type="submit" class="submit-btn">Add User</button>
                </form>
            </div>

            <div class="simple-card current-users-card">
                <h4>Current Users</h4>
                <div class="table-container">
                    <table class="simple-table">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="usersTableBody">
                            <?php while($user = mysqli_fetch_assoc($users_result)): ?>
                                <tr data-id="<?=$user['id']?>">
                                    <td class="user-name"><?=$user['name']?></td>
                                    <td class="user-email"><?=$user['email']?></td>
                                    <td><span class="role-badge <?=strtolower($user['role'])?>"><?=$user['role']?></span></td>
                                    <td><span class="status-badge active">Active</span></td>
                                    <td>
                                        <?php if ($user['role'] != 'Admin'): ?>
                                            <button class="action-btn edit" onclick="editUser(<?=$user['id']?>)">Edit</button>
                                            <button class="action-btn delete" onclick="deleteUser(this, <?=$user['id']?>)">Delete</button>
                                        <?php else: ?>
                                            <em style="color: #64748b;">Protected</em>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Edit User Modal -->
        <div id="editUserModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 2000;">
            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 30px; border-radius: 10px; width: 400px; max-width: 90%;">
                <h4 style="margin-top: 0;">Edit User</h4>
                <form id="editUserForm" onsubmit="return handleEditUser(event)">
                    <input type="hidden" id="editUserId">
                    
                    <div class="input-group">
                        <label for="editUsername">Username:</label>
                        <input type="text" id="editUsername" name="editUsername" required>
                        <p id="editUsernameError" class="error"></p>
                    </div>

                    <div class="input-group">
                        <label for="editEmail">Email:</label>
                        <input type="email" id="editEmail" name="editEmail" required>
                        <p id="editEmailError" class="error"></p>
                    </div>

                    <div class="input-group">
                        <label for="editRole">Role:</label>
                        <select id="editRole" name="editRole" required>
                            <option value="admin">Admin</option>
                            <option value="employer">Employer</option>
                            <option value="jobseeker">Job Seeker</option>
                        </select>
                        <p id="editRoleError" class="error"></p>
                    </div>

                    <div style="display: flex; gap: 10px; margin-top: 20px;">
                        <button type="submit" class="submit-btn" style="width: auto; flex: 1;">Update User</button>
                        <button type="button" onclick="closeEditModal()" class="submit-btn" style="width: auto; flex: 1; background: #6b7280;">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="reports" style="display:none;">
        <h3>Reports</h3>
        <div class="simple-grid">
            <div class="simple-card">
                <h4>Quick Statistics</h4>
                <div class="stats-container">
                    <div class="stat-box">
                        <span class="stat-number"><?=$total_users?></span>
                        <span class="stat-label">Total Users</span>
                    </div>
                    <div class="stat-box">
                        <span class="stat-number"><?=$job_listings?></span>
                        <span class="stat-label">Active Jobs</span>
                    </div>
                    <div class="stat-box">
                        <span class="stat-number"><?=$applications?></span>
                        <span class="stat-label">Applications</span>
                    </div>
                </div>
            </div>

            <div class="simple-card">
                <h4>Recently Posted Jobs</h4>
                <div class="table-container">
                    <table class="simple-table">
                        <thead>
                            <tr>
                                <th>Job Title</th>
                                <th>Company</th>
                                <th>Location</th>
                                <th>Salary</th>
                                <th>Posted Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if(mysqli_num_rows($recent_jobs_result) > 0):
                                while($job = mysqli_fetch_assoc($recent_jobs_result)): 
                            ?>
                                <tr>
                                    <td class="job-title"><?=$job['title']?></td>
                                    <td class="company-name"><?=$job['company']?></td>
                                    <td class="job-location"><?=$job['location']?></td>
                                    <td class="job-salary">
                                        <?php 
                                        // Get salary from jobs table
                                        $job_salary_sql = "SELECT salary FROM jobs WHERE title = '".$job['title']."' AND employer_id = (SELECT id FROM users WHERE name = '".$job['company']."') LIMIT 1";
                                        $salary_result = mysqli_query($conn, $job_salary_sql);
                                        if(mysqli_num_rows($salary_result) > 0) {
                                            $salary_row = mysqli_fetch_assoc($salary_result);
                                            echo $salary_row['salary'];
                                        } else {
                                            echo "Not specified";
                                        }
                                        ?>
                                    </td>
                                    <td class="posted-date"><?=date('M d, Y', strtotime($job['created_at']))?></td>
                                </tr>
                            <?php 
                                endwhile;
                            else: 
                            ?>
                                <tr>
                                    <td colspan="5" style="text-align: center; color: #64748b; font-style: italic; padding: 20px;">
                                        No jobs have been posted yet.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="notifications" style="display:none;">
        <h3>Notifications</h3>
        <div class="notification-list">
            <div class="notification-item unread">
                <span class="notification-time">2 minutes ago</span>
                <h4>New User Registration</h4>
                <p>New employer "AIUB" needs approval.</p>
                <button class="action-btn approve">Approve</button>
                <button class="action-btn reject">Reject</button>
            </div>
            
            <div class="notification-item unread">
                <span class="notification-time">1 hour ago</span>
                <h4>Job Posting Report</h4>
                <p>A job posting has been reported for inappropriate content.</p>
                <button class="action-btn">Review</button>
            </div>

            <div class="notification-item">
                <span class="notification-time">1 day ago</span>
                <h4>System Update</h4>
                <p>The job portal will undergo maintenance</p>
                <button class="action-btn">Details</button>
            </div>

            <div class="notification-item">
                <span class="notification-time">2 days ago</span>
                <h4>Account Deletion Request</h4>
                <p>Sabid requested account deletion.</p>
                <button class="action-btn">Process</button>
            </div>
        </div>
    </div>

    <div id="activityLogs" style="display:none;">
        <h3>Activity Logs</h3>
        <div class="simple-grid">
            <div class="simple-card">
                <h4>Filter Logs</h4>
                <form id="logFilterForm" onsubmit="return filterLogs(event)">
                    <div class="input-group">
                        Date:
                        <input type="date" id="logDate" name="logDate">
                        <p id="dateError" class="error"></p>
                    </div>
                    <div class="input-group">
                        Activity Type:
                        <select id="logType" name="logType">
                            <option value="">All Activities</option>
                            <option value="login">Login Activities</option>
                            <option value="user">User Management</option>
                            <option value="job">Job Activities</option>
                            <option value="system">System Activities</option>
                        </select>
                        <p id="typeError" class="error"></p>
                    </div>
                    <button type="submit" class="submit-btn">Apply Filter</button>
                </form>
            </div>

            <div class="simple-card">
                <h4>Recent Activities</h4>
                <table class="simple-table">
                    <thead>
                        <tr>
                            <th>Timestamp</th>
                            <th>User</th>
                            <th>Activity Type</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody id="activityLogBody">
                        <tr>
                            <td>2025-09-03 15:30</td>
                            <td>admin</td>
                            <td><span class="role-badge admin">Login</span></td>
                            <td>Admin logged into the system</td>
                        </tr>
                        <tr>
                            <td>2025-09-03 15:25</td>
                            <td>Sabid</td>
                            <td><span class="role-badge employer">Job</span></td>
                            <td>Posted new job: Senior Developer</td>
                        </tr>
                        <tr>
                            <td>2025-09-03 15:20</td>
                            <td>system</td>
                            <td><span class="role-badge jobseeker">System</span></td>
                            <td>Daily backup completed</td>
                        </tr>

                        <tr>
                            <td>2025-09-03 15:15</td>
                            <td>admin</td>
                            <td><span class="role-badge admin">User</span></td>
                            <td>Created new user account: John</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="dataExport" style="display:none;">
        <h3>Data Export</h3>
        <div class="simple-card" style="max-width: 500px; margin: 0 auto;">
            <h4>Export Data</h4>
            <form id="exportForm" onsubmit="return exportData(event)">
                <div class="input-group">
                    <label for="exportType">Select Data to Export:</label>
                    <select id="exportType" name="exportType" required>
                        <option value="">Select Type</option>
                        <option value="users">Users Data</option>
                        <option value="jobs">Jobs Data</option>
                        <option value="applications">Applications Data</option>
                        <option value="logs">Activity Logs</option>
                    </select>
                    <p id="exportTypeError" class="error"></p>
                </div>
                
                <div class="input-group">
                    <label for="exportFormat">Export Format:</label>
                    <select id="exportFormat" name="exportFormat" required>
                        <option value="">Select Format</option>
                        <option value="excel">Excel File</option>
                        <option value="pdf">PDF Document</option>
                    </select>
                    <p id="exportFormatError" class="error"></p>
                </div>
                
                <button type="submit" class="submit-btn">Export & Download</button>
            </form>
            
            <div id="exportMessage" style="margin-top: 20px; display: none;">
                <p style="color: #059669; background: #f0fdf4; padding: 10px; border-radius: 5px; text-align: center;">
                    <strong>Export completed!</strong><br>
                    File downloaded successfully.
                </p>
            </div>
        </div>
    </div>
</div>

<script>
function showSection(section) {
    document.getElementById('overview').style.display = 'none';
    document.getElementById('manageUsers').style.display = 'none';
    document.getElementById('reports').style.display = 'none';
    document.getElementById('notifications').style.display = 'none';
    document.getElementById('activityLogs').style.display = 'none';
    document.getElementById('dataExport').style.display = 'none';
    document.getElementById(section).style.display = 'block';
}

function validateAddUser() {
    const username = document.getElementById('newUsername').value.trim();
    const email = document.getElementById('newEmail').value.trim();
    const role = document.getElementById('newRole').value;
    const password = document.getElementById('newPassword').value;

    let valid = true;
    
    // Clear previous errors
    document.getElementById('usernameError').textContent = "";
    document.getElementById('emailError').textContent = "";
    document.getElementById('roleError').textContent = "";
    document.getElementById('passwordError').textContent = "";

    if (username === "") {
        document.getElementById('usernameError').textContent = "Username is required.";
        valid = false;
    }
    if (email === "") {
        document.getElementById('emailError').textContent = "Email is required.";
        valid = false;
    }
    if (role === "") {
        document.getElementById('roleError').textContent = "Role must be selected.";
        valid = false;
    }
    if (password === "") {
        document.getElementById('passwordError').textContent = "Password is required.";
        valid = false;
    }

    return valid;
}

// CRUD Operations for Users
let userIdCounter = 4; // Starting from 4 since we have 3 existing users

function handleAddUser(event) {
    event.preventDefault();
    if (!validateAddUser()) return false;

    const formData = new FormData();
    formData.append('action', 'add_user');
    formData.append('name', document.getElementById('newUsername').value.trim());
    formData.append('email', document.getElementById('newEmail').value.trim());
    formData.append('password', document.getElementById('newPassword').value);
    formData.append('role', document.getElementById('newRole').value);

    fetch('../Controller/admin_actions.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            document.getElementById('messageArea').innerHTML = 
                `<p class="error">${data.error}</p>`;
        }
    });

    return false;
}

function editUser(userId) {
    const row = document.querySelector(`tr[data-id="${userId}"]`);
    if (!row) return;
    
    const username = row.querySelector('.user-name').textContent;
    const email = row.querySelector('.user-email').textContent;
    const roleSpan = row.querySelector('.role-badge');
    const role = roleSpan.textContent.toLowerCase();

    // Populate edit form
    document.getElementById('editUserId').value = userId;
    document.getElementById('editUsername').value = username;
    document.getElementById('editEmail').value = email;
    document.getElementById('editRole').value = role;
    
    // Show edit modal
    document.getElementById('editUserModal').style.display = 'block';
}

function handleEditUser(event) {
    event.preventDefault();
    
    const userId = document.getElementById('editUserId').value;
    const username = document.getElementById('editUsername').value.trim();
    const email = document.getElementById('editEmail').value.trim();
    const role = document.getElementById('editRole').value;
    
    // Clear previous errors
    document.getElementById('editUsernameError').textContent = "";
    document.getElementById('editEmailError').textContent = "";
    document.getElementById('editRoleError').textContent = "";
    
    // Validate
    let valid = true;
    if (username === "") {
        document.getElementById('editUsernameError').textContent = "Username is required.";
        valid = false;
    }
    if (email === "") {
        document.getElementById('editEmailError').textContent = "Email is required.";
        valid = false;
    }
    if (role === "") {
        document.getElementById('editRoleError').textContent = "Role must be selected.";
        valid = false;
    }
    // extra validation
    if(password === ""){
        document.getElementById('editPasswordByid').textContent = "password must be selected";
    }
    if(loggedIn){
        document.getElementById('time of login').textContent = "text must be in password";
    }
    if(userRole === ""){
        document.getElementById('invalid Role Selected').textContent = "Select a valid role";
    }
    
    if (!valid) return false;
    
    const formData = new FormData();
    formData.append('action', 'update_user');
    formData.append('user_id', userId);
    formData.append('name', username);
    formData.append('email', email);
    formData.append('role', role);

    fetch('../Controller/admin_actions.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.error);
        }
    });
    
    return false;
}

function deleteUser(button, userId) {
    const row = document.querySelector(`tr[data-id="${userId}"]`);
    if (!row) return;
    
    const username = row.querySelector('.user-name').textContent;
    const roleSpan = row.querySelector('.role-badge');
    
    // Don't allow admin deletion
    if (roleSpan.classList.contains('admin')) {
        alert('Admin users cannot be deleted!');
        return;
    }

    if (confirm(`Are you sure you want to delete user "${username}"?`)) {
        const formData = new FormData();
        formData.append('action', 'delete_user');
        formData.append('user_id', userId);

        fetch('../Controller/admin_actions.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.error);
            }
        });
    }
}

function closeEditModal() {
    document.getElementById('editUserModal').style.display = 'none';
}

function logActivity(description, type) {
    const activityLogBody = document.getElementById('activityLogBody');
    const newLogRow = document.createElement('tr');
    const now = new Date().toLocaleString();
    
    newLogRow.innerHTML = `
        <td>${now}</td>
        <td>Admin</td>
        <td><span class="role-badge admin">${type}</span></td>
        <td>${description}</td>
    `;
    activityLogBody.insertBefore(newLogRow, activityLogBody.firstChild);
}

function filterLogs(event) {
    event.preventDefault();
    const date = document.getElementById('logDate').value;
    const type = document.getElementById('logType').value;
    let valid = true;

    document.getElementById('dateError').textContent = "";
    document.getElementById('typeError').textContent = "";

    if (date === "") {
        document.getElementById('dateError').textContent = "Please select a date";
        valid = false;
    }

    if (!valid) return false;

    const tbody = document.getElementById('activityLogBody');
    const rows = tbody.getElementsByTagName('tr');
    
    for (let row of rows) {
        const rowDate = row.cells[0].textContent.split(' ')[0];
        const rowType = row.cells[2].textContent.toLowerCase();
        
        if ((!date || rowDate === date) && (!type || rowType.includes(type.toLowerCase()))) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    }

    return false;
}

function exportData(event) {
    event.preventDefault();
    
    const exportType = document.getElementById('exportType').value;
    const exportFormat = document.getElementById('exportFormat').value;
    
    // Clear previous errors
    document.getElementById('exportTypeError').textContent = "";
    document.getElementById('exportFormatError').textContent = "";
    
    // Simple validation
    if (exportType === "") {
        document.getElementById('exportTypeError').textContent = "Please select data type to export.";
        return false;
    }
    
    if (exportFormat === "") {
        document.getElementById('exportFormatError').textContent = "Please select export format.";
        return false;
    }
    
    // Create a simple form and submit it
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '../Controller/export_handler.php';
    form.target = '_blank';
    
    const typeInput = document.createElement('input');
    typeInput.type = 'hidden';
    typeInput.name = 'export_type';
    typeInput.value = exportType;
    form.appendChild(typeInput);
    
    const formatInput = document.createElement('input');
    formatInput.type = 'hidden';
    formatInput.name = 'export_format';
    formatInput.value = exportFormat;
    form.appendChild(formatInput);
    
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
    
    // Show success message
    document.getElementById('exportMessage').style.display = 'block';
    setTimeout(function() {
        document.getElementById('exportMessage').style.display = 'none';
    }, 3000);
    
    return false;
}
</script>

</body>
</html>

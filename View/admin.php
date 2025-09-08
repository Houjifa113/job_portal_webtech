<?php
require_once '../Model/config.php';

// Check if user is logged in and is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header("Location: ../View/UserAuthetication.php");
    exit();
}

// Get dashboard statistics
function getDashboardStats($pdo) {
    $stats = [];
    
    // Total Users
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM users");
    $stats['total_users'] = $stmt->fetch()['total'];
    
    // Active Employers
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM users WHERE role = 'Employer'");
    $stats['active_employers'] = $stmt->fetch()['total'];
    
    // Job Listings
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM jobs");
    $stats['job_listings'] = $stmt->fetch()['total'];
    
    // Applications
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM job_applications");
    $stats['applications'] = $stmt->fetch()['total'];
    
    return $stats;
}

// Get all users for manage users section
function getAllUsers($pdo) {
    $stmt = $pdo->query("SELECT * FROM users ORDER BY created_at DESC");
    return $stmt->fetchAll();
}

// Get recent activity logs
function getRecentLogs($pdo, $limit = 10) {
    $stmt = $pdo->prepare("SELECT * FROM activity_logs ORDER BY created_at DESC LIMIT ?");
    $stmt->execute([$limit]);
    return $stmt->fetchAll();
}

// Handle user actions (CRUD operations)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add_user':
                $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
                $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $role = filter_var($_POST['role'], FILTER_SANITIZE_STRING);
                
                try {
                    $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$name, $email, $password, $role]);
                    logActivity($pdo, $_SESSION['user_id'], $_SESSION['username'], "Added new user: $name");
                    echo json_encode(['success' => true]);
                    exit;
                } catch (PDOException $e) {
                    echo json_encode(['error' => 'Email already exists']);
                    exit;
                }
                break;
                
            case 'delete_user':
                $userId = filter_var($_POST['user_id'], FILTER_SANITIZE_NUMBER_INT);
                try {
                    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ? AND role != 'Admin'");
                    $stmt->execute([$userId]);
                    logActivity($pdo, $_SESSION['user_id'], $_SESSION['username'], "Deleted user ID: $userId");
                    echo json_encode(['success' => true]);
                    exit;
                } catch (PDOException $e) {
                    echo json_encode(['error' => 'Cannot delete user']);
                    exit;
                }
                break;
                
            case 'update_user':
                $userId = filter_var($_POST['user_id'], FILTER_SANITIZE_NUMBER_INT);
                $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
                $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
                $role = filter_var($_POST['role'], FILTER_SANITIZE_STRING);
                
                try {
                    $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ?, role = ? WHERE id = ?");
                    $stmt->execute([$name, $email, $role, $userId]);
                    logActivity($pdo, $_SESSION['user_id'], $_SESSION['username'], "Updated user ID: $userId");
                    echo json_encode(['success' => true]);
                    exit;
                } catch (PDOException $e) {
                    echo json_encode(['error' => 'Cannot update user']);
                    exit;
                }
                break;
        }
    }
}

// Get initial statistics
$stats = getDashboardStats($pdo);
$users = getAllUsers($pdo);
$recent_logs = getRecentLogs($pdo);

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: ../View/UserAuthetication.php");
    exit;
}

$username = $_SESSION['username'];
$role = $_SESSION['role'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= ucfirst($role) ?> Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f3f4f6;
        }
        .header {
            background-color: #2563eb;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
        }
        .header h2 {
            margin: 0;
        }
        .logout-btn {
            padding: 6px 12px;
            border: none;
            margin-right: 30px;
            border-radius: 4px;
            background-color: #ef4444;
            color: white;
            cursor: pointer;
        }
        .sidebar {
            width: 220px;
            background-color: #1e293b;
            height: 100vh;
            position: fixed;
            top: 60px; 
            left: 0;
            padding-top: 20px;
            color: white;
        }
        .sidebar ul {
            list-style: none;
            padding-left: 0;
        }
        .sidebar ul li {
            padding: 12px 20px;
            cursor: pointer;
        }
        .sidebar ul li:hover {
            background-color: #334155;
        }
        .main {
            margin-left: 220px;
            padding: 80px 20px 20px; 
        }
        .card {
            display: inline-block;
            width: 200px;
            margin: 10px;
            padding: 15px;
            background-color: white;
            border-radius: 6px;
            box-shadow: 0 0 6px #ccc;
            text-align: center;
            transition: transform 0.2s;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .card h3 {
            margin: 10px 0;
            font-size: 22px;
            color: #2563eb;
        }
        .card p {
            margin: 0;
            color: #4b5563;
        }
        p[id$="Error"], .error {
            color: red;
            font-size: 14px;
            margin: 4px 0;
        }
        .success {
            color: green;
            font-size: 14px;
        }

        /* Manage Users and Reports Styles */
        .simple-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
            margin: 20px 0;
            padding: 0 20px;
        }

        .simple-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.2s ease;
        }

        .simple-card:hover {
            transform: translateY(-5px);
        }

        .simple-card h4 {
            margin: 0 0 20px 0;
            color: #1e40af;
            font-size: 18px;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 10px;
        }

        /* Form Styles */
        .input-group {
            margin-bottom: 20px;
        }

        .input-group label {
            display: block;
            margin-bottom: 8px;
            color: #374151;
            font-weight: 500;
        }

        .input-group input,
        .input-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.2s ease;
        }

        .input-group input:focus,
        .input-group select:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
        }

        .submit-btn {
            background: #2563eb;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
            font-weight: 500;
            width: 100%;
            transition: background-color 0.2s ease;
        }

        .submit-btn:hover {
            background: #1d4ed8;
        }

        /* Table Styles */
        .simple-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 10px;
        }

        .simple-table th,
        .simple-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        .simple-table th {
            background: #f8fafc;
            font-weight: 600;
            color: #374151;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.05em;
        }

        .simple-table tr:hover {
            background-color: #f8fafc;
        }

        /* Badge Styles */
        .role-badge, 
        .status-badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            color: white;
            display: inline-block;
        }

        .role-badge.admin { 
            background: #818cf8;
        }
        .role-badge.employer { 
            background: #34d399;
        }
        .role-badge.jobseeker { 
            background: #fbbf24;
        }
        .status-badge.active { 
            background: #22c55e;
        }

        /* Action Buttons */
        .action-btn {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 500;
            margin-right: 6px;
            transition: all 0.2s ease;
        }

        .action-btn.edit {
            background: #2563eb;
            color: white;
        }

        .action-btn.edit:hover {
            background: #1d4ed8;
        }

        .action-btn.delete {
            background: #dc2626;
            color: white;
        }

        .action-btn.delete:hover {
            background: #b91c1c;
        }

        /* Notification Styles */
        .notification-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .notification-item {
            background: #fff;
            border-left: 4px solid #e5e7eb;
            border-radius: 8px;
            padding: 15px;
            transition: all 0.2s ease;
        }

        .notification-item.unread {
            border-left-color: #2563eb;
            background-color: #f8fafc;
        }

        .notification-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .notification-type {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            color: white;
        }

        .notification-type.urgent { background-color: #dc2626; }
        .notification-type.warning { background-color: #f59e0b; }
        .notification-type.info { background-color: #3b82f6; }
        .notification-type.success { background-color: #10b981; }

        .notification-time {
            color: #6b7280;
            font-size: 12px;
        }

        .notification-content h5 {
            margin: 0 0 8px 0;
            color: #1f2937;
            font-size: 16px;
        }

        .notification-content p {
            margin: 0 0 15px 0;
            color: #4b5563;
            font-size: 14px;
            line-height: 1.5;
        }

        .notification-actions {
            display: flex;
            gap: 10px;
        }

        .notification-actions .action-btn {
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .notification-actions .action-btn.approve {
            background-color: #10b981;
            color: white;
        }

        .notification-actions .action-btn.approve:hover {
            background-color: #059669;
        }

        /* Stats Styles */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
            margin-top: 10px;
        }

        .stat-box {
            text-align: center;
            padding: 20px;
            background: #f8fafc;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            transition: transform 0.2s ease;
        }

        .stat-box:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }

        .stat-number {
            display: block;
            font-size: 28px;
            font-weight: 600;
            color: #2563eb;
            margin-bottom: 5px;
        }

        .stat-label {
            display: block;
            font-size: 14px;
            color: #64748b;
            font-weight: 500;
        }

        /* Responsive Grid */
        @media screen and (min-width: 768px) {
            .simple-grid {
                grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            }
        }

        /* Notification Styles */
        .notification-list {
            max-width: 800px;
        }

        .notification-item {
            background: white;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            position: relative;
            border-left: 4px solid #cbd5e1;
        }

        .notification-item.unread {
            border-left-color: #2563eb;
            background-color: #f8fafc;
        }

        .notification-item h4 {
            margin: 0 0 10px 0;
            color: #1e293b;
            font-size: 16px;
        }

        .notification-item p {
            margin: 0 0 15px 0;
            color: #64748b;
        }

        .notification-time {
            position: absolute;
            top: 15px;
            right: 15px;
            color: #94a3b8;
            font-size: 12px;
        }

        .action-btn {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            background-color: #2563eb;
            color: white;
            cursor: pointer;
            margin-right: 10px;
            font-size: 12px;
        }

        .action-btn:hover {
            background-color: #1d4ed8;
        }

        .action-btn.approve {
            background-color: #22c55e;
        }

        .action-btn.approve:hover {
            background-color: #16a34a;
        }

        .action-btn.reject {
            background-color: #ef4444;
        }

        .action-btn.reject:hover {
            background-color: #dc2626;
        }
        
        @media screen and (max-width: 600px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
                padding-top: 10px;
            }
            .main {
                margin-left: 0;
                padding: 100px 10px 20px;
            }
        }
    </style>
</head>
<body>

<div class="header">
    <h2><?= ucfirst($role) ?> Dashboard - Welcome, <?= htmlspecialchars($username) ?></h2>
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
            <h3>10</h3>
            <p>Total Users</p>
        </div>
        <div class="card">
            <h3>5</h3>
            <p>Active Employers</p>
        </div>
        <div class="card">
            <h3>20</h3>
            <p>Job Listings</p>
        </div>
        <div class="card">
            <h3>15</h3>
            <p>Applications</p>
        </div>
    </div>

    <div id="manageUsers" style="display:none;">
        <h3>Manage Users</h3>
        <div id="messageArea"></div>

        <div class="simple-grid">
            <div class="simple-card">
                <h4>Add New User</h4>
                <form id="addUserForm" onsubmit="return handleAddUser(event)">
                    <div class="input-group">
                        Username:
                        <input type="text" id="newUsername" name="newUsername" placeholder="Enter username">
                        <p id="usernameError" class="error"></p>
                    </div>

                    <div class="input-group">
                        Role:
                        <select id="newRole" name="newRole">
                            <option value="">Select Role</option>
                            <option value="admin">Admin</option>
                            <option value="employer">Employer</option>
                            <option value="jobseeker">Job Seeker</option>
                        </select>
                        <p id="roleError" class="error"></p>
                    </div>

                    <button type="submit" class="submit-btn">Add User</button>
                </form>
            </div>

            <div class="simple-card">
                <h4>Current Users</h4>
                <table class="simple-table">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Sabid</td>
                            <td><span class="role-badge employer">Employer</span></td>
                            <td><span class="status-badge active">Active</span></td>
                            <td>
                                <button class="action-btn edit">Edit</button>
                                <button class="action-btn delete" onclick="deleteUser(this)">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Abid</td>
                            <td><span class="role-badge jobseeker">Job Seeker</span></td>
                            <td><span class="status-badge active">Active</span></td>
                            <td>
                                <button class="action-btn edit">Edit</button>
                                <button class="action-btn delete" onclick="deleteUser(this)">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>admin</td>
                            <td><span class="role-badge admin">Admin</span></td>
                            <td><span class="status-badge active">Active</span></td>
                            <td><em style="color: #64748b;">Protected</em></td>
                        </tr>
                    </tbody>
                </table>
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
                        <span class="stat-number">150</span>
                        <span class="stat-label">Total Users</span>
                    </div>
                    <div class="stat-box">
                        <span class="stat-number">75</span>
                        <span class="stat-label">Active Jobs</span>
                    </div>
                    <div class="stat-box">
                        <span class="stat-number">324</span>
                        <span class="stat-label">Applications</span>
                    </div>
                </div>
            </div>

            <div class="simple-card">
                <h4>Recently Posted Jobs</h4>
                <table class="simple-table">
                    <thead>
                        <tr>
                            <th>Job Title</th>
                            <th>Company</th>
                            <th>Location</th>
                            <th>Posted Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Senior Web Developer</td>
                            <td>AlgoTech</td>
                            <td>Dhaka</td>
                            <td>2025-09-01</td>
                        </tr>
                        <tr>
                            <td>UI/UX Designer</td>
                            <td>AlgoTech IT</td>
                            <td>Chittagong</td>
                            <td>2025-08-30</td>
                        </tr>
                        <tr>
                            <td>PHP Developer</td>
                            <td>SilkVally</td>
                            <td>Dhaka</td>
                            <td>2025-08-29</td>
                        </tr>
                    </tbody>
                </table>
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
        <div class="simple-grid">
            <div class="simple-card">
                <h4>Export Data</h4>
                <form id="exportForm">
                    <div class="input-group">
                        Select Data to Export:
                        <select id="exportType" name="exportType">
                            <option value="">--Select Type--</option>
                            <option value="users">Users Data</option>
                            <option value="jobs">Jobs Data</option>
                            <option value="applications">Applications Data</option>
                            <option value="logs">Activity Logs</option>
                        </select>
                        <p id="exportTypeError" class="error"></p>
                    </div>
                    <button type="button" onclick="exportData()" class="submit-btn">Export as CSV</button>
                </form>
            </div>

            <div class="simple-card">
                <h4>Export History</h4>
                <table class="simple-table">
                    <thead>
                        <tr>
                            <th>Date & Time</th>
                            <th>Type</th>
                            <th>Format</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="exportHistoryBody">
                        <tr>
                            <td>2025-09-03 15:30</td>
                            <td>Users Data</td>
                            <td>CSV</td>
                            <td><span class="status-badge active">Completed</span></td>
                        </tr>
                        <tr>
                            <td>2025-09-03 14:45</td>
                            <td>Jobs Data</td>
                            <td>Excel</td>
                            <td><span class="status-badge active">Completed</span></td>
                        </tr>
                        <tr>
                            <td>2025-09-03 14:00</td>
                            <td>Activity Logs</td>
                            <td>PDF</td>
                            <td><span class="status-badge active">Completed</span></td>
                        </tr>
                    </tbody>
                </table>
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
    const role = document.getElementById('newRole').value;

    let valid = true;
    document.getElementById('usernameError').textContent = "";
    document.getElementById('roleError').textContent = "";

    if (username === "") {
        document.getElementById('usernameError').textContent = "Username is required.";
        valid = false;
    }
    if (role === "") {
        document.getElementById('roleError').textContent = "Role must be selected.";
        valid = false;
    }

    return valid;
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

function deleteUser(button) {
    const row = button.closest('tr');
    const username = row.cells[0].textContent;
    const role = row.cells[1].textContent;
    
    // Don't allow admin deletion
    if (role.includes('Admin')) {
        alert('Admin users cannot be deleted!');
        return;
    }

    if (confirm(`Are you sure you want to temporarily delete user "${username}"?`)) {
        // Hide the row instead of removing it
        row.style.display = 'none';
        
        // Change user count in overview
        const totalUsersElement = document.querySelector('#overview .card:first-child h3');
        const currentCount = parseInt(totalUsersElement.textContent);
        totalUsersElement.textContent = currentCount - 1;

        // Add to activity logs
        const activityLogBody = document.getElementById('activityLogBody');
        const newLogRow = document.createElement('tr');
        const now = new Date().toLocaleString();
        newLogRow.innerHTML = `
            <td>${now}</td>
            <td>${document.querySelector('.header h2').textContent.split(',')[1].trim()}</td>
            <td><span class="role-badge admin">User</span></td>
            <td>Temporarily deleted user: ${username}</td>
        `;
        activityLogBody.insertBefore(newLogRow, activityLogBody.firstChild);

        // Add notification
        const notificationList = document.querySelector('.notification-list');
        const newNotification = document.createElement('div');
        newNotification.className = 'notification-item unread';
        newNotification.innerHTML = `
            <span class="notification-time">Just now</span>
            <h4>User Deleted</h4>
            <p>User "${username}" has been temporarily deleted.</p>
            <button class="action-btn" onclick="restoreUser('${username}', this)">Restore User</button>
        `;
        notificationList.insertBefore(newNotification, notificationList.firstChild);
    }
}

function restoreUser(username, button) {
    // Find and show the hidden row
    const rows = document.querySelectorAll('.simple-table tr');
    for (let row of rows) {
        if (row.cells[0].textContent === username) {
            row.style.display = '';
            
            // Update user count in overview
            const totalUsersElement = document.querySelector('#overview .card:first-child h3');
            const currentCount = parseInt(totalUsersElement.textContent);
            totalUsersElement.textContent = currentCount + 1;

            // Add to activity logs
            const activityLogBody = document.getElementById('activityLogBody');
            const newLogRow = document.createElement('tr');
            const now = new Date().toLocaleString();
            newLogRow.innerHTML = `
                <td>${now}</td>
                <td>${document.querySelector('.header h2').textContent.split(',')[1].trim()}</td>
                <td><span class="role-badge admin">User</span></td>
                <td>Restored user: ${username}</td>
            `;
            activityLogBody.insertBefore(newLogRow, activityLogBody.firstChild);

            // Remove the notification
            const notification = button.closest('.notification-item');
            notification.remove();
            break;
        }
    }
}

function handleAddUser(event) {
    event.preventDefault();
    if (!validateAddUser()) return false;

    const formData = new FormData();
    formData.append('action', 'add_user');
    formData.append('name', document.getElementById('newUsername').value.trim());
    formData.append('email', document.getElementById('newEmail').value.trim());
    formData.append('password', document.getElementById('newPassword').value);
    formData.append('role', document.getElementById('newRole').value);

    fetch('admin_actions.php', {
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

function handleEditUser(userId) {
    const row = document.querySelector(`tr[data-id="${userId}"]`);
    const name = row.querySelector('.user-name').textContent;
    const email = row.querySelector('.user-email').textContent;
    const role = row.querySelector('.user-role').textContent;

    // Populate edit form
    document.getElementById('editUserId').value = userId;
    document.getElementById('editUsername').value = name;
    document.getElementById('editEmail').value = email;
    document.getElementById('editRole').value = role;
    
    // Show edit form
    document.getElementById('editUserForm').style.display = 'block';
}

function handleDeleteUser(userId) {
    if (!confirm('Are you sure you want to delete this user?')) return;

    const formData = new FormData();
    formData.append('action', 'delete_user');
    formData.append('user_id', userId);

    fetch('admin_actions.php', {
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

function exportData() {
    const type = document.getElementById('exportType').value;
    if (!type) {
        document.getElementById('exportTypeError').textContent = "Please select data type";
        return;
    }

    window.location.href = `../Controller/export.php?type=${type}`;
}
    let valid = true;

    document.getElementById('exportTypeError').textContent = "";
    document.getElementById('exportFormatError').textContent = "";

    if (type === "") {
        document.getElementById('exportTypeError').textContent = "Please select data type to export";
        valid = false;
    }

    if (format === "") {
        document.getElementById('exportFormatError').textContent = "Please select export format";
        valid = false;
    }

    if (!valid) return false;

    const tbody = document.getElementById('exportHistoryBody');
    const newRow = tbody.insertRow(0);
    const now = new Date().toLocaleString();
    
    newRow.innerHTML = `
        <td>${now}</td>
        <td>${document.getElementById('exportType').options[document.getElementById('exportType').selectedIndex].text}</td>
        <td>${format.toUpperCase()}</td>
        <td><span class="status-badge active">Completed</span></td>
    `;

    alert(`Exporting ${type} data in ${format.toUpperCase()} format...`);
    
    document.getElementById('exportForm').reset();   // Reset form
    
    return false;
}
</script>

</body>
</html>

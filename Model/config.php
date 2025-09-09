<?php

// Add table name constants
define('TABLE_USERS', 'users');
define('TABLE_JOBS', 'jobs');
define('TABLE_ACTIVITY_LOGS', 'activity_logs');
define('TABLE_JOB_APPLICATIONS', 'job_applications');

// Database configuration 
$host = 'localhost';
$dbname = 'job_portal';
$username = 'root';   // XAMPP default
$password = '';       // XAMPP default

try {
    $pdo = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Fetch associative arrays by default
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}

session_start();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
function csrf_token() {
    return $_SESSION['csrf_token'] ?? '';
}
function csrf_field() {
    $token = htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8');
    echo '<input type="hidden" name="csrf_token" value="'.$token.'">';
}
function verify_csrf() {
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'])) {
        http_response_code(400);
        die('Invalid CSRF token');
    }
}

// ===== Auth helpers =====
function isLoggedIn() {
    return isset($_SESSION['user_id']) && isset($_SESSION['role']) && !empty($_SESSION['user_id']);
}

function checkRole($required_role) {
    if (!isLoggedIn() || $_SESSION['role'] !== $required_role) {
        header('Location: ../View/UserAuthetication.php');
        exit();
    }
}

function redirectDashboard($role) {
    $role = ucwords($role); // Ensure proper case
    $baseDir = '/MakeJobPortal/View/'; // Changed to web root relative path
    
    switch ($role) {
        case 'Admin':
            header('Location: ' . $baseDir . 'admin.php');
            break;
        case 'Employer':
            header('Location: ' . $baseDir . 'employer.php');
            break;
        case 'Job Seeker':
            header('Location: ' . $baseDir . 'jobseeker.php');
            break;
        default:
            header('Location: ' . $baseDir . 'UserAuthetication.php');
            break;
    }
    exit();
}

// ===== Activity log =====
function logActivity($pdo, $user_id, $user_name, $action) {
    $stmt = $pdo->prepare('INSERT INTO '.TABLE_ACTIVITY_LOGS.' (user_id, user_name, action) VALUES (?, ?, ?)');
    $stmt->execute([$user_id, $user_name, $action]);
}
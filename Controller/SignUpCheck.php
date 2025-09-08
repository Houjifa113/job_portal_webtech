<?php
session_start();
require_once '../Model/config.php';

// Verify CSRF token
verify_csrf();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = filter_var($_POST['signupname'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['signupemail'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['signuppassword'];
    $confirmPassword = $_POST['confirmpassword'];
    $role = filter_var($_POST['role'], FILTER_SANITIZE_STRING);

    // Validate inputs
    if (empty($name) || empty($email) || empty($password) || empty($role)) {
        header('Location: ../View/UserAuthetication.php?error=empty_fields');
        exit();
    }

    if ($password !== $confirmPassword) {
        header('Location: ../View/UserAuthetication.php?error=password_mismatch');
        exit();
    }

    // Validate role
    $validRoles = ['Admin', 'Employer', 'Job Seeker'];
    if (!in_array($role, $validRoles)) {
        header('Location: ../View/UserAuthetication.php?error=invalid_role');
        exit();
    }

    try {
        // Check if email already exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            header('Location: ../View/UserAuthetication.php?error=email_exists');
            exit();
        }

        // Insert new user - updated to match database schema
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        // Convert role to proper case to match the database enum
        $role = ucwords($role); // This will make "admin" into "Admin"
        
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $email, $hashedPassword, $role]);

        // Get the new user's ID
        $userId = $pdo->lastInsertId();

        // Log the activity
        logActivity($pdo, $userId, $name, 'User registered');

        // Set session variables and redirect
        $_SESSION['user_id'] = $userId;
        $_SESSION['username'] = $name;
        $_SESSION['role'] = $role;

        // Redirect based on role
        switch ($role) {
            case 'Admin':
                header('Location: ../View/admin.php');
                break;
            case 'Employer':
                header('Location: ../View/employer.php');
                break;
            case 'Job Seeker':
                header('Location: ../View/jobseeker.php');
                break;
            default:
                header('Location: ../View/UserAuthetication.php');
        }
        exit();

    } catch (PDOException $e) {
        error_log("Registration error: " . $e->getMessage());
        header('Location: ../View/UserAuthetication.php?error=registration_failed');
        exit();
    }
} else {
    header('Location: ../View/UserAuthetication.php');
    exit();
}

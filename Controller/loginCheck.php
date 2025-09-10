<?php
session_start();
require_once '../Model/config.php';

// Verify CSRF token
verify_csrf();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        header('Location: ../View/UserAuthetication.php?error=empty_fields');
        exit();
    }

    try {
        // Get user with email
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['name'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['id'] = $user['id'];
            
            // Log the activity
            logActivity($pdo, $user['id'], $user['name'], 'User logged in');
            
            // Redirect based on role
            switch ($user['role']) {
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
        } else {
            header('Location: ../View/UserAuthetication.php?error=invalid_credentials');
            exit();
        }
    } catch (PDOException $e) {
        error_log("Login error: " . $e->getMessage());
        header('Location: ../View/UserAuthetication.php?error=system_error');
        exit();
    }
} else {
    header('Location: ../View/UserAuthetication.php');
    exit();
}
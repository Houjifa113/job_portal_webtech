<?php
require_once '../Model/config.php';

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header('Location: ../View/UserAuthetication.php');
    exit();
}

// Validate user role matches the page they're trying to access
$currentPage = basename($_SERVER['PHP_SELF']);
$userRole = $_SESSION['role'];

switch ($currentPage) {
    case 'admin.php':
        if ($userRole !== 'Admin') {
            header('Location: ../View/UserAuthetication.php');
            exit();
        }
        break;
    case 'employer.php':
        if ($userRole !== 'Employer') {
            header('Location: ../View/UserAuthetication.php');
            exit();
        }
        break;
    case 'jobseeker.php':
        if ($userRole !== 'Job Seeker') {
            header('Location: ../View/UserAuthetication.php');
            exit();
        }
        break;
}